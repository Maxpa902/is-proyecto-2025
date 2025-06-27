<?php

namespace App\Livewire\Cliente;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VistaCliente extends Component
{
    public $inscripcionesActivas = [];

    protected $listeners = ['inscripcion-realizada' => 'actualizarInscripciones'];

    public function mount()
    {
        $this->actualizarInscripciones();
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

        $this->actualizarInscripciones();

        // Notificar al calendario que se actualice
        $this->dispatch('inscripcion-actualizada');
    }

    public function render()
    {
        return view('livewire.cliente.vista-cliente');
    }

    public function actualizarInscripciones()
    {
        $cliente = Auth::user();

        $this->inscripcionesActivas = $cliente->inscripciones()
            ->confirmadas()
            ->with('sesion.clase.actividad')
            ->orderBy('fecha_hora_inscripcion', 'desc')
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'id' => $inscripcion->id,
                    'actividad' => $inscripcion->sesion->clase->actividad->nombre,
                    'dia' => $inscripcion->sesion->fecha->locale('es')->isoFormat('dddd'),
                    'fecha' => $inscripcion->sesion->fecha->format('d/m/Y'),
                    'hora' => $inscripcion->sesion->clase->hora_inicio->format('H:i') . ' a ' . $inscripcion->sesion->clase->hora_fin->format('H:i'),
                ];
            })
            ->toArray();
    }
}
