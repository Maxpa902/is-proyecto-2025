<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    public const ESTADO_ACTIVA = 'activa';
    public const ESTADO_INACTIVA = 'inactiva';
    public const ESTADOS_VALIDOS = [
        self::ESTADO_ACTIVA,
        self::ESTADO_INACTIVA,
    ];

    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    /**
     * Relación uno a muchos con clases
     */
    public function clases(): HasMany
    {
        return $this->hasMany(Clase::class, 'id_actividad');
    }

    public function planes(): HasMany
    {
        return $this->hasMany(Plan::class, 'id_actividad');
    }

    /**
     * Obtener clases activas
     */
    public function clasesActivas(): HasMany
    {
        return $this->clases()->where('estado', 'activa');
    }

    /**
     * Buscar clase por número
     */
    public function buscarClase(int $numeroClase): ?Clase
    {
        return $this->clases()->where('numero_clase', $numeroClase)->first();
    }

    /**
     * Obtener siguiente número de clase
     */
    public function siguienteNumeroClase(): int
    {
        $ultimaClase = $this->clases()
            ->orderByDesc('numero_clase')
            ->first();

        return $ultimaClase
            ? $ultimaClase->numero_clase + 1
            : 1;
    }

    /**
     * Crear clase
     *
     * @param array $datos Atributos adicionales para la nueva clase
     */
    public function crearClase(array $datos = [], array $dias = []): Clase
    {
        $datos['numero_clase'] = $this->siguienteNumeroClase();

        $clase = $this->clases()->create($datos);
        $clase->dias()->attach($dias);

        return $clase;
    }

    /**
     * Verificar conflictos de horarios y devolver detalles específicos
     */
    public function verificarConflictosDetallados(array $dias, string $horaInicio, string $horaFin, ?int $excluirClaseId = null): array
    {
        $clasesConflictivas = $this->clases()
            ->with(['dias']) // Cargar relación días
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where(function ($q) use ($horaInicio, $horaFin) {
                    $q->where('hora_inicio', '<', $horaFin)
                        ->where('hora_fin', '>', $horaInicio);
                });
            })
            ->whereHas('dias', function ($query) use ($dias) {
                $query->whereIn('dias_semana.id', $dias);
            })
            ->when($excluirClaseId, function ($query) use ($excluirClaseId) {
                $query->where('id', '!=', $excluirClaseId);
            })
            ->get();

        $conflictos = [];

        foreach ($clasesConflictivas as $clase) {
            // Obtener días que chocan
            $diasEnConflicto = $clase->dias->whereIn('id', $dias);

            foreach ($diasEnConflicto as $dia) {
                $conflictos[] = [
                    'clase_id' => $clase->id,
                    'clase_nombre' => 'Clase #' . $clase->numero_clase,
                    'dia_id' => $dia->id,
                    'dia_nombre' => $dia->nombre,
                    'hora_inicio_conflictiva' => Carbon::parse($clase->hora_inicio)->format('H:i'),
                    'hora_fin_conflictiva' => Carbon::parse($clase->hora_fin)->format('H:i'),
                    'hora_inicio_nueva' => $horaInicio,
                    'hora_fin_nueva' => $horaFin,
                    'tipo_conflicto' => $this->determinarTipoConflicto($horaInicio, $horaFin, $clase->hora_inicio, $clase->hora_fin),
                ];
            }
        }

        return $conflictos;
    }

    /**
     * Función auxiliar para verificar si hay conflictos (mantiene compatibilidad)
     */
    public function verificarClaseExistente(array $dias, string $horaInicio, string $horaFin, ?int $excluirClaseId = null): bool
    {
        $conflictos = $this->verificarConflictosDetallados($dias, $horaInicio, $horaFin, $excluirClaseId);

        return ! empty($conflictos);
    }

    /**
     * Determinar el tipo de conflicto horario
     */
    private function determinarTipoConflicto(string $horaInicioNueva, string $horaFinNueva, $horaInicioExistente, $horaFinExistente): string
    {
        // Convertir las horas existentes (que pueden ser datetime) a formato H:i para comparar
        $horaInicioExistente = Carbon::parse($horaInicioExistente)->format('H:i');
        $horaFinExistente = Carbon::parse($horaFinExistente)->format('H:i');

        // Solapamiento total (nueva clase cubre completamente la existente)
        if ($horaInicioNueva <= $horaInicioExistente && $horaFinNueva >= $horaFinExistente) {
            return 'solapamiento_total';
        }

        // Solapamiento parcial al inicio
        if ($horaInicioNueva < $horaInicioExistente && $horaFinNueva > $horaInicioExistente && $horaFinNueva < $horaFinExistente) {
            return 'solapamiento_inicio';
        }

        // Solapamiento parcial al final
        if ($horaInicioNueva > $horaInicioExistente && $horaInicioNueva < $horaFinExistente && $horaFinNueva > $horaFinExistente) {
            return 'solapamiento_final';
        }

        // Solapamiento interno (nueva clase está dentro de la existente)
        if ($horaInicioNueva >= $horaInicioExistente && $horaFinNueva <= $horaFinExistente) {
            return 'solapamiento_interno';
        }

        return 'solapamiento_desconocido';
    }
}
