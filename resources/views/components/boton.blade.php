@props([
    'tipo' => 'button',
    'variante' => 'primario',
    'tamanio' => 'mediano',
    'deshabilitado' => false,
    'anchoCompleto' => false,
    'cargando' => false,
    'ruta' => '',
    'parametros' => [],
    'textoCargando' => 'Procesando...',

    // ✅ NUEVOS PROPS PARA ALPINE.JS
    'xData' => false, // Para x-data
    'onClick' => '', // Para @click
    'wireClick' => '', // Para wire:click
    'modalOpen' => '', // Para $dispatch('open-modal-xxx')
    'modalClose' => '', // Para $dispatch('close-modal-xxx')
])

@php
    $clasesDeTamanio = [
        'pequenio' => 'boton-pequenio',
        'mediano' => '',
        'grande' => 'boton-grande',
    ];

    $clasesDeVariante = [
        'primario' => 'boton-primario',
        'secundario' => 'boton-secundario',
        'terciario' => 'boton-terciario',
        'acento' => 'boton-acento',
    ];

    $clasesAncho = $anchoCompleto ? 'boton-ancho-completo' : '';
    $clasesCargando = $cargando ? 'boton-cargando' : '';

    $clases = collect([
        $clasesDeVariante[$variante] ?? $clasesDeVariante['primario'],
        $clasesDeTamanio[$tamanio] ?? '',
        $clasesAncho,
        $clasesCargando,
    ])
        ->filter()
        ->implode(' ');

    // Si está cargando, deshabilitar el botón
    $estaDeshabilitado = $deshabilitado || $cargando;

    $parametros = is_array($parametros) ? $parametros : [];

    // ✅ CONSTRUIR ATRIBUTOS - LÓGICA CORREGIDA

    // Determinar si necesitamos Alpine.js o Livewire directo
    $necesitaAlpine = $modalOpen || $modalClose || ($onClick && !$wireClick);
    $soloLivewire = $wireClick && !$modalOpen && !$modalClose && !$onClick;

    $alpineAttributes = [];

    // ✅ CASO 1: Solo Livewire (wire:click directo - más eficiente)
    if ($soloLivewire) {
        $alpineAttributes['wire:click'] = $wireClick;
    }

    // ✅ CASO 2: Alpine.js necesario (combinar acciones en @click)
    elseif ($necesitaAlpine || ($wireClick && ($modalOpen || $modalClose || $onClick))) {
        $clickActions = [];

        // x-data solo si realmente necesitamos Alpine
        if ($xData !== false) {
            $alpineAttributes['x-data'] = $xData === true ? '' : $xData;
        }

        if ($wireClick) {
            $clickActions[] = "\$wire.{$wireClick}";
        }

        if ($modalOpen) {
            $clickActions[] = "\$dispatch('open-modal-{$modalOpen}')";
        }

        if ($modalClose) {
            $clickActions[] = "\$dispatch('close-modal-{$modalClose}')";
        }

        if ($onClick) {
            $clickActions[] = $onClick;
        }

        if (!empty($clickActions)) {
            $alpineAttributes['@click'] = implode('; ', $clickActions);
        }
    }

    // ✅ CASO 3: Solo onclick nativo (sin Alpine ni Livewire)
    elseif ($onClick && !$wireClick && !$modalOpen && !$modalClose) {
        $alpineAttributes['onclick'] = $onClick;
    }

@endphp

@if ($ruta != '')
    <a href="{{ route($ruta, $parametros) }}" class="{{ $clases }}"
        @foreach ($alpineAttributes as $attr => $value)
       {{ $attr }}="{{ $value }}" @endforeach
        {{ $attributes->except(['class', 'x-data', '@click', 'wire:click', 'onclick']) }}>
        <span class="boton-contenido">{{ $slot }}</span>
    </a>
@else
    <button type="{{ $tipo }}"
        {{ $attributes->merge(['class' => $clases])->except(['x-data', '@click', 'wire:click', 'onclick']) }}
        @foreach ($alpineAttributes as $attr => $value)
        {{ $attr }}="{{ $value }}" @endforeach
        @if ($estaDeshabilitado) disabled @endif>
        @if ($cargando)
            <!-- Spinner según el tipo seleccionado -->
            <svg class="boton-spinner" viewBox="0 0 24 24">
                <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"
                    fill="currentColor" />
                <path
                    d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z"
                    fill="currentColor" />
            </svg>
            <span class="boton-texto-cargando">{{ $textoCargando }}</span>
        @else
            <!-- Contenido normal -->
            <span class="boton-contenido">{{ $slot }}</span>
        @endif
    </button>
@endif
