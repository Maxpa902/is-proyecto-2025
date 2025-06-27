<?php

namespace App\Livewire\Recepcionista\Clases;

use App\Models\Clase;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Mostrar extends Component
{
    public $clases;

    public function mount()
    {
        $this->clases = Clase::all();
    }

    /**
     * Renderizar la vista del componente
     */
    public function render()
    {
        return view('livewire.recepcionista.clases.mostrar', ['clases' => $this->clases]);
    }
}
