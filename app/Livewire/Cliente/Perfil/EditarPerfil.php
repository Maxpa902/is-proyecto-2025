<?php

namespace App\Livewire\Cliente\Perfil;

use App\Livewire\Forms\ClienteForm;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EditarPerfil extends Component
{
    public Usuario $usuario;
    public ClienteForm $form;

    public bool $guardando = false;

    public function mount()
    {
        $this->usuario = Auth::user();
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
                'mensaje' => 'Actualizaste tu información correctamente.',
                'duracion' => 3_000,
            ]);

            return redirect()->route('cliente.perfil');
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
        return view('livewire.cliente.perfil.editar-perfil');
    }
}
