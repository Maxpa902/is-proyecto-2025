{{-- resources/views/livewire/recepcionista/planes/mostrar.blade.php --}}
<div class="table-layout">
    <div class="header-stats mb-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path
                                    d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                            </svg>
                            Planes
                        </h2>
                        <p class="text-muted mb-0">Gestiona los planes de actividades</p>
                    </div>

                    <x-boton variante="primario" ruta="planes.crear">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Nuevo Plan
                    </x-boton>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stats-quick d-flex gap-2">
                    <x-etiqueta type="info" variant="soft" size="lg">
                        @if ($estadisticas['total_planes'] == 1)
                            {{ $estadisticas['total_planes'] }} plan
                        @else
                            {{ $estadisticas['total_planes'] }} planes
                        @endif
                    </x-etiqueta>
                    <x-etiqueta type="success" variant="soft" size="lg">
                        @if ($estadisticas['total_clientes_activos'] == 1)
                            {{ $estadisticas['total_clientes_activos'] }} cliente activo
                        @else
                            {{ $estadisticas['total_clientes_activos'] }} clientes activos
                        @endif
                    </x-etiqueta>
                    <x-etiqueta type="primary" variant="soft" size="lg">
                        ${{ number_format($estadisticas['precio_promedio'], 0, ',', '.') }} promedio
                    </x-etiqueta>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de planes -->
    <div class="planes-list">
        @forelse($planes as $plan)
            <div class="plan-card-horizontal mb-3" wire:key="plan-{{ $plan->id }}">
                <x-tarjeta variant="default" size="md">
                    <div class="row align-items-center">
                        <!-- Información principal -->
                        <div class="col-lg-5">
                            <div class="plan-info">
                                <h5 class="plan-title mb-1">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-2 text-primary">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    {{ $plan->actividad->nombre }}
                                </h5>
                                <div class="plan-details">
                                    <span class="text-muted">Plan creado el
                                        {{ $plan->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="col-lg-3">
                            <div class="plan-pricing text-center">
                                <div class="price-main">
                                    <span class="price-currency">$</span>
                                    <span
                                        class="price-amount">{{ number_format($plan->precio_plan, 0, ',', '.') }}</span>
                                </div>
                                <div class="price-details">
                                    <x-etiqueta type="primary" variant="soft" size="md">
                                        {{ $plan->dias_acceso_actividad }} días
                                    </x-etiqueta>
                                    <small class="text-muted d-block mt-1">
                                        ${{ number_format($plan->precio_plan / $plan->dias_acceso_actividad, 0, ',', '.') }}
                                        por día
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="col-lg-2">
                            <div class="plan-stats text-center">
                                <div class="stat-number">{{ $plan->cantidad_clientes_activos ?? 0 }}</div>
                                <div class="stat-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                        class="me-1">
                                        <path
                                            d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3z" />
                                    </svg>
                                    Cliente{{ $plan->cantidad_clientes_activos !== 1 ? 's' : '' }}
                                </div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="col-lg-2">
                            <div class="plan-actions d-flex flex-column gap-1">
                                <!-- ✅ BOTÓN SIMPLE CON WIRE:CLICK -->
                                <x-boton tamanio="pequenio" wireClick="abrirModalAsignar({{ $plan->id }})">
                                    Asignar
                                </x-boton>

                                <div class="row justify-content-around" role="group">
                                    <div class="col-5">
                                        <x-boton variante="terciario" tamanio="pequenio" ruta="planes.editar"
                                            :parametros="['id' => $plan->id]" :anchoCompleto="true">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                            </svg>
                                        </x-boton>
                                    </div>
                                    <div class="col-5">
                                        <x-boton variante="acento" tamanio="pequenio"
                                            wireClick="eliminarPlan({{ $plan->id }})"
                                        wire:confirm="¿Estás seguro de eliminar este plan?" :anchoCompleto="true">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                            </svg>
                                        </x-boton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-tarjeta>
            </div>
        @empty
            <div class="empty-state text-center py-5">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor" class="text-muted mb-3">
                    <path
                        d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                </svg>
                <h5 class="text-muted">No hay planes disponibles</h5>
                <p class="text-muted">
                    @if ($busqueda || $filtroActividad)
                        No se encontraron planes que coincidan con los filtros aplicados.
                    @else
                        Aún no has creado ningún plan. ¡Crea tu primer plan!
                    @endif
                </p>
                @if ($busqueda || $filtroActividad)
                    <x-boton variante="terciario" wire:click="limpiarFiltros">
                        Limpiar filtros
                    </x-boton>
                @else
                    <x-boton variante="primario" ruta="planes.crear">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Crear primer plan
                    </x-boton>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if ($planes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $planes->links() }}
        </div>
    @endif

    <!-- ✅ MODAL LIVEWIRE COMPONENTE -->
    <livewire:modal-asignar-plan />
</div>
