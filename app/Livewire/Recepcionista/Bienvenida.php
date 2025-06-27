<?php

namespace App\Livewire\Recepcionista;

use App\Models\Plan;
use App\Models\Sesion;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Bienvenida extends Component
{
    protected $listeners = [
        'planAsignadoExitosamente' => 'actualizarDashboard',
    ];

    // ✅ MÉTODO PARA ABRIR MODAL SIN PLAN ESPECÍFICO
    public function abrirModalAsignar(?int $planId = null)
    {
        // ✅ Debug: Verificar que el método se ejecuta
        Log::info('🔥 abrirModalAsignar ejecutado con planId: ' . ($planId ?? 'null'));

        if ($planId) {
            // Con plan específico
            $plan = Plan::with('actividad')->findOrFail($planId);
            Log::info('📦 Plan encontrado: ' . $plan->actividad->nombre);
            $this->dispatch('abrirModalAsignarPlan', $plan);
        } else {
            // Sin plan específico - empezar desde selección de plan
            Log::info('🎯 Emitiendo evento sin plan específico');
            $this->dispatch('abrirModalAsignarPlan');
        }

        Log::info('✅ Evento emitido correctamente');
    }

    public function actualizarDashboard()
    {
        // Aquí puedes actualizar estadísticas del dashboard si es necesario
        $this->dispatch('mostrar-notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Dashboard actualizado',
            'mensaje' => 'Las estadísticas se han actualizado.',
            'duracion' => 3_000,
        ]);
    }

    public function render()
    {
        $estadisticas_clientes = Usuario::obtenerEstadisticasUsuarios();
        $estadisticas_sesiones = Sesion::obtenerEstadisticasSesiones();
        $estadisticas_planes = Plan::obtenerEstadisticasPlanes();

        return view('livewire.recepcionista.bienvenida', [
            'estadisticas_clientes' => $estadisticas_clientes,
            'estadisticas_sesiones' => $estadisticas_sesiones,
            'estadisticas_planes' => $estadisticas_planes,
        ]);
    }
}
