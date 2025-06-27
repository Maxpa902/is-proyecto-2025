{{-- resources/views/livewire/notificacion.blade.php --}}
<div class="contenedor-notificaciones contenedor-top-right" wire:ignore.self>
    @if (is_array($notificaciones) && count($notificaciones) > 0)
        @foreach ($notificaciones as $notificacion)
            @php
                $clasesTipo = [
                    'exito' => 'notificacion-exito',
                    'error' => 'notificacion-error',
                    'advertencia' => 'notificacion-advertencia',
                    'info' => 'notificacion-info',
                ];
                $claseTipo = $clasesTipo[$notificacion['tipo']] ?? 'notificacion-info';

                $iconosPorTipo = [
                    'exito' =>
                        '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>',
                    'error' =>
                        '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>',
                    'advertencia' =>
                        '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
                    'info' =>
                        '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>',
                ];
                $icono = $notificacion['icono'] ?? ($iconosPorTipo[$notificacion['tipo']] ?? $iconosPorTipo['info']);
            @endphp

            <div class="notificacion-item {{ $claseTipo }}" wire:key="notif-{{ $notificacion['id'] }}"
                x-data="notificacionData({{ $notificacion['duracion'] }}, {{ $notificacion['persistente'] ? 'true' : 'false' }}, '{{ $notificacion['id'] }}')" x-show="visible" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full">
                <!-- Contenido de la notificación -->
                <div class="notificacion-contenido">
                    <!-- Icono -->
                    <div class="notificacion-icono">
                        {!! $icono !!}
                    </div>

                    <!-- Texto -->
                    <div class="notificacion-texto">
                        @if ($notificacion['titulo'])
                            <div class="notificacion-titulo">{{ $notificacion['titulo'] }}</div>
                        @endif
                        <div class="notificacion-mensaje">{{ $notificacion['mensaje'] }}</div>
                    </div>

                    <!-- Botón cerrar -->
                    @if ($notificacion['descartable'])
                        <button class="notificacion-cerrar" wire:click="cerrarNotificacion('{{ $notificacion['id'] }}')"
                            @click="cerrarNotificacion()" type="button" aria-label="Cerrar notificación">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Barra de progreso (solo si no es persistente) -->
                @if (!$notificacion['persistente'] && $notificacion['duracion'] > 0)
                    <div class="notificacion-progreso">
                        <div class="notificacion-progreso-barra"
                            x-bind:style="`width: ${progreso}%; transition: width ${duracion}ms linear;`"></div>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    {{-- Script incluido dentro del elemento raíz para evitar múltiples elementos --}}
    <script>
        window.notificacionData = function(duracion, persistente, id) {
            return {
                visible: true,
                progreso: 100,
                duracion: duracion,
                persistente: persistente,
                id: id,

                init() {
                    if (!this.persistente && this.duracion > 0) {
                        this.iniciarProgreso();
                        this.programarCierre();
                    }
                },

                iniciarProgreso() {
                    this.progreso = 100;
                    setTimeout(() => {
                        this.progreso = 0;
                    }, 50);
                },

                programarCierre() {
                    setTimeout(() => {
                        this.cerrarNotificacion();
                    }, this.duracion);
                },

                cerrarNotificacion() {
                    this.visible = false;
                    setTimeout(() => {
                        this.$wire.cerrarNotificacion(this.id);
                    }, 200);
                }
            }
        }
    </script>
</div>
