<?php

namespace App\Livewire\Recepcionista\Clientes;

use App\Livewire\Forms\ClienteForm;
use App\Models\Usuario;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Renderizar la vista del componente
 */
#[Layout('components.layouts.recepcionista')]
class Editar extends Component
{
    public Usuario $usuario;
    public ClienteForm $form;

    public bool $guardando = false;

    public function mount($id)
    {
        $this->usuario = Usuario::findOrFail($id);
        $this->form->setCliente($this->usuario);
    }

    public function actualizar()
    {
        $this->guardando = true;

        try {
            $this->validate();
            $this->form->actualizarCliente($this->usuario);

            session()->flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Cliente actualizado',
                'mensaje' => 'El cliente se ha actualizado correctamente.',
                'duracion' => 3_000,
            ]);

            return redirect()->route('clientes.mostrar');
        } catch (ValidationException $e) {
            // Los errores de validación se manejan automáticamente
            throw $e;
        } catch (\Exception $e) {
            session()->flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error al actualizar',
                'mensaje' => 'Error al actualizar la clase: ' . $e->getMessage(),
                'duracion' => 3_000,
            ]);
        } finally {
            $this->guardando = false;
        }
    }

    public function render()
    {
        return view('livewire.recepcionista.clientes.editar');
    }
}
