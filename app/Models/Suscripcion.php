<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suscripcion extends Model
{
    public const ESTADO_ACTIVA = 'activa';
    public const ESTADO_VENCIDA = 'vencida';
    public const ESTADO_CANCELADA = 'cancelada';
    public const ESTADOS_VALIDOS = [
        self::ESTADO_ACTIVA,
        self::ESTADO_VENCIDA,
        self::ESTADO_CANCELADA,
    ];
    public $timestamps = true;

    protected $table = 'suscripciones';

    protected $fillable = [
        'id_plan',
        'id_usuario',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    protected $attributes = [
        'estado' => self::ESTADO_ACTIVA,
    ];

    /**
     * Relación con plan
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }

    /**
     * Relación con usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Acceso a actividad a través del plan
     */
    public function actividad()
    {
        return $this->plan->actividad();
    }

    /**
     * Scope para suscripciones activas
     */
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('estado', self::ESTADO_ACTIVA)
            ->where('fecha_fin', '>=', now());
    }

    /**
     * Scope para suscripciones vencidas
     */
    public function scopeVencidas(Builder $query): Builder
    {
        return $query->where('fecha_fin', '<', now())
            ->where('estado', '!=', self::ESTADO_CANCELADA);
    }

    /**
     * Scope por clave natural
     */
    public function scopePorClaveNatural(Builder $query, int $idPlan, int $idUsuario): Builder
    {
        return $query->where('id_plan', $idPlan)
            ->where('id_usuario', $idUsuario);
    }

    /**
     * Buscar por clave natural
     */
    public static function buscarPorClaveNatural(int $idPlan, int $idUsuario): ?self
    {
        return self::porClaveNatural($idPlan, $idUsuario)->first();
    }

    /**
     * Validar clave natural
     */
    public static function validarClaveNatural(int $idPlan, int $idUsuario, ?int $excluirId = null): bool
    {
        $query = self::where('id_plan', $idPlan)
            ->where('id_usuario', $idUsuario)
            ->where('estado', self::ESTADO_ACTIVA);

        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }

        return ! $query->exists();
    }

    /**
     * Verificar si la suscripción está activa
     */
    public function estaActiva(): bool
    {
        return $this->estado === self::ESTADO_ACTIVA &&
            $this->fecha_fin >= now();
    }

    /**
     * Verificar si la suscripción está vencida
     */
    public function estaVencida(): bool
    {
        return $this->fecha_fin < now();
    }

    /**
     * Cancelar suscripción
     */
    public function cancelar(): bool
    {
        return $this->update(['estado' => self::ESTADO_CANCELADA]);
    }

    /**
     * Renovar suscripción
     */
    public function renovar(): self
    {
        return self::create([
            'id_plan' => $this->id_plan,
            'id_usuario' => $this->id_usuario,
            'fecha_inicio' => $this->fecha_fin->addDay(),
        ]);
    }

    /**
     * Días restantes
     */
    public function getDiasRestantesAttribute(): int
    {
        if ($this->estaVencida()) {
            return 0;
        }

        return max(0, now()->diffInDays($this->fecha_fin, false));
    }
}
