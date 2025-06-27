@php
    use Carbon\Carbon;
    $hoy = Carbon::now()->dayOfWeekIso;

    $diasNormalizados = [
        'lunes' => 'lunes',
        'martes' => 'martes',
        'miercoles' => 'miércoles',
        'jueves' => 'jueves',
        'viernes' => 'viernes',
        'sabado' => 'sábado',
        'domingo' => 'domingo',
    ];

    $diasSemana = [];
    for ($i = 1; $i <= 7; $i++) {
        $date = Carbon::now()
            ->startOfWeek(\Carbon\CarbonInterface::MONDAY)
            ->addDays($i - 1);
        $nombreDiaNormalizado = strtolower($date->format('l'));

        $nombresDias = [
            'monday' => 'lunes',
            'tuesday' => 'martes',
            'wednesday' => 'miercoles',
            'thursday' => 'jueves',
            'friday' => 'viernes',
            'saturday' => 'sabado',
            'sunday' => 'domingo',
        ];

        $diaKey = $nombresDias[$nombreDiaNormalizado];

        $diasSemana[$diaKey] = [
            'fecha_completa' =>
                ucfirst($diasNormalizados[$diaKey]) . ' ' . $date->day . ' de ' . $date->isoFormat('MMMM'),
        ];
    }
@endphp

<div>
    <h2 class="calendario-titulo">Horarios Semanales</h2>

    <div class="calendario-columnas">
        @foreach ($clasesPorDia as $dia => $clases)
            @php
                $diaInfo = $diasSemana[strtolower($dia)] ?? null;
            @endphp

            <div class="columna-dia">
                <h3>
                    @if (Auth::user()->hasRole('recepcionista'))
                        {{ ucfirst($dia) }}
                    @else
                        {{ $diaInfo['fecha_completa'] ?? $dia }}
                    @endif
                </h3>

                @forelse ($clases as $clase)
                    <div class="actividad-horario">
                        <b><span class="hora">{{ $clase['hora_inicio'] }} - {{ $clase['hora_fin'] }}</span></b>
                        <span class="actividad">{{ $clase['profesor'] }}<br>{{ $clase['lugar'] }}</span>

                        @if (Auth::user()->hasRole('cliente') && $clase['puede_inscribirse'])
                            @if ($clase['esta_inscripto'])
                                <button wire:click="darDeBaja({{ $clase['inscripcion_id'] }})"
                                    wire:loading.attr="disabled" wire:target="darDeBaja({{ $clase['inscripcion_id'] }})"
                                    class="boton-acento boton-pequenio">
                                    <span wire:loading.remove wire:target="darDeBaja({{ $clase['inscripcion_id'] }})">✓
                                        Dar de baja</span>
                                    <span wire:loading
                                        wire:target="darDeBaja({{ $clase['inscripcion_id'] }})">Procesando...</span>
                                </button>
                            @else
                                <button wire:click="inscribirse({{ $clase['id'] }}, {{ $clase['idDiaSemana'] }})"
                                    wire:loading.attr="disabled"
                                    wire:target="inscribirse({{ $clase['id'] }}, {{ $clase['idDiaSemana'] }})"
                                    class="boton-terciario boton-pequenio">
                                    <span wire:loading.remove
                                        wire:target="inscribirse({{ $clase['id'] }}, {{ $clase['idDiaSemana'] }})">Anotarse
                                        a clase</span>
                                    <span wire:loading
                                        wire:target="inscribirse({{ $clase['id'] }}, {{ $clase['idDiaSemana'] }})">Inscribiendo...</span>
                                </button>
                            @endif
                        @elseif (Auth::user()->hasRole('recepcionista'))
                            <x-boton ruta="clases.ver" :parametros="['id' => $clase['id']]" variante="terciario">
                                Ver clase #{{ $clase['numero_clase'] }}
                            </x-boton>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">No hay clases</p>
                @endforelse
            </div>
        @endforeach
    </div>
</div>
