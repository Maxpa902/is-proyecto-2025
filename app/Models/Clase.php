<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clase extends Model
{
    public const ESTADO_ACTIVA = 'activa';
    public const ESTADO_INACTIVA = 'inactiva';
    public const ESTADOS_VALIDOS = [
        self::ESTADO_ACTIVA,
        self::ESTADO_INACTIVA,
    ];

    protected $table = 'clases';

    protected $fillable = [
        'id_actividad',
        'numero_clase',
        'hora_inicio',
        'hora_fin',
        'capacidad_maxima',
        'estado',
        'nombre_completo_profesor',
        'lugar',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'estado' => 'string',
    ];

    /**
     * Relación con actividad
     */
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }

    /**
     * Relación uno a muchos con sesiones
     */
    public function sesiones(): HasMany
    {
        return $this->hasMany(Sesion::class, 'id_clase');
    }

    /**
     * Relación muchos a muchos con días de la semana
     */
    public function dias()
    {
        return $this->belongsToMany(DiaSemana::class, 'clase_dias', 'id_clase', 'id_dia_semana');
    }

    /**
     * Scope para buscar por clave natural
     */
    public function scopePorClaveNatural(Builder $query, int $idActividad, int $numeroClase): Builder
    {
        return $query->where('id_actividad', $idActividad)
            ->where('numero_clase', $numeroClase);
    }

    /**
     * Método estático para buscar por clave natural
     */
    public static function buscarPorClaveNatural(int $idActividad, int $numeroClase): ?self
    {
        return self::porClaveNatural($idActividad, $numeroClase)->first();
    }

    /**
     * Crear nueva sesión para esta clase
     */
    public function crearSesion(string $fecha): Sesion
    {
        $numeroSesion = $this->siguienteNumeroSesion();

        return $this->sesiones()->create([
            'numero_sesion' => $numeroSesion,
            'fecha' => $fecha,
        ]);
    }

    /**
     * Obtener próximo número de sesión disponible
     */
    public function siguienteNumeroSesion(): int
    {
        $ultimaSesion = $this->sesiones()->max('numero_sesion');

        return ($ultimaSesion ?? 0) + 1;
    }

    /**
     * Generar sesiones automáticamente para un rango de fechas
     */
    public function generarSesionesEnRango(string $fechaInicio, string $fechaFin): int
    {
        if ($this->estado !== self::ESTADO_ACTIVA) {
            return 0;
        }

        $inicio = Carbon::parse($fechaInicio);
        $fin = Carbon::parse($fechaFin);
        $sesionesCreadas = 0;

        // Obtener días de la semana de esta clase
        $diasSemana = $this->dias->pluck('orden')->toArray();

        foreach ($diasSemana as $diaSemana) {
            $fechas = $this->calcularFechasParaDia($diaSemana, $inicio, $fin);

            foreach ($fechas as $fecha) {
                if (! $this->tieneSesionEnFecha($fecha)) {
                    $this->crearSesion($fecha->format('Y-m-d'));
                    $sesionesCreadas++;
                }
            }
        }

        return $sesionesCreadas;
    }

    /**
     * Verificar si existe sesión en una fecha específica
     */
    public function tieneSesionEnFecha(Carbon $fecha): bool
    {
        return $this->sesiones()
            ->where('fecha', $fecha->format('Y-m-d'))
            ->exists();
    }

    /**
     * Obtener próximas sesiones programadas
     */
    public function proximasSesiones(int $limite = 10): Collection
    {
        return $this->sesiones()
            ->where('fecha', '>=', Carbon::today())
            ->orderBy('fecha')
            ->limit($limite)
            ->get();
    }

    /**
     * Obtener sesiones en un mes específico
     */
    public function sesionesDelMes(int $año, int $mes): Collection
    {
        return $this->sesiones()
            ->whereYear('fecha', $año)
            ->whereMonth('fecha', $mes)
            ->orderBy('fecha')
            ->get();
    }

    /**
     * Eliminar sesiones futuras (para regenerar)
     */
    public function limpiarSesionesFuturas(): int
    {
        return $this->sesiones()
            ->where('fecha', '>', Carbon::today())
            ->delete();
    }

    /**
     * Generar sesiones para los próximos N meses
     */
    public function generarSesionesProximosMeses(int $meses = 1): int
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin = Carbon::now()->addMonths($meses)->endOfMonth();

        return $this->generarSesionesEnRango(
            $inicio->format('Y-m-d'),
            $fin->format('Y-m-d')
        );
    }

    /**
     * Validar que no exista otra clase con la misma clave natural
     */
    public static function validarClaveNatural(int $idActividad, int $numeroClase, ?int $excluirId = null): bool
    {
        $query = self::where('id_actividad', $idActividad)
            ->where('numero_clase', $numeroClase);

        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }

        return ! $query->exists();
    }

    /**
     * Calcular fechas que coinciden con un día específico de la semana
     */
    private function calcularFechasParaDia(int $diaSemana, Carbon $inicio, Carbon $fin): array
    {
        $fechas = [];

        // Convertir al formato Carbon (0=domingo, 1=lunes...6=sábado)
        $diaCarbon = $diaSemana === 7 ? 0 : $diaSemana;

        // Encontrar primera ocurrencia
        $fechaActual = $inicio->copy();
        while ($fechaActual->dayOfWeek !== $diaCarbon && $fechaActual->lte($fin)) {
            $fechaActual->addDay();
        }

        // Recopilar todas las ocurrencias
        while ($fechaActual->lte($fin)) {
            $fechas[] = $fechaActual->copy();
            $fechaActual->addWeek();
        }

        return $fechas;
    }
}
