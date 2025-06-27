<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoUsuario extends Model
{
    public const ESTADO_ACTIVO = ['id' => 1, 'nombre' => 'activo'];
    public const ESTADO_INACTIVO = ['id' => 2, 'nombre' => 'inactivo'];

    protected $table = 'estados_usuario';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación uno a muchos con usuarios
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'id_estado_usuario');
    }

    /**
     * Scope para obtener estado por nombre
     */
    public function scopePorNombre($query, string $nombre)
    {
        return $query->where('nombre', $nombre);
    }

    /**
     * Verificar si es estado activo
     */
    public function esActivo(): bool
    {
        return strtolower($this->nombre) === strtolower(self::ESTADO_ACTIVO['nombre']);
    }
}
