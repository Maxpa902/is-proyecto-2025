{{-- resources/views/livewire/recepcionista/bienvenida.blade.php --}}
<div>
    <div class="container-fluid">

        {{-- Menu principal --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4">
                <x-tarjeta title="👥 Gestión de Clientes" subtitle="Alta, baja y modificación" variant="elevated"
                    clickable="true" size="lg" onclick="showView('client-management')">

                    <div class="row text-center mt-3">
                        <div class="col-4">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_clientes['activos'] }}</h5>
                                <small class="text-muted">Total activos</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_clientes['nuevos_mes'] }}</h5>
                                <small class="text-muted">Nuevos este mes</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_clientes['inactivos'] }}</h5>
                                <small class="text-muted">Total inactivos</small>
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="d-flex justify-content-between">
                            <x-boton variante="primario" tamanio="pequenio" ruta="clientes.crear">
                                Nuevo Cliente
                            </x-boton>
                            <x-boton variante="terciario" tamanio="pequenio" ruta="clientes.mostrar">
                                Ver todos →
                            </x-boton>
                        </div>
                    </x-slot>
                </x-tarjeta>
            </div>

            <div class="col-lg-6 col-md-6 mb-4">
                <x-tarjeta title="📅 Calendario y Clases" subtitle="Gestionar horarios" variant="elevated"
                    clickable="true" size="lg" onclick="showView('calendar-management')">

                    <div class="row text-center mt-3">
                        <div class="col-4">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_sesiones['hoy'] }}</h5>
                                <small class="text-muted">Hoy</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_sesiones['semana'] }}</h5>
                                <small class="text-muted">Esta semana</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_sesiones['mes'] }}</h5>
                                <small class="text-muted">Este mes</small>
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="d-flex justify-content-between">
                            <x-boton variante="acento" tamanio="pequenio" ruta="clases.crear">
                                Programar Clase
                            </x-boton>
                            <x-boton variante="terciario" tamanio="pequenio" ruta="clases.mostrar">
                                Ver calendario →
                            </x-boton>
                        </div>
                    </x-slot>
                </x-tarjeta>
            </div>

            <div class="col-lg-12 col-md-6 mb-4">
                <x-tarjeta title="💳 Planes" subtitle="Asignar planes" variant="elevated"
                    size="lg">

                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_planes['totales'] }}</h5>
                                <small class="text-muted">{{ $estadisticas_planes['totales'] != '1' ? 'Planes totales' : 'Plan total' }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-stats">
                                <h5 class="mb-1">{{ $estadisticas_planes['asignados'] }}</h5>
                                <small class="text-muted">{{ $estadisticas_planes['asignados'] != '1' ? 'Planes asignados' : 'Plan asignado'}}</small>
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="d-flex justify-content-between">
                            <x-boton tamanio="pequenio" wireClick="abrirModalAsignar">
                                Asignar Plan
                            </x-boton>
                            <x-boton variante="terciario" tamanio="pequenio" ruta="planes.mostrar">
                                Ver planes →
                            </x-boton>
                        </div>
                    </x-slot>
                </x-tarjeta>
            </div>

            {{-- <div class="col-lg-6 col-md-6 mb-4">
                <x-tarjeta title="📊 Reportes" subtitle="Asistencia e inscripciones" variant="elevated" clickable="true"
                    size="lg" onclick="showView('reports')">

                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <div class="card-stats">
                                <h5 class="mb-1">92%</h5>
                                <small class="text-muted">Asistencia</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-stats">
                                <h5 class="mb-1">$8,450</h5>
                                <small class="text-muted">Ingresos</small>
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="d-flex">
                            <x-boton variante="terciario" tamanio="pequenio" onclick="showView('reports')">
                                Ver reportes →
                            </x-boton>
                        </div>
                    </x-slot>
                </x-tarjeta>
            </div> --}}
        </div>
    </div>

    {{-- ✅ MODAL - Verificar que el namespace sea correcto --}}
    <livewire:modal-asignar-plan />
    {{-- ✅ Debug: Verificar que el modal se incluye --}}
    <script>
        console.log('🔍 Vista bienvenida cargada con modal incluido');

        // Funciones de navegación y acciones rápidas
        function showView(view) {
            console.log('Navegando a:', view);
            // lógica de navegación
        }
    </script>
</div>
