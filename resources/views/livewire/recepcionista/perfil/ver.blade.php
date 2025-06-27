@push('styles')
    @vite('resources/css/components/colores.css')
@endpush
<div class="form-layout">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header quinto d-flex justify-content-between align-items-center"
            style="border: 2px solid #00bcd4ff; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div>
                <h2 class="mb-1 d-flex align-items-center">
                    <svg width="24" height="24" fill="currentColor" class="me-2" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    Información de Perfil
                </h2>
                <p class="text-muted mb-0">{{ $usuario->nombre_completo }}</p>
            </div>

            <div class="info-item d-flex align-items-center">
                <span
                    class="badge {{ $usuario->estaActivo() ? 'badge-success' : 'badge-warning' }} d-flex align-items-center">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1"
                        aria-hidden="true" focusable="false">
                        @if ($usuario->estaActivo())
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                        @else
                            <path
                                d="M18.3 5.71L12 12l6.3 6.29-1.42 1.42L12 13.41l-6.29 6.3-1.42-1.42L10.59 12 4.29 5.71 5.71 4.29 12 10.59l6.29-6.3z" />
                        @endif
                    </svg>
                    {{ $usuario->estaActivo() ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>


        <!-- Contenido -->
        <div class="form-body">
            <div class="row">
                <!-- Información Personal -->
                <div class="col-lg-12">
                    <div class="info-section">
                        <h5 class="section-title">
                            <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            Datos Personales
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Nombre:</span>
                                <span class="info-value">{{ $usuario->nombre }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Apellido:</span>
                                <span class="info-value">{{ $usuario->apellido }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">DNI:</span>
                                <span class="info-value">{{ $usuario->dni }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Fecha de <br>Nacimiento:</br></span>
                                <span class="info-value">{{ $usuario->fecha_nacimiento->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Edad:</span>
                                <span class="info-value">{{ $usuario->edad }} años</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sexo:</span>
                                <span class="info-value">{{ $usuario->sexoCompleto ?? 'No definido' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $usuario->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer con Acción Volver -->
            <div class="form-footer">
                <div class="d-flex justify-content-between">
                    <x-boton variante="terciario" ruta="recepcionista.bienvenida">
                        <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 24 24">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                        </svg>
                        Volver
                    </x-boton>
                </div>
            </div>
        </div>
    </div>
</div>
