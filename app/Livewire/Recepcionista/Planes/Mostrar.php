<?php

namespace App\Livewire\Recepcionista\Planes;

use App\Models\Actividad;
use App\Models\Plan;
use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.recepcionista')]
class Mostrar extends Component
{
    use WithPagination;

    // Filtros y búsqueda
    public string $busqueda = '';
    public string $filtroActividad = '';
    public string $ordenarPor = 'actividad';

    // Estado de carga
    public bool $cargando = false;

    protected $listeners = [
        'planEliminado' => 'actualizarLista',
        'planAsignadoExitosamente' => 'actualizarLista', // ✅ NUEVO: Escuchar cuando se asigna un plan
    ];

    public function mount()
    {
        // Inicialización si es necesaria
    }

    public function getActividades()
    {
        return Actividad::where('estado', 'activa')
            ->orderBy('nombre')
            ->pluck('nombre', 'id')
            ->toArray();
    }

    public function getPlanesConEstadisticas()
    {
        $query = Plan::with('actividad')
            ->withCount([
                'suscripciones as cantidad_clientes_activos' => function ($query) {
                    $query->where('estado', 'activa');
                },
            ]);

        return $query->paginate(10);
    }

    // ✅ MÉTODO ACTUALIZADO: Soportar plan opcional
    public function abrirModalAsignar(?int $planId = null)
    {
        if ($planId) {
            // Si viene con planId, cargar el plan y pasarlo al modal
            $plan = Plan::with('actividad')->findOrFail($planId);
            $this->dispatch('abrirModalAsignarPlan', $plan);
        } else {
            // Si no viene planId, abrir modal para seleccionar plan primero
            $this->dispatch('abrirModalAsignarPlan');
        }
    }

    public function eliminarPlan(Plan $plan)
    {
        try {
            // Verificar si el plan tiene clientes activos
            $clientesActivos = $plan->clientes()->where('estado', 'activo')->count();

            if ($clientesActivos > 0) {
                $this->dispatch('mostrar-notificacion', [
                    'tipo' => 'error',
                    'titulo' => 'No se puede eliminar',
                    'mensaje' => "El plan tiene {$clientesActivos} cliente(s) activo(s).",
                    'duracion' => 5_000,
                ]);

                return;
            }

            $nombrePlan = $plan->actividad->nombre;
            $plan->delete();

            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Plan eliminado',
                'mensaje' => "El plan de {$nombrePlan} ha sido eliminado.",
                'duracion' => 4_000,
            ]);

            $this->actualizarLista();

        } catch (\Exception $e) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error',
                'mensaje' => 'Error al eliminar el plan: ' . $e->getMessage(),
                'duracion' => 6_000,
            ]);
        }
    }

    public function duplicarPlan(Plan $plan)
    {
        try {
            $nuevoPlan = $plan->replicate();
            $nuevoPlan->precio_plan = $plan->precio_plan;
            $nuevoPlan->save();

            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Plan duplicado',
                'mensaje' => 'Se ha creado una copia del plan.',
                'duracion' => 3_000,
            ]);

            $this->actualizarLista();

        } catch (\Exception $e) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error',
                'mensaje' => 'Error al duplicar el plan.',
                'duracion' => 4_000,
            ]);
        }
    }

    public function limpiarFiltros()
    {
        $this->busqueda = '';
        $this->filtroActividad = '';
        $this->resetPage();
    }

    public function actualizarLista()
    {
        $this->resetPage();
    }

    public function getResumenEstadisticas()
    {
        return [
            'total_planes' => Plan::count(),
            'total_clientes_activos' => Usuario::whereHas('suscripciones', function ($query) {
                $query->where('estado', 'activa');
            })->count(),
            'precio_promedio' => Plan::avg('precio_plan'),
            'dias_promedio' => Plan::avg('dias_acceso_actividad'),
        ];
    }

    public function render()
    {
        return view('livewire.recepcionista.planes.mostrar', [
            'planes' => $this->getPlanesConEstadisticas(),
            'actividades' => $this->getActividades(),
            'estadisticas' => $this->getResumenEstadisticas(),
        ]);
    }
}
