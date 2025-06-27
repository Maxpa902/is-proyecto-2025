<?php

namespace App\Livewire\Recepcionista\Perfil;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Ver extends Component
{
    /**
     * Renderizar la vista del componente
     */
    public function render()
    {
        $usuario = Auth::user();

        return view('livewire.recepcionista.perfil.ver', [
            'usuario' => $usuario,
        ]);
    }
}
