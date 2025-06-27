{{-- resources/views/livewire/bienvenida.blade.php --}}
@push('styles')
    @vite('resources/css/components/base.css')
@endpush

<div class="natatory-layout">
    <div class="natatory-container">
        <div class="natatory-card">
            <h1 class="natatory-title">¡Bienvenido!</h1>

            @auth
                <p class="welcome-text">
                    Hola <strong>{{ Auth::user()->nombre }}</strong>, ingresaste como 
                    <strong>{{ ucfirst(Auth::user()->rol ?? 'Cliente') }}</strong>.
                </p>
            @else
                <p>No hay sesión activa.</p>
                <a href="{{ route('iniciosesion') }}" class="button-primary">Iniciar sesión</a>
            @endauth
        </div>
    </div>
</div>
