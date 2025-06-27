<?php

namespace App\Livewire;

use App\Models\Clase;
use App\Models\DiaSemana;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.invitado')]
class Inicio extends Component
{
    public array $clasesPorDia = [];

    public function mount()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        $this->clasesPorDia = $this->obtenerClasesPorDia();
    }

    public function render()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('livewire.inicio', [
            'clasesPorDia' => $this->clasesPorDia,
        ]);
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->hasRole('cliente')) {
            $this->redirectIntended(route('cliente.bienvenida'));
        }

        if ($user->hasRole('recepcionista')) {
            $this->redirectIntended(route('recepcionista.bienvenida'));
        }
    }

    private function obtenerClasesPorDia(): array
    {
        $dias = DiaSemana::ordenadoPorSemana()->get();

        $clasesPorDia = [];

        foreach ($dias as $dia) {
            $clases = Clase::whereHas('dias', function ($q) use ($dia) {
                // Agregamos el nombre de tabla para evitar ambigüedad
                $q->where('dias_semana.id', $dia->id);
            })
                ->where('estado', Clase::ESTADO_ACTIVA)
                ->orderBy('hora_inicio')
                ->get();

            if ($clases->isNotEmpty()) {
                $clasesPorDia[$dia->getNombreCompletoAttribute()] = $clases->map(function ($clase) {
                    return [
                        'hora_inicio' => $clase->hora_inicio->format('H:i'),
                        'hora_fin' => $clase->hora_fin->format('H:i'),
                        'profesor' => $clase->nombre_completo_profesor,
                        'lugar' => $clase->lugar,
                    ];
                })->toArray();
            }
        }

        return $clasesPorDia;
    }

}
