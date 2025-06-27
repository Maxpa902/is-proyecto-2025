<?php

namespace App\Livewire\Recepcionista\Clientes;

use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Renderizar la vista del componente
 */
#[Layout('components.layouts.recepcionista')]
class Ver extends Component
{
    public Usuario $usuario;
    public function mount($id)
    {
        $this->usuario = Usuario::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.recepcionista.clientes.ver');
    }
}
