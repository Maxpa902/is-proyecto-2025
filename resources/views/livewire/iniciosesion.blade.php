{{-- resources/views/livewire/iniciosesion.blade.php --}}
@push('styles')
    @vite('resources/css/components/base.css')
    @vite('resources/css/components/colores.css')
@endpush

<div class="natatory-layout">

    {{-- Contenedor principal --}}
    <div class="natatory-container">
        <div class="natatory-card">

            {{-- Título del formulario --}}
            <h2 class="natatory-title">Iniciar Sesión</h2>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Mensaje de estado personalizado --}}
            @if ($statusMessage)
                <div class="status-message {{ str_contains($statusMessage, '✅') ? 'success' : 'error' }}">
                    {{ $statusMessage }}
                </div>
            @endif

            {{-- Formulario de login --}}
            <form wire:submit="login" novalidate>

                {{-- Campo Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        wire:model.debounce.300ms="form.email"
                        placeholder="correo@ejemplo.com" required autofocus autocomplete="username"
                        {{ $loading ? 'disabled' : '' }}>
                    @error('form.email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Contraseña --}}
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input"
                        wire:model.debounce.300ms="form.password"
                        placeholder="••••••••" required autocomplete="current-password"
                        {{ $loading ? 'disabled' : '' }}>
                    @error('form.password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Recordar sesión --}}
                <div class="form-group checkbox-group">
                    <label for="remember" class="checkbox-label">
                        <input type="checkbox" id="remember" name="remember" class="checkbox-input"
                            wire:model="form.remember" {{ $loading ? 'disabled' : '' }}>
                        <span class="checkbox-text">Recordar sesión</span>
                    </label>
                </div>

                {{-- Botón de ingreso --}}
                <div class="form-group">
                    <button type="submit" class="button-primary" {{ $loading ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="login">
                            Ingresar
                        </span>
                        <span wire:loading wire:target="login">
                            Ingresando...
                        </span>
                    </button>
                </div>

                {{-- Enlaces adicionales --}}
                <div class="form-links">
                    <a class="nolink" href="{{ route('registro') }}">
                        <span>¿No tienes cuenta? </span><b class="link segundo-letra">Registrarse</b>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
