<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $table = 'planes';

    protected $fillable = [
        'id_actividad',
        'precio_plan',
        'dias_acceso_actividad',
    ];

    protected $casts = [
        'precio_plan' => 'decimal:2',
        'dias_acceso_actividad' => 'integer',
    ];

    /**
     * Relación con actividad
     */
    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }

    /**
     * Relación con clientes
     */
    public function clientes(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'suscripciones', 'id_plan', 'id_usuario');
    }

    /**
     * Relación con suscripciones
     */
    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'id_plan');
    }

    /**
     * Scope para filtrar por actividad
     */
    public function scopePorActividad(Builder $query, int $idActividad): Builder
    {
        return $query->where('id_actividad', $idActividad);
    }

    /**
     * Scope para ordenar por precio
     */
    public function scopeOrdenadoPorPrecio(Builder $query, string $direccion = 'asc'): Builder
    {
        return $query->orderBy('precio_plan', $direccion);
    }

    /**
     * Accessor para precio formateado
     */
    public function getPrecioFormateadoAttribute(): string
    {
        return '$' . number_format((float) $this->precio_plan, 2, ',', '.');
    }

    /**
     * Accessor para descripción del plan
     */
    public function getDescripcionAttribute(): string
    {
        return "Plan {$this->actividad->nombre} - {$this->dias_acceso_actividad} días";
    }

    /**
     * Calcular precio por día
     */
    public function getPrecioPorDiaAttribute(): float
    {
        return round($this->precio_plan / $this->dias_acceso_actividad, 2);
    }

    /**
     * Verificar si el plan está activo (tiene la actividad activa)
     */
    public function estaActivo(): bool
    {
        return $this->actividad->estado === Actividad::ESTADO_ACTIVA;
    }

    public static function obtenerEstadisticasPlanes()
    {
        return [
            'totales' => self::count(),
            'asignados' => self::has('suscripciones')->count(),
        ];
    }
}
