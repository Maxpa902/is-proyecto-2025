<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use HasFactory, HasRoles;

    // Constantes
    public const SEXO_MASCULINO = 'M';
    public const SEXO_FEMENINO = 'F';
    public const SEXOS_VALIDOS = [
        self::SEXO_MASCULINO,
        self::SEXO_FEMENINO,
    ];
    protected $table = 'usuarios';

    protected $guard_name = 'web';

    protected $fillable = [
        'id_estado_usuario',
        'dni',
        'nombre',
        'apellido',
        'email',
        'password',
        'altura',
        'peso',
        'telefono',
        'sexo',
        'fecha_nacimiento',
        'fecha_registro',
        'fecha_dado_baja',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'altura' => 'decimal:2',
        'peso' => 'decimal:2',
        'fecha_nacimiento' => 'date',
        'fecha_registro' => 'date',
        'fecha_dado_baja' => 'date',
        'password' => 'hashed',
    ];

    /**
     * Relación con estado de usuario
     */
    public function estadoUsuario(): BelongsTo
    {
        return $this->belongsTo(EstadoUsuario::class, 'id_estado_usuario');
    }

    /**
     * Relación con suscripciones
     */
    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'id_usuario');
    }

    /**
     * Relación con planes
     */
    public function planes(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'suscripciones', 'id_usuario', 'id_plan');
    }

    /**
     * Relación con inscripciones
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_cliente');
    }

    /**
     * Obtener el nombre del guard
     */
    public function getGuardName(): string
    {
        return 'web';
    }

    /**
     * Accessor para nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Accessor para edad
     */
    public function getEdadAttribute(): int
    {
        return Carbon::parse((string) $this->fecha_nacimiento)->age;
    }

    public function getSexoCompletoAttribute()
    {
        return $this->sexo === self::SEXO_MASCULINO ? 'Masculino' : 'Femenino';
    }

    /**
     * Accessor para IMC
     */
    public function getImcAttribute(): ?float
    {
        if (! $this->altura || ! $this->peso) {
            return null;
        }

        $alturaMetros = $this->altura / 100;

        return round($this->peso / ($alturaMetros * $alturaMetros), 2);
    }

    /**
     * Mutator para email (siempre en minúsculas)
     */
    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Mutator para nombre y apellido (formato título)
     */
    public function setNombreAttribute(string $value): void
    {
        $this->attributes['nombre'] = ucwords(strtolower($value));
    }

    public function setApellidoAttribute(string $value): void
    {
        $this->attributes['apellido'] = ucwords(strtolower($value));
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActivos(Builder $query): Builder
    {
        return $query->whereHas('estadoUsuario', function ($q) {
            $q->where('nombre', EstadoUsuario::ESTADO_ACTIVO['nombre']);
        })->whereNull('fecha_dado_baja');
    }

    /**
     * Scope para buscar por DNI
     */
    public function scopePorDni(Builder $query, string $dni): Builder
    {
        return $query->where('dni', $dni);
    }

    /**
     * Scope para buscar por nombre completo
     */
    public function scopePorNombreCompleto(Builder $query, string $busqueda): Builder
    {
        return $query->where(function ($q) use ($busqueda) {
            $q->whereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$busqueda}%"])
                ->orWhereRaw("CONCAT(apellido, ' ', nombre) LIKE ?", ["%{$busqueda}%"]);
        });
    }

    /**
     * Scope para usuarios nuevos este mes
     */
    public function scopeNuevosEsteMes(Builder $query): Builder
    {
        $ahora = now();

        return $query->whereMonth('fecha_registro', $ahora->month)
            ->whereYear('fecha_registro', $ahora->year);
    }

    /**
     *  Scope para usuarios inactivos
     */
    public function scopeInactivos(Builder $query): Builder
    {
        return $query->whereHas('estadoUsuario', function ($q) {
            $q->where('nombre', EstadoUsuario::ESTADO_INACTIVO['nombre']);
        })->orWhereNotNull('fecha_dado_baja');
    }

    /**
     * Verificar si el usuario está activo
     */
    public function estaActivo(): bool
    {
        return $this->estadoUsuario->esActivo() && ! $this->fecha_dado_baja;
    }

    /**
     * Dar de baja al usuario
     */
    public function darDeBaja(): bool
    {
        return $this->update([
            'fecha_dado_baja' => now(),
            'id_estado_usuario' => EstadoUsuario::ESTADO_INACTIVO['id'],
        ]);
    }

    /**
     * Reactivar usuario
     */
    public function reactivar(): bool
    {
        return $this->update(['fecha_dado_baja' => null, 'id_estado_usuario' => EstadoUsuario::ESTADO_ACTIVO['id']]);
    }

    /**
     * Obtener suscripciones activas
     */
    public function suscripcionesActivas(): HasMany
    {
        return $this->suscripciones()
            ->where('fecha_fin', '>=', now());
    }

    /**
     * Verificar si tiene suscripción activa para una actividad
     */
    public function tieneSuscripcionActiva(int $idActividad): bool
    {
        return $this->suscripcionesActivas()
            ->whereHas('plan', function ($q) use ($idActividad) {
                $q->where('id_actividad', $idActividad);
            })->exists();
    }

    // Ordena primero los que están activos (booleano), luego los demás
    public function scopeOrderByActivo(Builder $query): Builder
    {

        return $query->orderByRaw('CASE WHEN id_estado_usuario = ? AND fecha_dado_baja IS NULL THEN 0 ELSE 1 END', [EstadoUsuario::ESTADO_ACTIVO['id']]);
    }
    /**
     * Obtener estadísticas de usuarios
     */
    public static function obtenerEstadisticasUsuarios(): array
    {
        // obtener clientes, no usaurios que pueden ser recepcionistas
        return [
            'activos' => self::role('cliente')->activos()->count(),
            'nuevos_mes' => self::role('cliente')->nuevosEsteMes()->count(),
            'inactivos' => self::role('cliente')->inactivos()->count(),
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            if (! $usuario->fecha_registro) {
                $usuario->fecha_registro = now()->toDateString();
            }
        });
    }
}
