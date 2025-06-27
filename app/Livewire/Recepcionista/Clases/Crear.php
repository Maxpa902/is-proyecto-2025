<?php

namespace App\Livewire\Recepcionista\Clases;

use App\Livewire\Forms\ClaseForm;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Crear extends Component
{
    public ClaseForm $form;
    public bool $guardando = false;

    public function mount()
    {
        $this->resetFormulario();
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

    /**
     * Validar actividad cuando cambia
     */
    public function updatedFormIdActividad()
    {
        $this->validateOnly('form.id_actividad');
    }

    // Método guardar actualizado (Livewire)
    public function guardar()
    {
        $this->guardando = true;
        try {
            $clase = $this->form->store();
            session()->flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Clase creada',
                'mensaje' => 'La clase se ha creado correctamente.',
                'duracion' => 3_000,
            ]);

            return redirect()->route('clases.ver', $clase->id);
        } catch (ValidationException $e) {
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
        return redirect()->route('clases.mostrar');
    }

    public function limpiarFormulario()
    {
        $this->resetFormulario();

        $this->dispatch('mostrar-notificacion', [
            'tipo' => 'info',
            'titulo' => 'Formulario limpio',
            'mensaje' => 'Se han restablecido todos los campos.',
            'duracion' => 3_000,
        ]);
    }

    public function render()
    {
        return view('livewire.recepcionista.clases.crear', [
            'actividades' => $this->form->getActividades(),
            'diasSemana' => $this->form->getDiasSemana(),
            'estados' => $this->form->getEstados(),
        ]);
    }

    /**
     * Resetear formulario con valores por defecto
     */
    private function resetFormulario()
    {
        // Resetear todo el formulario
        $this->form->reset();

        // Forzar actualización del componente
        $this->resetValidation();
    }
}
