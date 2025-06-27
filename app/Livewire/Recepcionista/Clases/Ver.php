<?php

namespace App\Livewire\Recepcionista\Clases;

use App\Models\Clase;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.recepcionista')]
class Ver extends Component
{
    public Clase $clase;
    public $actividad;
    public $diasSemana = [];

    public function mount($id)
    {
        $this->clase = Clase::with(['actividad', 'dias'])->findOrFail($id);
        $this->actividad = $this->clase->actividad;
        $this->diasSemana = $this->clase->dias->pluck('nombre')->toArray();
    }

    public function editarClase()
    {
        return redirect()->route('clases.editar', $this->clase->id);
    }

    public function volverAtras()
    {
        return redirect()->route('clases.mostrar');
    }

    public function render()
    {
        return view('livewire.recepcionista.clases.ver', [
            'breadcrumbs' => [
                ['title' => 'Calendario y Clases', 'url' => route('clases.mostrar')],
                ['title' => 'Ver Clase', 'url' => ''],
            ],
        ]);
    }
}
