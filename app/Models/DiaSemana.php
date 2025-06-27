<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiaSemana extends Model
{
    public const LUNES = ['id' => 1, 'nombre' => 'lunes'];
    public const MARTES = ['id' => 2, 'nombre' => 'martes'];
    public const MIERCOLES = ['id' => 3, 'nombre' => 'miercoles'];
    public const JUEVES = ['id' => 4, 'nombre' => 'jueves'];
    public const VIERNES = ['id' => 5, 'nombre' => 'viernes'];
    public const SABADO = ['id' => 6, 'nombre' => 'sabado'];
    public const DOMINGO = ['id' => 7, 'nombre' => 'domingo'];

    protected $table = 'dias_semana';

    protected $fillable = [
        'nombre',
        'orden',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    /**
     * Relación con clase_dias
     */
    public function claseDias(): HasMany
    {
        return $this->hasMany(ClaseDia::class, 'id_dia_semana');
    }

    /**
     * Relación con clases a través de clase_dias
     */
    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'clase_dias', 'id_dia_semana', 'id_clase');
    }

    /**
     * Scope para ordenar por orden de semana
     */
    public function scopeOrdenadoPorSemana(Builder $query): Builder
    {
        return $query->orderBy('orden');
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopePorNombre(Builder $query, string $nombre): Builder
    {
        return $query->where('nombre', $nombre);
    }

    /**
     * Método estático para obtener días ordenados
     */
    public static function ordenados(): array
    {
        return self::ordenadoPorSemana()->pluck('nombre', 'id')->toArray();
    }

    /**
     * Accessor para nombre corto
     */
    public function getNombreCortoAttribute(): string
    {
        return substr($this->nombre, 0, 3);
    }

    /**
     * Accessor para nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return ucwords($this->nombre);
    }
}
