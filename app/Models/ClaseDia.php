<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaseDia extends Model
{
    protected $table = 'clase_dias';

    protected $fillable = [
        'id_clase',
        'id_dia_semana',
    ];

    /**
     * Relación con clase
     */
    public function clase(): BelongsTo
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }

    /**
     * Relación con día de semana
     */
    public function diaSemana(): BelongsTo
    {
        return $this->belongsTo(DiaSemana::class, 'id_dia_semana');
    }

    /**
     * Scope para filtrar por clase
     */
    public function scopePorClase(Builder $query, int $idClase): Builder
    {
        return $query->where('id_clase', $idClase);
    }

    /**
     * Scope para filtrar por día
     */
    public function scopePorDia(Builder $query, int $idDiaSemana): Builder
    {
        return $query->where('id_dia_semana', $idDiaSemana);
    }

    /**
     * Scope para filtrar por clave natural
     */
    public function scopePorClaveNatural(Builder $query, int $idClase, int $idDiaSemana): Builder
    {
        return $query->where('id_clase', $idClase)
            ->where('id_dia_semana', $idDiaSemana);
    }

    /**
     * Buscar por clave natural
     */
    public static function buscarPorClaveNatural(int $idClase, int $idDiaSemana): ?self
    {
        return self::porClaveNatural($idClase, $idDiaSemana)->first();
    }

    /**
     * Validar clave natural
     */
    public static function validarClaveNatural(int $idClase, int $idDiaSemana, ?int $excluirId = null): bool
    {
        $query = self::where('id_clase', $idClase)
            ->where('id_dia_semana', $idDiaSemana);

        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }

        return ! $query->exists();
    }
}
