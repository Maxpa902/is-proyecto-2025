<div class="form-layout">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Nueva Clase
                    </h2>
                    <p class="text-muted mb-0">Crear una nueva clase para el sistema</p>
                </div>

                <!-- Acciones rápidas -->
                <div class="d-flex gap-2">
                    <x-boton variante="secundario" tamanio="pequenio" wire:click="limpiarFormulario">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path d="M19 7v4H5.83l3.58-3.59L8 6l-6 6 6 6 1.41-1.41L5.83 13H21V7z" />
                        </svg>
                        Limpiar
                    </x-boton>
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

                            <x-input type="select" label="Actividad" :options="$actividades" livewire="form.id_actividad"
                                required />

                            <x-input type="number" label="Capacidad Máxima" livewire="form.capacidad_maxima" required
                                min="1" max="100" help="Número máximo de participantes" />

                            <x-input type="select" label="Estado" :options="$estados" livewire="form.estado" required
                                help="Estado inicial de la clase" />
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
                                <x-input type="time" label="Hora de Inicio" livewire="form.hora_inicio" required
                                    help="Hora de inicio de la clase" />
                            </div>
                            <div class="col-md-8">
                                <x-input type="time" label="Hora de Fin" livewire="form.hora_fin" required
                                    help="Hora de finalización de la clase" />
                            </div>

                            <x-input type="text" label="Lugar" livewire="form.lugar" required
                                placeholder="Ej: Piscina Principal, Aula 1, etc."
                                help="Ubicación donde se realizará la clase" />

                            <x-input type="text" label="Profesor" livewire="form.nombre_completo_profesor" required
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

                                <div class="days-selection" wire:key="dias-{{ time() }}">
                                    @foreach ($diasSemana as $id => $nombre)
                                        <div class="day-checkbox"
                                            wire:key="dia-{{ $id }}-{{ count($form->dias_seleccionados) }}">
                                            <label for="dia_{{ $id }}" class="day-checkbox-label">
                                                <input type="checkbox" id="dia_{{ $id }}"
                                                    wire:model="form.dias_seleccionados" value="{{ $id }}"
                                                    class="day-checkbox-input" {{-- CLAVE: NO establecer checked - wire:model lo maneja --}}>
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

                <!-- Vista previa (si hay datos) -->
                @if ($form->nombre_completo_profesor && $form->lugar)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-section system-info">
                                <h6 class="text-muted">Vista Previa</h6>
                                <div class="preview-card">
                                    <div class="preview-header">
                                        <strong>Clase #{{ $form->numero_clase }}</strong>
                                        @if ($form->id_actividad && isset($actividades[$form->id_actividad]))
                                            <span class="ms-2 text-muted">-
                                                {{ $actividades[$form->id_actividad] }}</span>
                                        @endif
                                    </div>
                                    <div class="preview-details">
                                        @if ($form->hora_inicio && $form->hora_fin)
                                            <div><strong>Horario:</strong> {{ $form->hora_inicio }} -
                                                {{ $form->hora_fin }}</div>
                                        @endif
                                        <div><strong>Profesor:</strong> {{ $form->nombre_completo_profesor }}</div>
                                        <div><strong>Lugar:</strong> {{ $form->lugar }}</div>
                                        <div><strong>Capacidad:</strong> {{ $form->capacidad_maxima }} personas</div>
                                        @if (count($form->dias_seleccionados) > 0)
                                            <div><strong>Días:</strong>
                                                @foreach ($form->dias_seleccionados as $diaId)
                                                    {{ $diasSemana[$diaId] ?? '' }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
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

                    <x-boton variante="primario" tipo="submit" :cargando="$guardando" textoCargando="Creando..."
                        wireClick="guardar">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Crear Clase
                    </x-boton>
                </div>
            </div>
        </div>

    </div>
</div>
