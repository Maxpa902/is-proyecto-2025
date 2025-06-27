@props(['clasesPorDia'])

@php
    use Carbon\Carbon;
    $hoy = Carbon::now()->dayOfWeekIso; // 1 (Lunes) ... 7 (Domingo)

    // Mapeo de días sin acentos (como los tienes en tu sistema)
    $diasNormalizados = [
        'lunes' => 'lunes',
        'martes' => 'martes',
        'miercoles' => 'miércoles',
        'jueves' => 'jueves',
        'viernes' => 'viernes',
        'sabado' => 'sábado',
        'domingo' => 'domingo',
    ];

    // Generamos los días de esta semana con fecha completa
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
            'nombre' => ucfirst($diasNormalizados[$diaKey]),
            'numero' => $date->day,
            'mes' => $date->isoFormat('MMMM'),
            'fecha_completa' =>
                ucfirst($diasNormalizados[$diaKey]) . ' ' . $date->day . ' de ' . $date->isoFormat('MMMM'),
            'carbon' => $date,
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
                    {{ ucfirst($dia) }}

                </h3>

                @forelse ($clases as $clase)
                    <div class="actividad-horario">
                        <b><span class="hora">{{ \Carbon\Carbon::parse($clase['hora_inicio'])->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($clase['hora_fin'])->format('H:i') }}</span></b>
                        <span class="actividad">{{ $clase['profesor'] }}<br>{{ $clase['lugar'] }}</span>

                        @auth
                            @if (Auth::user()->hasRole('cliente') && $clase['idDiaSemana'] >= $hoy)
                                @if ($clase['esta_inscripto'])
                                    {{-- Usuario ya inscripto - Mostrar botón de dar de baja --}}
                                    <x-boton wireClick="darDeBaja({{ $clase['inscripcion_id'] }})" variante="acento"
                                        tamanio="pequenio" class="mt-2">
                                        ✓ Dar de baja
                                    </x-boton>
                                @else
                                    {{-- Usuario no inscripto - Mostrar botón de inscripción --}}
                                    <x-boton wireClick="inscribirse({{ $clase['id'] }}, {{ $clase['idDiaSemana'] }})"
                                        variante="terciario" tamanio="pequenio" class="mt-2">
                                        Anotarse a clase
                                    </x-boton>
                                @endif
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="text-muted">No hay clases</p>
                @endforelse
            </div>
        @endforeach
    </div>
</div>
