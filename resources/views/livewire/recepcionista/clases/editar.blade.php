<div class="form-layout">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                        Editar Clase
                    </h2>
                    <p class="text-muted mb-0">Modifica los datos de la clase #{{ $clase->numero_clase }}</p>
                </div>

                <!-- Estado actual -->
                <div>
                    <span class="badge {{ $clase->estado === 'activa' ? 'badge-success' : 'badge-secondary' }}">
                        Estado: {{ ucfirst($clase->estado) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="form-body">
            <form wire:submit="guardar">
                <div class="row">
                    <!-- Información General -->
                    <div class="col-lg-6">
                        <div class="form-section">
                            <h5 class="section-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                    class="me-2">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                Información General
                            </h5>

                            <x-input type="text" label="Actividad (No editable)" :value="$clase->actividad->nombre" readonly />

                            <x-input type="number" label="Número de Clase (No editable)" :value="$clase->numero_clase" readonly />

                            <x-input type="number" label="Capacidad Máxima"
                                livewire="form.capacidad_maxima" required min="1" max="100"
                                help="Número máximo de participantes" />

                            <x-input type="select" label="Estado" :options="$estados"
                                livewire="form.estado" required help="Estado actual de la clase" />
                        </div>
                    </div>

                    <!-- Horario y Ubicación -->
                    <div class="col-lg-6">
                        <div class="form-section">
                            <h5 class="section-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                    class="me-2">
                                    <path
                                        d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                                </svg>
                                Horario y Ubicación
                            </h5>


                            <div class="col-md-8">
                                <x-input type="time" label="Hora de Inicio"
                                    livewire="form.hora_inicio" required help="Hora de inicio de la clase" />
                            </div>
                            <div class="col-md-8">
                                <x-input type="time" label="Hora de Fin"
                                    livewire="form.hora_fin" required help="Hora de finalización de la clase" />
                            </div>

                            <x-input type="text" label="Lugar" livewire="form.lugar" required
                                placeholder="Ej: Piscina Principal, Aula 1, etc."
                                help="Ubicación donde se realizará la clase" />

                            <x-input type="text" label="Profesor"
                                livewire="form.nombre_completo_profesor" required
                                placeholder="Nombre completo del instructor" help="Instructor a cargo de la clase" />
                        </div>
                    </div>
                </div>

                <!-- Días de la Semana -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="form-section">
                            <h5 class="section-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                    class="me-2">
                                    <path
                                        d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                                </svg>
                                Días de la Semana
                            </h5>

                            <div class="form-group">
                                <label class="form-label">
                                    Selecciona los días <span class="text-danger">*</span>
                                </label>

                                <div class="days-selection">
                                    @foreach ($diasSemana as $id => $nombre)
                                        <div class="day-checkbox">
                                            <label for="dia_{{ $id }}" class="day-checkbox-label">
                                                <input type="checkbox" id="dia_{{ $id }}"
                                                    wire:model="form.dias_seleccionados" value="{{ $id }}"
                                                    class="day-checkbox-input">
                                                <span class="day-checkbox-text">{{ $nombre }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                @error('form.dias_seleccionados')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror

                                <div class="form-text">Selecciona al menos un día para la clase</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema (Solo lectura) -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="form-section system-info">
                            <h6 class="text-muted">Información del Sistema</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Creado:</strong> {{ $clase->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Última actualización:</strong>
                                        {{ $clase->updated_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer con Acciones -->
                <div class="form-footer">
                    <div class="d-flex justify-content-between">
                        <x-boton variante="terciario" wireClick="cancelar" :deshabilitado="$guardando">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                            </svg>
                            Cancelar
                        </x-boton>

                        <x-boton variante="primario" tipo="submit" :cargando="$guardando" textoCargando="Guardando..."
                            wireClick="guardar">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                <path
                                    d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
                            </svg>
                            Guardar Cambios
                        </x-boton>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
