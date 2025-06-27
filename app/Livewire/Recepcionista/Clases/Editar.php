<?php

namespace App\Livewire\Recepcionista\Clases;

use App\Livewire\Forms\ClaseForm;
use App\Models\Clase;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Editar extends Component
{
    public ClaseForm $form;
    public Clase $clase;
    public bool $guardando = false;

    public function mount($id)
    {
        $this->clase = Clase::with(['actividad', 'dias'])->findOrFail($id);
        $this->form->setClase($this->clase);
    }

    /**
     * Auto-ajustar hora fin cuando cambia hora inicio
     */
    public function updatedFormHoraInicio()
    {
        if ($this->form->hora_inicio) {
            try {
                $inicio = Carbon::createFromFormat('H:i', $this->form->hora_inicio);
                $fin = $inicio->copy()->addHour();
                $this->form->hora_fin = $fin->format('H:i');

                // Validar ambos campos después del cambio
                $this->validateOnly('form.hora_inicio');
                $this->validateOnly('form.hora_fin');
            } catch (\Exception $e) {
                // Solo validar hora inicio si hay error de formato
                $this->validateOnly('form.hora_inicio');
            }
        }
    }

    /**
     * Validar hora fin cuando cambia
     */
    public function updatedFormHoraFin()
    {
        $this->validateOnly('form.hora_fin');
    }

    public function updatedFormCapacidadMaxima()
    {
        $this->validateOnly('form.capacidad_maxima');
    }

    public function guardar()
    {
        $this->guardando = true;

        try {
            // dd('guardando');
            $this->form->update();

            session()->flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Clase actualizada',
                'mensaje' => 'La clase se ha actualizado correctamente.',
                'duracion' => 3_000,
            ]);

            return redirect()->route('clases.ver', $this->clase->id);

        } catch (ValidationException $e) {
            // Los errores de validación se manejan automáticamente
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('mostrar-notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error al crear la clase',
                'mensaje' => $e->getMessage(),
                'duracion' => 8_000,
            ]);
        } finally {
            $this->guardando = false;
        }
    }

    public function cancelar()
    {
        return redirect()->route('clases.ver', $this->clase->id);
    }

    public function render()
    {
        return view('livewire.recepcionista.clases.editar', [
            'actividades' => $this->form->getActividades(),
            'diasSemana' => $this->form->getDiasSemana(),
            'estados' => $this->form->getEstados(),
        ]);
    }
}
