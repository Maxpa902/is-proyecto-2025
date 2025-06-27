{{-- resources/views/livewire/registro.blade.php --}}
@push('styles')
    @vite('resources/css/components/colores.css')
    @vite('resources/css/components/base.css')
@endpush

<div class="natatory-layout">
    {{-- Contenedor principal --}}
    <div class="natatory-container">
        <div class="natatory-card">
            {{-- Título del formulario --}}
            <h2 class="natatory-title">Registrarse</h2>

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
            <form wire:submit="registrar" novalidate>
                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" class="form-input" wire:model.debounce.300ms="form.nombre"
                        required />
                    @error('form.nombre')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Apellido --}}
                <div class="form-group">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" id="apellido" class="form-input" wire:model.debounce.300ms="form.apellido"
                        required />
                    @error('form.apellido')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- DNI --}}
                <div class="form-group">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="number" id="dni" class="form-input" wire:model.debounce.300ms="form.dni"
                        required minlength="8" maxlength="8" min="10000000" max="99999999" />
                    @error('form.dni')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Fecha de nacimiento --}}
                <div class="form-group">
                    <label for="nacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" id="nacimiento" class="form-input" wire:model="form.nacimiento"
                        min="{{ \Carbon\Carbon::now()->subYears(90)->format('Y-m-d') }}"
                        max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}" required />
                    @error('form.nacimiento')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" id="email" class="form-input" wire:model.debounce.300ms="form.email"
                        required />
                    @error('form.email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" class="form-input" wire:model="form.password" required />
                    @error('form.password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" class="form-input"
                        wire:model="form.password_confirmation" required />
                </div>

                {{-- Botón --}}
                <div class="form-group">
                    <button type="submit" class="button-primary" {{ $loading ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="registrar">Registrarse</span>
                        <span wire:loading wire:target="registrar">
                            Registrando...
                        </span>
                    </button>
                </div>

                <div class="form-links">
                    <a class="nolink" href="{{ route('iniciosesion') }}">
                        <span>¿Ya tenés una cuenta?</span> <b class="link segundo-letra">Iniciar Sesión</b>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
