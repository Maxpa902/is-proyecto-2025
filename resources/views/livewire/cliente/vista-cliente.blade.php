@push('styles')
    @vite('resources/css/components/colores.css')
    @vite('resources/css/components/calendario.css')
@endpush

<div class="container-fluid p-0 m-0">
    <livewire:notificacion />
    <div class="w-100 vh-100 bg-light p-3 shadow-sm">

        {{-- Horarios Semanales - Ahora es un componente Livewire independiente --}}
        <div class="bg-white rounded shadow-sm p-4 mb-4">
            <div class="row text-center card-footer">
                <livewire:cliente.calendario-clases />
            </div>
        </div>

        {{-- Inscripciones actuales --}}
        {{-- <div class="bg-white rounded shadow-sm p-4">
            <h2 class="calendario-titulo mb-4">Mis Inscripciones Activas</h2>
            @if (count($inscripcionesActivas) === 0)
                <div class="alert alert-info text-center">
                    No tenés inscripciones activas por el momento.
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    @foreach ($inscripcionesActivas as $inscripcion)
                        <div class="col">
                            <x-tarjeta :title="$inscripcion['actividad']" :subtitle="'📅 ' . ucfirst($inscripcion['dia'])" variant="bordered" size="md">

                                Contenido principal
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">📆 Fecha:</strong>
                                        <span>{{ $inscripcion['fecha'] }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">🕐 Horario:</strong>
                                        <span>{{ $inscripcion['hora'] }}</span>
                                    </div>
                                </div>

                                Footer con botón
                                <x-slot name="footer">
                                    <div class="d-flex justify-content-end">
                                        <x-boton wire:click="darDeBaja({{ $inscripcion['id'] }})" variante="acento"
                                            style="margin-bottom: 0px">
                                            Dar de baja
                                        </x-boton>
                                    </div>
                                </x-slot>
                            </x-tarjeta>
                        </div>
                    @endforeach
                </div>
            @endif
        </div> --}}
    </div>
</div>
