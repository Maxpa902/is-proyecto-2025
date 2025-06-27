<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscripcion extends Model
{
    // Constantes
    public const ESTADO_CONFIRMADA = 'confirmada';
    public const ESTADO_CANCELADA = 'cancelada';
    public const ESTADOS_VALIDOS = [
        self::ESTADO_CONFIRMADA,
        self::ESTADO_CANCELADA,
    ];

    protected $table = 'inscripciones';

    protected $fillable = [
        'id_cliente',
        'id_sesion',
        'fecha_hora_inscripcion',
        'estado',
    ];

    protected $casts = [
        'fecha_hora_inscripcion' => 'datetime',
    ];

    protected $attributes = [
        'estado' => self::ESTADO_CONFIRMADA,
    ];

    /**
     * Relación con cliente (usuario)
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_cliente');
    }

    /**
     * Relación con sesión
     */
    public function sesion(): BelongsTo
    {
        return $this->belongsTo(Sesion::class, 'id_sesion');
    }

    /**
     * Acceso a clase a través de sesión
     */
    public function clase()
    {
        return $this->sesion->clase();
    }

    /**
     * Acceso a actividad a través de sesión
     */
    public function actividad()
    {
        return $this->sesion->clase->actividad();
    }

    /**
     * Scope por estado
     */
    public function scopePorEstado(Builder $query, string $estado): Builder
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para inscripciones confirmadas
     */
    public function scopeConfirmadas(Builder $query): Builder
    {
        return $query->where('estado', self::ESTADO_CONFIRMADA);
    }

    /**
     * Scope por clave natural
     */
    public function scopePorClaveNatural(Builder $query, int $idCliente, int $idSesion): Builder
    {
        return $query->where('id_cliente', $idCliente)
            ->where('id_sesion', $idSesion);
    }

    /**
     * Buscar por clave natural
     */
    public static function buscarPorClaveNatural(int $idCliente, int $idSesion): ?self
    {
        return self::porClaveNatural($idCliente, $idSesion)->first();
    }

    /**
     * Validar clave natural
     */
    public static function validarClaveNatural(int $idCliente, int $idSesion, ?int $excluirId = null): bool
    {
        $query = self::where('id_cliente', $idCliente)
            ->where('id_sesion', $idSesion)
            ->where('estado', '!=', self::ESTADO_CANCELADA);

        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }

        return $query->exists();
    }

    /**
     * Cancelar inscripción
     */
    public function cancelar(): bool
    {
        return $this->update(['estado' => self::ESTADO_CANCELADA]);
    }

    /**
     * Verificar si puede cancelarse
     */
    public function puedeCancelarse(): bool
    {
        // Solo si está confirmada y la sesión es futura
        return $this->estado === self::ESTADO_CONFIRMADA &&
            $this->sesion->fecha >= now()->toDateString();
    }

    /**
     * Obtener información completa
     */
    public function getInformacionCompleta(): array
    {
        return [
            'cliente' => $this->cliente->nombre_completo,
            'actividad' => $this->sesion->clase->actividad->nombre,
            'clase' => $this->sesion->clase->numero_clase,
            'sesion' => $this->sesion->numero_sesion,
            'fecha' => $this->sesion->fecha,
            'horario' => "{$this->sesion->clase->hora_inicio} - {$this->sesion->clase->hora_fin}",
            'lugar' => $this->sesion->clase->lugar,
            'estado' => $this->estado,
            'fecha_inscripcion' => $this->fecha_hora_inscripcion,
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inscripcion) {
            if (! $inscripcion->fecha_hora_inscripcion) {
                $inscripcion->fecha_hora_inscripcion = now();
            }
        });
    }
}
