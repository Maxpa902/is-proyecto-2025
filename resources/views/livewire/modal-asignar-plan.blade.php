{{-- resources/views/livewire/components/modal-asignar-plan.blade.php --}}
<div>
    @if ($mostrar)
        <div class="modal-overlay" wire:click="cerrar">
            <div class="modal-container" wire:click.stop>

                <!-- Header del Modal -->
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($paso === 'plan')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                            Seleccionar Plan
                        @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path
                                    d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3z" />
                            </svg>
                            Asignar a Cliente
                        @endif
                    </h5>

                    <!-- Indicador de pasos -->
                    <div class="steps-indicator">
                        <span class="step {{ $paso === 'plan' ? 'active' : ($plan ? 'completed' : '') }}">1</span>
                        <span class="step-divider"></span>
                        <span class="step {{ $paso === 'cliente' ? 'active' : '' }}">2</span>
                    </div>

                    <button type="button" class="modal-close" wire:click="cerrar" aria-label="Cerrar modal">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                        </svg>
                    </button>
                </div>

                <!-- Cuerpo del Modal -->
                <div class="modal-body">

                    {{-- PASO 1: SELECCIÓN DE PLAN --}}
                    @if ($paso === 'plan')

                        <!-- Control de vista y búsqueda -->
                        <div class="plan-controls mb-3">
                            <div class="d-flex gap-2 mb-3">
                                <x-boton variante="{{ $vistaPlanes === 'actividades' ? 'primario' : 'terciario' }}"
                                    tamanio="pequenio" wireClick="alternarVistaPlanes" :deshabilitado="$vistaPlanes === 'actividades'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                                    </svg>
                                    Por Actividad
                                </x-boton>

                                <x-boton variante="{{ $vistaPlanes === 'busqueda' ? 'primario' : 'terciario' }}"
                                    tamanio="pequenio" wireClick="alternarVistaPlanes" :deshabilitado="$vistaPlanes === 'busqueda'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path
                                            d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                    </svg>
                                    Buscar
                                </x-boton>
                            </div>

                            @if ($vistaPlanes === 'busqueda')
                                <x-input type="text" name="busquedaPlan" placeholder="Buscar plan o actividad..."
                                    livewire="busquedaPlan" livewireModifier="live.debounce.300ms" :loading="$cargandoPlanes" />
                            @endif
                        </div>

                        <!-- Lista de actividades -->
                        @if ($vistaPlanes === 'actividades')
                            <div class="actividades-lista mb-3">
                                <label class="form-label">Seleccionar actividad:</label>
                                <div class="actividades-grid">
                                    @foreach ($actividadesDisponibles as $actividad)
                                        <div class="actividad-card {{ $actividadSeleccionada == $actividad['id'] ? 'selected' : '' }}"
                                            wire:click="seleccionarActividad({{ $actividad['id'] }})">
                                            <div class="actividad-info">
                                                <h6 class="actividad-nombre">{{ $actividad['nombre'] }}</h6>
                                                <small class="text-muted">{{ $actividad['planes_count'] }} plan(es)
                                                    disponible(s)</small>
                                            </div>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                                class="actividad-arrow">
                                                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                                            </svg>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Lista de planes -->
                        @if (count($planesDisponibles) > 0)
                            <div class="planes-lista">
                                <label class="form-label">
                                    @if ($vistaPlanes === 'busqueda')
                                        Resultados de búsqueda:
                                    @else
                                        Planes disponibles:
                                    @endif
                                </label>

                                @if ($cargandoPlanes)
                                    <div class="text-center py-3">
                                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                        Cargando planes...
                                    </div>
                                @else
                                    <div class="planes-grid">
                                        @foreach ($planesDisponibles as $planDisponible)
                                            <div class="plan-card"
                                                wire:click="seleccionarPlan({{ $planDisponible['id'] }})">
                                                <div class="plan-header">
                                                    <h6 class="plan-nombre">{{ $planDisponible['actividad']['nombre'] }}
                                                    </h6>
                                                    <span
                                                        class="plan-precio">${{ number_format($planDisponible['precio_plan'], 0, ',', '.') }}</span>
                                                </div>
                                                <div class="plan-details">
                                                    <span
                                                        class="plan-duracion">{{ $planDisponible['dias_acceso_actividad'] }}
                                                        días</span>
                                                    <span
                                                        class="plan-precio-dia">${{ number_format($planDisponible['precio_plan'] / $planDisponible['dias_acceso_actividad'], 0, ',', '.') }}/día</span>
                                                </div>
                                                <div class="plan-action">
                                                    <svg width="16" height="16" viewBox="0 0 24 24"
                                                        fill="currentColor">
                                                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @elseif($vistaPlanes === 'busqueda' && strlen($busquedaPlan) >= 2 && !$cargandoPlanes)
                            <div class="alert alert-warning">
                                <svg width="16" height="16" fill="currentColor" class="me-2"
                                    viewBox="0 0 24 24">
                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                                </svg>
                                No se encontraron planes que coincidan con la búsqueda.
                            </div>
                        @endif

                        {{-- PASO 2: SELECCIÓN DE CLIENTE --}}
                    @elseif($paso === 'cliente' && $plan)
                        <!-- Información del Plan Seleccionado -->
                        <div class="plan-selected-info mb-3">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                            class="me-2 text-primary">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                        <div>
                                            <strong>{{ $plan->actividad->nombre }}</strong><br>
                                            <small class="text-muted">
                                                ${{ number_format($plan->precio_plan, 0, ',', '.') }} •
                                                {{ $plan->dias_acceso_actividad }} días •
                                                ${{ number_format($plan->precio_plan / $plan->dias_acceso_actividad, 0, ',', '.') }}
                                                por día
                                            </small>
                                        </div>
                                    </div>
                                    <x-boton variante="terciario" tamanio="pequenio" wireClick="volverAPlan">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"
                                            class="me-1">
                                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                                        </svg>
                                        Cambiar
                                    </x-boton>
                                </div>
                            </div>
                        </div>

                        <!-- Buscador de Clientes -->
                        <x-input type="text" name="busquedaCliente" label="Buscar cliente"
                            placeholder="Nombre, apellido, email o teléfono..." livewire="busquedaCliente"
                            livewireModifier="live.debounce.300ms" errorField="clienteSeleccionado"
                            autocomplete="off" :loading="$cargandoBusqueda" help="Escribe al menos 2 caracteres para buscar" />

                        <!-- Resultados de Búsqueda de Clientes -->
                        @if (count($clientesBusqueda) > 0)
                            <div class="clientes-resultados mb-3">
                                <label class="form-label">Seleccionar cliente:</label>
                                <div class="clientes-lista">
                                    @foreach ($clientesBusqueda as $cliente)
                                        <div class="cliente-item {{ $clienteSeleccionado == $cliente['id'] ? 'selected' : '' }}"
                                            wire:click="seleccionarCliente({{ $cliente['id'] }})">
                                            <div class="cliente-radio">
                                                <input type="radio" name="clienteSeleccionado"
                                                    value="{{ $cliente['id'] }}"
                                                    @if ($clienteSeleccionado == $cliente['id']) checked @endif readonly>
                                            </div>
                                            <div class="cliente-info">
                                                <div class="cliente-nombre">
                                                    {{ $cliente['nombre'] }} {{ $cliente['apellido'] }}
                                                </div>
                                                <div class="cliente-detalles">
                                                    {{ $cliente['email'] }} • {{ $cliente['telefono'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(strlen($busquedaCliente) >= 2 && !$cargandoBusqueda)
                            <div class="alert alert-warning">
                                <svg width="16" height="16" fill="currentColor" class="me-2"
                                    viewBox="0 0 24 24">
                                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                                </svg>
                                No se encontraron clientes que coincidan con la búsqueda.
                            </div>
                        @endif
                    @endif

                </div>

                <!-- Footer del Modal -->
                <div class="modal-footer">
                    @if ($paso === 'plan')
                        <x-boton tipo="button" variante="secundario" wireClick="cerrar">
                            Cancelar
                        </x-boton>
                    @else
                        <x-boton tipo="button" variante="secundario" wireClick="cerrar" :deshabilitado="$cargandoAsignacion">
                            Cancelar
                        </x-boton>
                        <x-boton tipo="button" variante="terciario" wireClick="volverAPlan" :deshabilitado="$cargandoAsignacion">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                class="me-1">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                            </svg>
                            Volver
                        </x-boton>


                        <x-boton tipo="button" variante="primario" wireClick="asignarPlan" :deshabilitado="!$clienteSeleccionado || $cargandoAsignacion"
                            :cargando="$cargandoAsignacion" textoCargando="Asignando...">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                class="me-1">
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                            </svg>
                            Asignar Plan
                        </x-boton>
                    @endif
                </div>

            </div>
        </div>
    @endif

    {{-- ✅ SCRIPT PARA ESCUCHAR EVENTOS JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Escuchar evento global para abrir modal
            window.addEventListener('abrir-modal-asignar-plan', function(event) {
                const planId = event.detail?.planId || null;

                // Emitir evento Livewire
                if (planId) {
                    @this.call('abrirDesdeJS', planId);
                } else {
                    @this.call('abrirDesdeJS');
                }
            });
        });

        // ✅ FUNCIÓN GLOBAL PARA USO DESDE CUALQUIER LUGAR
        window.abrirModalAsignarPlan = function(planId = null) {
            window.dispatchEvent(new CustomEvent('abrir-modal-asignar-plan', {
                detail: {
                    planId: planId
                }
            }));
        };
    </script>

    {{-- Estilos del Modal --}}
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-container {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f8f9fa;
            gap: 1rem;
        }

        .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
        }

        .steps-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .step {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            background-color: #e9ecef;
            color: #6c757d;
            transition: all 0.2s;
        }

        .step.active {
            background-color: #0d6efd;
            color: white;
        }

        .step.completed {
            background-color: #198754;
            color: white;
        }

        .step-divider {
            width: 20px;
            height: 2px;
            background-color: #e9ecef;
        }

        .modal-close {
            background: none;
            border: none;
            padding: 0.5rem;
            border-radius: 0.25rem;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #dee2e6;
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            background-color: #f8f9fa;
        }

        /* Estilos para actividades */
        .actividades-grid {
            display: grid;
            gap: 0.5rem;
        }

        .actividad-card {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .actividad-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9ff;
        }

        .actividad-card.selected {
            border-color: #0d6efd;
            background-color: #e7f3ff;
        }

        .actividad-nombre {
            margin: 0 0 0.25rem 0;
            font-weight: 500;
        }

        .actividad-arrow {
            color: #6c757d;
            transition: transform 0.2s;
        }

        .actividad-card:hover .actividad-arrow {
            transform: translateX(2px);
        }

        /* Estilos para planes */
        .planes-grid {
            display: grid;
            gap: 0.75rem;
        }

        .plan-card {
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }

        .plan-card:hover {
            border-color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
            transform: translateY(-1px);
        }

        .plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .plan-nombre {
            margin: 0;
            font-weight: 600;
            color: #212529;
        }

        .plan-precio {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .plan-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .plan-action {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.5rem;
            color: #0d6efd;
        }

        /* Estilos existentes para clientes */
        .clientes-lista {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .cliente-item {
            padding: 0.75rem;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cliente-item:last-child {
            border-bottom: none;
        }

        .cliente-item:hover {
            background-color: #f8f9fa;
        }

        .cliente-item.selected {
            background-color: #e7f3ff;
            border-color: #b6d7ff;
        }

        .cliente-radio {
            flex-shrink: 0;
        }

        .cliente-info {
            flex-grow: 1;
        }

        .cliente-nombre {
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .cliente-detalles {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .modal-overlay {
                padding: 0.5rem;
            }

            .modal-container {
                max-height: 95vh;
                max-width: 95vw;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .modal-footer {
                flex-wrap: wrap;
            }
        }
    </style>

    {{-- Estilos del Modal --}}
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-container {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f8f9fa;
        }

        .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
        }

        .modal-close {
            background: none;
            border: none;
            padding: 0.5rem;
            border-radius: 0.25rem;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #dee2e6;
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            background-color: #f8f9fa;
        }

        .clientes-lista {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .cliente-item {
            padding: 0.75rem;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cliente-item:last-child {
            border-bottom: none;
        }

        .cliente-item:hover {
            background-color: #f8f9fa;
        }

        .cliente-item.selected {
            background-color: #e7f3ff;
            border-color: #b6d7ff;
        }

        .cliente-radio {
            flex-shrink: 0;
        }

        .cliente-info {
            flex-grow: 1;
        }

        .cliente-nombre {
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .cliente-detalles {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .modal-overlay {
                padding: 0.5rem;
            }

            .modal-container {
                max-height: 95vh;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
</div>
