<?php

namespace App\Livewire\Cliente;

use App\Models\Clase;
use App\Models\DiaSemana;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

#[Layout(null)]
class CalendarioClases extends Component
{
    public array $clasesPorDia = [];

    protected $listeners = ['inscripcion-actualizada' => 'cargarClases'];

    public function mount()
    {
        $this->cargarClases();
    }

    public function inscribirse(int $idClase, int $idDiaSemana)
    {
        $cliente = Auth::user();
        $clase = Clase::with(['actividad', 'sesiones'])->findOrFail($idClase);

        // Todas las validaciones igual que antes...
        if (! $cliente->tieneSuscripcionActiva($clase->id_actividad)) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'advertencia',
                'titulo' => 'Suscripción no activa',
                'mensaje' => 'No tienes una suscripción activa para esta actividad.',
                'duracion' => 3_000,
            ]);

            return;
        }

        $hoy = now();
        $inicioSemana = $hoy->copy()->startOfWeek();
        $fechaSesion = $inicioSemana->copy()->addDays($idDiaSemana - 1);

        if ($fechaSesion->isBefore($hoy->startOfDay())) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'advertencia',
                'titulo' => 'Sesión expirada',
                'mensaje' => 'La fecha de la sesión ya ha expirado.',
                'duracion' => 3_000,
            ]);

            return;
        }

        $sesion = $clase->sesiones()->whereDate('fecha', $fechaSesion->toDateString())->first();

        if (! $sesion) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error de sesión',
                'mensaje' => 'No se encontró la sesión para la clase y fecha especificadas.',
                'duracion' => 3_000,
            ]);

            return;
        }

        if (Inscripcion::validarClaveNatural($cliente->id, $sesion->id)) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'advertencia',
                'titulo' => 'Ya estás inscripto',
                'mensaje' => 'Ya te encuentras inscripto a esta sesión.',
                'duracion' => 3_000,
            ]);

            return;
        }

        if ($sesion->inscripciones()->confirmadas()->count() >= $clase->capacidad_maxima) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'advertencia',
                'titulo' => 'Clase llena',
                'mensaje' => 'La clase ha alcanzado su capacidad máxima.',
                'duracion' => 3_000,
            ]);

            return;
        }

        // Inscribir
        Inscripcion::create([
            'id_cliente' => $cliente->id,
            'id_sesion' => $sesion->id,
        ]);

        $this->dispatch('mostrar-notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Inscripción exitosa',
            'mensaje' => 'Te has inscripto correctamente a la clase de ' . $clase->actividad->nombre . '.',
            'duracion' => 3_000,
        ]);

        // Recargar solo este componente
        $this->cargarClases();

        // Notificar al componente padre para actualizar inscripciones
        $this->dispatch('inscripcion-realizada');
    }

    public function darDeBaja(int $idInscripcion)
    {
        $inscripcion = Auth::user()->inscripciones()->confirmadas()->findOrFail($idInscripcion);

        if (! $inscripcion->puedeCancelarse()) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'advertencia',
                'titulo' => 'No se puede dar de baja',
                'mensaje' => 'La inscripción no puede cancelarse en este momento.',
                'duracion' => 3_000,
            ]);

            return;
        }

        $nombreActividad = $inscripcion->sesion->clase->actividad->nombre;
        $inscripcion->delete();

        $this->dispatch('mostrar-notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Baja exitosa',
            'mensaje' => 'Te has dado de baja de la clase de ' . $nombreActividad . '.',
            'duracion' => 3_000,
        ]);

        // Recargar solo este componente
        $this->cargarClases();

        // Notificar al componente padre
        $this->dispatch('inscripcion-realizada');
    }

    public function render()
    {
        return view('livewire.cliente.calendario-clases');
    }

    private function cargarClases()
    {
        $dias = DiaSemana::ordenadoPorSemana()->get();
        $cliente = Auth::user();
        $hoy = now();
        $inicioSemana = $hoy->copy()->startOfWeek();

        $this->clasesPorDia = [];

        foreach ($dias as $dia) {
            $clases = Clase::whereHas('dias', function ($q) use ($dia) {
                $q->where('dias_semana.id', $dia->id);
            })
                ->where('estado', Clase::ESTADO_ACTIVA)
                ->orderBy('hora_inicio')
                ->get();

            if ($clases->isNotEmpty()) {
                $this->clasesPorDia[$dia->getNombreCompletoAttribute()] = $clases->map(function ($clase) use ($dia, $cliente, $inicioSemana, $hoy) {
                    $fechaSesion = $inicioSemana->copy()->addDays($dia->id - 1);
                    $sesion = $clase->sesiones()->whereDate('fecha', $fechaSesion->toDateString())->first();

                    $inscripcion = null;
                    $estaInscripto = false;

                    if ($sesion && $cliente) {
                        $inscripcion = $cliente->inscripciones()
                            ->confirmadas()
                            ->where('id_sesion', $sesion->id)
                            ->first();
                        $estaInscripto = $inscripcion !== null;
                    }

                    // Calcular si puede inscribirse
                    $fechaHoraClase = $fechaSesion->copy()->setTimeFromTimeString($clase->hora_inicio->format('H:i:s'));
                    $puedeInscribirse = $hoy->lessThan($fechaHoraClase);

                    return [
                        'id' => $clase->id,
                        'numero_clase' => $clase->numero_clase,
                        'idDiaSemana' => $dia->id,
                        'hora_inicio' => $clase->hora_inicio->format('H:i'),
                        'hora_fin' => $clase->hora_fin->format('H:i'),
                        'profesor' => $clase->nombre_completo_profesor,
                        'lugar' => $clase->lugar,
                        'sesion_id' => $sesion?->id,
                        'esta_inscripto' => $estaInscripto,
                        'inscripcion_id' => $inscripcion?->id,
                        'puede_inscribirse' => $puedeInscribirse, // ← NUEVO
                    ];
                })->toArray();
            }
        }
    }
}
