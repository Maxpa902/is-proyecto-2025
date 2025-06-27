<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Notificacion extends Component
{
    public array $notificaciones = [];
    public string $posicion = 'top-right';

    protected $listeners = [
        'mostrar-notificacion' => 'mostrarNotificacion',
        'cerrar-notificacion' => 'cerrarNotificacion',
        'limpiar-notificaciones' => 'limpiarNotificaciones',
    ];

    public function mount()
    {
        // Cargar notificación desde sesión si existe (para redirects)
        if (session()->has('notificacion')) {
            $notificacionSesion = session('notificacion');
            $this->agregarNotificacion($notificacionSesion);
            session()->forget('notificacion');
        }

        // Cargar múltiples notificaciones si existen
        if (session()->has('notificaciones')) {
            $notificacionesSesion = session('notificaciones');
            foreach ($notificacionesSesion as $notif) {
                $this->agregarNotificacion($notif);
            }
            session()->forget('notificaciones');
        }
    }

    #[On('mostrar-notificacion')]
    public function mostrarNotificacion(array $datos): void
    {
        $this->agregarNotificacion($datos);
    }

    public function agregarNotificacion(array $datos): void
    {
        $notificacion = [
            'id' => uniqid('notif_'),
            'tipo' => $datos['tipo'] ?? 'info',
            'titulo' => $datos['titulo'] ?? null,
            'mensaje' => $datos['mensaje'] ?? '',
            'duracion' => $datos['duracion'] ?? 5_000,
            'descartable' => $datos['descartable'] ?? true,
            'persistente' => $datos['persistente'] ?? false,
            'icono' => $datos['icono'] ?? null,
            'timestamp' => now()->timestamp,
            'visible' => true,
        ];

        $this->notificaciones[] = $notificacion;

        // Auto-cerrar si no es persistente
        if (! $notificacion['persistente'] && $notificacion['duracion'] > 0) {
            $this->programarCierre($notificacion['id'], $notificacion['duracion']);
        }
    }

    public function cerrarNotificacion(string $id): void
    {
        $this->notificaciones = array_filter(
            $this->notificaciones,
            fn ($notif) => $notif['id'] !== $id
        );
    }

    public function limpiarNotificaciones(): void
    {
        $this->notificaciones = [];
    }

    public function obtenerIcono(array $notificacion): string
    {
        if ($notificacion['icono']) {
            return $notificacion['icono'];
        }

        $iconosPorTipo = [
            'exito' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>',
            'error' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>',
            'advertencia' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
            'info' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>',
        ];

        return $iconosPorTipo[$notificacion['tipo']] ?? $iconosPorTipo['info'];
    }

    public function obtenerClaseTipo(string $tipo): string
    {
        $clasesPorTipo = [
            'exito' => 'notificacion-exito',
            'error' => 'notificacion-error',
            'advertencia' => 'notificacion-advertencia',
            'info' => 'notificacion-info',
        ];

        return $clasesPorTipo[$tipo] ?? $clasesPorTipo['info'];
    }

    public function render()
    {
        return view('livewire.notificacion', [
            'notificaciones' => $this->notificaciones,
            'posicion' => $this->posicion,
        ]);
    }

    // Métodos helper estáticos para usar desde otros componentes
    public static function exito(string $mensaje, ?string $titulo = null, array $opciones = []): array
    {
        return array_merge([
            'tipo' => 'exito',
            'titulo' => $titulo ?? 'Éxito',
            'mensaje' => $mensaje,
            'duracion' => 4_000,
        ], $opciones);
    }

    public static function error(string $mensaje, ?string $titulo = null, array $opciones = []): array
    {
        return array_merge([
            'tipo' => 'error',
            'titulo' => $titulo ?? 'Error',
            'mensaje' => $mensaje,
            'duracion' => 6_000,
        ], $opciones);
    }

    public static function advertencia(string $mensaje, ?string $titulo = null, array $opciones = []): array
    {
        return array_merge([
            'tipo' => 'advertencia',
            'titulo' => $titulo ?? 'Advertencia',
            'mensaje' => $mensaje,
            'duracion' => 5_000,
        ], $opciones);
    }

    public static function info(string $mensaje, ?string $titulo = null, array $opciones = []): array
    {
        return array_merge([
            'tipo' => 'info',
            'titulo' => $titulo ?? 'Información',
            'mensaje' => $mensaje,
            'duracion' => 4_000,
        ], $opciones);
    }

    protected function programarCierre(string $id, int $duracion): void
    {
        // Usar JavaScript para cerrar después del tiempo especificado
        $this->dispatch('programar-cierre-notificacion', [
            'id' => $id,
            'duracion' => $duracion,
        ]);
    }
}
