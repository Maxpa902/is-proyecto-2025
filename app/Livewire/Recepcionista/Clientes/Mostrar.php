<?php

namespace App\Livewire\Recepcionista\Clientes;

use App\Models\Usuario;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Mostrar extends Component
{
    public function getClientesProperty()
    {
        return Usuario::role('cliente')
            ->orderByActivo()
            ->get()
            ->map(function ($cliente) {

                return [
                    'id' => $cliente->id,
                    'nombre' => $cliente->nombre_completo,
                    'email' => $cliente->email,
                    'estado' => $cliente->estadoUsuario->nombre,
                ];
            })
            ->toArray();
    }

    /**
     * Renderizar la vista del componente
     */
    #[Layout('components.layouts.recepcionista')]
    public function render()
    {
        return view('livewire.recepcionista.clientes.mostrar', [
            'clientes' => $this->clientes,
        ]);
    }
    public function darBajaCliente($id)
    {
        $cliente = Usuario::findOrFail($id);
        $cliente->darDeBaja();

        $this->dispatch('mostrar-notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Cliente fue dado de baja',
            'mensaje' => "{$cliente->nombre_completo} fue dado de baja correctamente.",
            'duracion' => 3_000,
        ]);
    }
    public function reactivarCliente($id)
    {
        $cliente = Usuario::findOrFail($id);
        $cliente->reactivar();

        $this->dispatch('mostrar-notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Cliente activado',
            'mensaje' => "{$cliente->nombre_completo} fue activado correctamente.",
            'duracion' => 3_000,
        ]);
    }
}
