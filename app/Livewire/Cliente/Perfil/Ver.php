<?php

namespace App\Livewire\Cliente\Perfil;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.cliente')]
class Ver extends Component
{
    public Usuario $usuario;

    public function mount()
    {
        $this->usuario = Auth::user(); // ← Obtenés el usuario autenticado
    }

    public function render()
    {
        return view('livewire.cliente.perfil.ver');
    }
}
