<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sesion extends Model
{
    protected $table = 'sesiones';

    protected $fillable = [
        'id_clase',
        'numero_sesion',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Relación con clase
     */
    public function clase(): BelongsTo
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }

    /**
     * Acceso a actividad a través de clase
     */
    public function actividad(): BelongsTo
    {
        return $this->clase->actividad();
    }

    /**
     * Acceso a actividad a través de clase
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_sesion');
    }

    /**
     * Scope para buscar por clave natural
     */
    public function scopePorClaveNatural(Builder $query, int $idClase, int $numeroSesion): Builder
    {
        return $query->where('id_clase', $idClase)
            ->where('numero_sesion', $numeroSesion);
    }

    /**
     * Obtener estadísticas de sesiones
     *
     * @return array{hoy: int, mes: int, semana: int}
     */
    public static function obtenerEstadisticasSesiones(): array
    {
        $hoy = now()->toDateString();

        $inicioSemana = now()->startOfWeek()->toDateString(); // lunes
        $finSemana = now()->endOfWeek()->toDateString();     // domingo

        $finMes = now()->endOfMonth()->toDateString();       // último día del mes

        return [
            'hoy' => self::where('fecha', $hoy)->count(),
            'semana' => self::whereBetween('fecha', [$inicioSemana, $finSemana])->count(),
            'mes' => self::whereBetween('fecha', [$hoy, $finMes])->count(),
        ];
    }

    /**
     * Método estático para buscar por clave natural completa
     */
    public static function buscarPorClaveCompleta(int $idActividad, int $numeroClase, int $numeroSesion): ?self
    {
        $clase = Clase::buscarPorClaveNatural($idActividad, $numeroClase);

        if (! $clase) {
            return null;
        }

        return self::porClaveNatural($clase->id, $numeroSesion)->first();
    }

    /**
     * Validar que no exista otra sesión con la misma clave natural
     */
    public static function validarClaveNatural(int $idClase, int $numeroSesion, ?int $excluirId = null): bool
    {
        $query = self::where('id_clase', $idClase)
            ->where('numero_sesion', $numeroSesion);

        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }

        return ! $query->exists();
    }

    /**
     * Obtener información completa de la clave natural
     */
    public function getClaveNaturalCompleta(): array
    {
        return [
            'id_actividad' => $this->clase->id_actividad,
            'numero_clase' => $this->clase->numero_clase,
            'numero_sesion' => $this->numero_sesion,
        ];
    }
}
