<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.invitado')]
class InicioSesion extends Component
{
    /**
     * Formulario de login con validaciones
     */
    public LoginForm $form;

    /**
     * Estado de carga durante el proceso de autenticación
     */
    public bool $loading = false;

    /**
     * Mensaje de estado para feedback visual
     */
    public string $statusMessage = '';

    /**
     * Inicializar el componente
     */
    public function mount(): void
    {

        // Inicializar propiedades
        $this->statusMessage = '';
        $this->loading = false;
    }

    /**
     * Procesar el login del usuario
     */
    public function login(): void
    {
        $this->loading = true;
        $this->statusMessage = '';

        try {
            // Validar datos del formulario
            $this->validate();

            $this->form->authenticate();

            // Regenerar sesión por seguridad
            Session::regenerate();

            $this->redirectBasedOnRole();

        } catch (ValidationException $e) {
            $this->statusMessage = 'Credenciales incorrectas';
            throw $e;
        } catch (\Exception $e) {
            $this->statusMessage = 'Error de conexión: ' . $e->getMessage();
            Log::info('Error en login natatorio', [
                'error' => $e->getMessage(),
                'user_email' => $this->form->email ?? 'no_email',
            ]);
        } finally {
            $this->loading = false;
        }
    }

    /**
     * Limpiar mensajes de error al escribir
     */
    public function updatedFormEmail(): void
    {
        $this->resetErrorBag('form.email');
        $this->statusMessage = '';
    }

    /**
     * Limpiar mensajes de error al escribir
     */
    public function updatedFormPassword(): void
    {
        $this->resetErrorBag('form.password');
        $this->statusMessage = '';
    }

    /**
     * Navegar a registro
     */
    public function irRegistro(): void
    {
        $this->redirect(route('registro'), navigate: true);
    }

    /**
     * Renderizar la vista del componente
     */
    public function render()
    {
        return view('livewire.iniciosesion');
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
