<?php

namespace App\Livewire;

use App\Models\Actividad;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ModalAsignarPlan extends Component
{
    // Props del modal
    public bool $mostrar = false;
    public string $paso = 'plan'; // 'plan' o 'cliente'

    // Props para selección de plan
    public ?Plan $plan = null;
    public string $busquedaPlan = '';
    public ?int $actividadSeleccionada = null;
    public array $actividadesDisponibles = [];
    public array $planesDisponibles = [];
    public string $vistaPlanes = 'actividades'; // 'actividades' o 'busqueda'

    // Props para selección de cliente
    public string $busquedaCliente = '';
    public array $clientesBusqueda = [];
    public int $clienteSeleccionado = 0;

    // Estados de carga
    public bool $cargandoPlanes = false;
    public bool $cargandoBusqueda = false;
    public bool $cargandoAsignacion = false;

    protected $listeners = [
        'abrirModalAsignarPlan' => 'abrir',
        'cerrarModalAsignarPlan' => 'cerrar',
    ];

    public function rules()
    {
        return [
            'clienteSeleccionado' => 'required|integer|min:1|exists:usuarios,id',
        ];
    }

    public function mount()
    {
        $this->cargarActividades();
    }

    // ✅ MÉTODO CORREGIDO: Manejar diferentes tipos de parámetros
    public function abrir(...$params)
    {
        Log::info('🚀 Modal abrir() ejecutado con parámetros: ' . json_encode($params));

        $this->mostrar = true;

        // Si el primer parámetro es un Plan o un ID de plan
        $planPreseleccionado = null;

        if (! empty($params)) {
            $primerParam = $params[0];

            if ($primerParam instanceof Plan) {
                $planPreseleccionado = $primerParam;
            } elseif (is_numeric($primerParam)) {
                $planPreseleccionado = Plan::with('actividad')->find($primerParam);
            } elseif (is_array($primerParam) && isset($primerParam['id'])) {
                $planPreseleccionado = Plan::with('actividad')->find($primerParam['id']);
            }
        }

        Log::info('📋 Plan preseleccionado: ' . ($planPreseleccionado ? $planPreseleccionado->actividad->nombre : 'null'));

        if ($planPreseleccionado) {
            // Si viene con plan, ir directo al paso de cliente
            $this->plan = $planPreseleccionado;
            $this->paso = 'cliente';
            Log::info('👤 Modal abierto en paso: cliente');
        } else {
            // Si no viene plan, empezar con selección de plan
            $this->paso = 'plan';
            $this->plan = null;
            Log::info('📋 Modal abierto en paso: plan');
        }

        $this->limpiarFormulario();
        Log::info('✅ Modal configurado correctamente, mostrar = ' . ($this->mostrar ? 'true' : 'false'));
    }

    // ✅ NUEVO: Método para JavaScript
    public function abrirDesdeJS(?int $planId = null)
    {
        Log::info('🔥 abrirDesdeJS ejecutado con planId: ' . ($planId ?? 'null'));

        if ($planId) {
            $plan = Plan::with('actividad')->find($planId);
            $this->abrir($plan);
        } else {
            $this->abrir();
        }
    }

    public function cerrar()
    {
        $this->mostrar = false;
        $this->plan = null;
        $this->paso = 'plan';
        $this->limpiarFormulario();
    }

    public function limpiarFormulario()
    {
        // Limpiar datos de plan
        $this->busquedaPlan = '';
        $this->actividadSeleccionada = null;
        $this->planesDisponibles = [];
        $this->vistaPlanes = 'actividades';

        // Limpiar datos de cliente
        $this->busquedaCliente = '';
        $this->clientesBusqueda = [];
        $this->clienteSeleccionado = 0;

        // Limpiar estados
        $this->cargandoPlanes = false;
        $this->cargandoBusqueda = false;
        $this->cargandoAsignacion = false;
    }

    public function cargarActividades()
    {
        $this->actividadesDisponibles = Actividad::where('estado', 'activa')
            ->withCount(['planes'])
            ->having('planes_count', '>', 0)
            ->orderBy('nombre')
            ->get()
            ->toArray();
    }

    public function seleccionarActividad(int $actividadId)
    {
        $this->actividadSeleccionada = $actividadId;
        $this->cargarPlanesPorActividad($actividadId);
    }

    public function cargarPlanesPorActividad(int $actividadId)
    {
        $this->cargandoPlanes = true;

        $this->planesDisponibles = Plan::where('id_actividad', $actividadId)
            ->with('actividad')
            ->orderBy('precio_plan')
            ->get()
            ->toArray();

        $this->cargandoPlanes = false;
    }

    public function updatedBusquedaPlan()
    {
        if (strlen($this->busquedaPlan) >= 2) {
            $this->vistaPlanes = 'busqueda';
            $this->buscarPlanes();
        } else {
            $this->vistaPlanes = 'actividades';
            $this->planesDisponibles = [];
        }
    }

    public function buscarPlanes()
    {
        $this->cargandoPlanes = true;

        $this->planesDisponibles = Plan::with('actividad')
            ->where(function ($query) {
                $query->whereHas('actividad', function ($subQuery) {
                    $subQuery->where('nombre', 'like', '%' . $this->busquedaPlan . '%');
                });
            })
            ->orderBy('precio_plan')
            ->limit(10)
            ->get()
            ->toArray();

        $this->cargandoPlanes = false;
    }

    public function seleccionarPlan(int $planId)
    {
        $this->plan = Plan::with('actividad')->findOrFail($planId);
        $this->paso = 'cliente';
        $this->clienteSeleccionado = 0;
    }

    public function volverAPlan()
    {
        $this->paso = 'plan';
        $this->plan = null;
    }

    public function alternarVistaPlanes()
    {
        $this->vistaPlanes = $this->vistaPlanes === 'actividades' ? 'busqueda' : 'actividades';
        $this->busquedaPlan = '';
        $this->planesDisponibles = [];
        $this->actividadSeleccionada = null;
    }

    public function updatedBusquedaCliente()
    {
        $this->clienteSeleccionado = 0;
        $this->buscarClientes();
    }

    public function buscarClientes()
    {
        if (strlen($this->busquedaCliente) < 2) {
            $this->clientesBusqueda = [];

            return;
        }

        $this->cargandoBusqueda = true;

        $this->clientesBusqueda = Usuario::where('nombre', 'like', '%' . $this->busquedaCliente . '%')
            ->orWhere('apellido', 'like', '%' . $this->busquedaCliente . '%')
            ->orWhere('email', 'like', '%' . $this->busquedaCliente . '%')
            ->orWhere('telefono', 'like', '%' . $this->busquedaCliente . '%')
            ->limit(10)
            ->get(['id', 'nombre', 'apellido', 'email', 'telefono'])
            ->toArray();

        $this->cargandoBusqueda = false;
    }

    public function seleccionarCliente(int $clienteId)
    {
        $this->clienteSeleccionado = $clienteId;
    }

    public function asignarPlan()
    {
        $this->validate();

        if (! $this->plan) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error',
                'mensaje' => 'No hay plan seleccionado.',
                'duracion' => 4_000,
            ]);

            return;
        }

        $this->cargandoAsignacion = true;

        try {
            $cliente = Usuario::findOrFail($this->clienteSeleccionado);

            if ($cliente->tieneSuscripcionActiva($this->plan->id_actividad)) {
                $this->dispatch('mostrar-notificacion', [
                    'tipo' => 'advertencia',
                    'titulo' => 'Suscripción activa',
                    'mensaje' => "El cliente ya tiene una suscripción activa para {$this->plan->actividad->nombre}.",
                    'duracion' => 4_000,
                ]);

                return;
            }

            $fecha_hoy = Carbon::now();

            Suscripcion::create([
                'id_usuario' => $cliente->id,
                'id_plan' => $this->plan->id,
                'fecha_inicio' => $fecha_hoy->toDateString(),
                'fecha_fin' => $fecha_hoy->addDays($this->plan->dias_acceso_actividad)->toDateString(),
                'estado' => Suscripcion::ESTADO_ACTIVA,
            ]);

            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Plan asignado',
                'mensaje' => "Plan de {$this->plan->actividad->nombre} asignado a {$cliente->nombre} {$cliente->apellido}.",
                'duracion' => 3_000,
            ]);

            $this->dispatch('planAsignadoExitosamente');
            $this->cerrar();

        } catch (\Exception $e) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error',
                'mensaje' => 'Error al asignar el plan: ' . $e->getMessage(),
                'duracion' => 6_000,
            ]);
        } finally {
            $this->cargandoAsignacion = false;
        }
    }

    public function render()
    {
        return view('livewire.modal-asignar-plan');
    }
}
