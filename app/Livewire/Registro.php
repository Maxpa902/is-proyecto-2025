<?php

namespace App\Livewire;

use App\Livewire\Forms\RegisterForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Registro extends Component
{
    public RegisterForm $form;
    public string $statusMessage = '';
    public bool $loading = false;

    public function registrar(): void
    {
        $this->loading = true;
        $this->statusMessage = '';
        try {
            $this->validate(); // Validar los datos

            $user = $this->form->registrar(); // Crear el usuario

            Auth::login($user);

            $this->redirectBasedOnRole();

        } catch (ValidationException $e) {
            $this->statusMessage = 'Datos inválidos, por favor revisá los campos';
            throw $e;
        } catch (\Exception $e) {
            $this->statusMessage = 'Error de sistema: ' . $e->getMessage();
            Log::info('Error al registrar', [
                'error' => $e->getMessage(),
                'user_email' => $this->form->email ?? 'no_email',
            ]);
        } finally {
            $this->loading = false;
        }
    }

    public function irInicioSesion(): void
    {
        $this->redirect(route('iniciosesion'), navigate: true);
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.registro');
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
}
