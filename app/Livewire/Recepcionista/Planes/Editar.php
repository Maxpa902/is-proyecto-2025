<?php

namespace App\Livewire\Recepcionista\Planes;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Editar extends Component
{
    /**
     * Renderizar la vista del componente
     */
    #[Layout('components.layouts.recepcionista')]
    public function render()
    {
        return view('livewire.recepcionista.planes.editar');
    }
}
