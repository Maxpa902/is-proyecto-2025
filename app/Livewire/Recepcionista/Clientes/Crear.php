<?php

namespace App\Livewire\Recepcionista\Clientes;

use App\Livewire\Forms\ClienteForm;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Crear extends Component
{
    public ClienteForm $form;
    public bool $loading = false;

    public function crearCliente()
    {
        $this->loading = true;
        try {

            $this->form->validate();

            $this->form->crearCliente(); // Crear el usuario

            session()->flash('notificacion', [
                'tipo' => 'success',
                'titulo' => 'Cliente Creado',
                'mensaje' => 'Cliente se ha creado exitosamente.',
                'duracion' => 3_000,
            ]);

            return redirect()->route('clientes.mostrar');

        } catch (ValidationException $e) {
            session()->flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Datos inválidos.',
                'duracion' => 3_000,
            ]);
            throw $e;
        } catch (\Exception $e) {
            logger('Error al registrar cliente', [
                'error' => $e->getMessage(),
                'user_email' => $this->form->email ?? 'no_email',
            ]);
            session()->flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error inesperado',
                'duracion' => 3_000,
            ]);
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.recepcionista.clientes.crear');
    }

    public function mount()
    {
        $this->resetFormulario();
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
