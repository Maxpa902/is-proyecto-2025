<div class="form-layout">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path
                                d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z" />
                        </svg>
                        Clase #{{ $clase->numero_clase }}
                    </h2>
                    <p class="text-muted mb-0">{{ $actividad->nombre }}</p>
                </div>

                <!-- Estado -->
                <div>
                    <span class="badge {{ $clase->estado === 'activa' ? 'badge-success' : 'badge-secondary' }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            @if ($clase->estado === 'activa')
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                            @else
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            @endif
                        </svg>
                        {{ ucfirst($clase->estado) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="form-body">
            <div class="row">
                <!-- Información General -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <h5 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            Información General
                        </h5>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Actividad:</span>
                                <span class="info-value">{{ $actividad->nombre }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Número de Clase:</span>
                                <span class="info-value"># {{ $clase->numero_clase }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Capacidad Máxima:</span>
                                <span class="info-value">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path
                                            d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3z" />
                                    </svg>
                                    {{ $clase->capacidad_maxima }} personas
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Estado:</span>
                                <span class="info-value">
                                    <span class="status-indicator {{ $clase->estado }}"></span>
                                    {{ ucfirst($clase->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horario y Ubicación -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <h5 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path
                                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                            </svg>
                            Horario y Ubicación
                        </h5>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Hora de Inicio:</span>
                                <span class="info-value">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path
                                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                                    </svg>
                                    {{ $clase->hora_inicio->format('H:i') }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Hora de Fin:</span>
                                <span class="info-value">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path
                                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                                    </svg>
                                    {{ $clase->hora_fin->format('H:i') }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Duración:</span>
                                <span class="info-value">
                                    @php
                                        $duracion = $clase->hora_inicio->diff($clase->hora_fin);
                                        $horas = $duracion->h;
                                        $minutos = $duracion->i;
                                    @endphp
                                    {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos }}min
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Lugar:</span>
                                <span class="info-value">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path
                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                    </svg>
                                    {{ $clase->lugar }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profesor y Días -->
            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="info-section">
                        <h5 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            Profesor
                        </h5>

                        <div class="professor-card">
                            <div class="professor-avatar">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <div class="professor-info">
                                <h6 class="professor-name">{{ $clase->nombre_completo_profesor }}</h6>
                                <p class="professor-role">Instructor</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-section">
                        <h5 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                class="me-2">
                                <path
                                    d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                            </svg>
                            Días de la Semana
                        </h5>

                        <div class="days-container">
                            @forelse($diasSemana as $dia)
                                <span class="day-badge">{{ $dia }}</span>
                            @empty
                                <span class="text-muted">No hay días asignados</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Sistema -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="info-section system-info">
                        <h6 class="text-muted">Información del Sistema</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Creado:</strong> {{ $clase->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Actualizado:</strong> {{ $clase->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer con Acciones -->
            <div class="form-footer">
                <div class="d-flex justify-content-between">
                    <x-boton variante="terciario" wireClick="volverAtras">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                        </svg>
                        Volver
                    </x-boton>

                    <x-boton variante="primario" wireClick="editarClase">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                        Editar Clase
                    </x-boton>
                </div>
            </div>
        </div>

    </div>
</div>
