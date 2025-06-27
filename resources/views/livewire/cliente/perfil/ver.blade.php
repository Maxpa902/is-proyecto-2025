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
                    Información del Cliente
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
                <div class="col-lg-6">
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
                                <span class="info-label">Fecha de Nacimiento:</span>
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
                        </div>
                    </div>
                </div>

                <!-- Contacto y Salud -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <h5 class="section-title">
                            <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM12 12c-1.38 0-2.5-1.12-2.5-2.5S10.62 7 12 7s2.5 1.12 2.5 2.5S13.38 12 12 12z" />
                            </svg>
                            Contacto y Datos de Salud
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $usuario->email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Teléfono:</span>
                                <span class="info-value">{{ $usuario->telefono ?? 'No registrado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Altura:</span>
                                <span
                                    class="info-value">{{ $usuario->altura ? $usuario->altura . ' cm' : 'No especificada' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Peso:</span>
                                <span
                                    class="info-value">{{ $usuario->peso ? $usuario->peso . ' kg' : 'No especificado' }}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con Acción Volver -->
            <div class="form-footer">
                <div class="d-flex justify-content-between">
                    <x-boton variante="terciario" ruta="cliente.bienvenida">
                        <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 24 24">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                        </svg>
                        Volver
                    </x-boton>
                    <x-boton tipo="submit" variante="primario" tamanio="mediano" ruta="cliente.editar">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path
                                d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41L18.37 3.29a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                        Editar
                    </x-boton>
                </div>
            </div>
        </div>
    </div>
</div>
