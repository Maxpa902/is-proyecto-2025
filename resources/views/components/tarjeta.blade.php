@props([
    'title' => null,
    'subtitle' => null,
    'image' => null,
    'imageAlt' => '',
    'variant' => 'default', // default, bordered, elevated, outline
    'size' => 'md', // sm, md, lg
    'clickable' => false,
    'href' => null,
    'loading' => false,
])

@php
$cardClasses = 'card';

// Variantes
switch($variant) {
    case 'bordered':
        $cardClasses .= ' border-2';
        break;
    case 'elevated':
        $cardClasses .= ' shadow-lg border-0';
        break;
    case 'outline':
        $cardClasses .= ' border-primary bg-transparent';
        break;
    default:
        $cardClasses .= ' shadow-sm';
}

// Tamaños
switch($size) {
    case 'sm':
        $cardClasses .= ' card-sm';
        break;
    case 'lg':
        $cardClasses .= ' card-lg';
        break;
}

// Clickable
if($clickable || $href) {
    $cardClasses .= ' card-clickable';
}

$cardElement = $href ? 'a' : 'div';
$cardAttributes = $href ? 'href="' . $href . '"' : '';
@endphp

<style>
/* Estilos para las cards */
.card-clickable {
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.card-clickable:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
}

.card-sm {
    font-size: 0.875rem;
}

.card-sm .card-header {
    padding: 0.75rem 1rem;
}

.card-sm .card-body {
    padding: 1rem;
}

.card-lg .card-header {
    padding: 1.25rem 1.5rem;
}

.card-lg .card-body {
    padding: 1.5rem;
}

.card-loading {
    position: relative;
    pointer-events: none;
}

.card-loading::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    border-radius: inherit;
    z-index: 10;
}

.card-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 24px;
    height: 24px;
    margin: -12px 0 0 -12px;
    border: 2px solid #e9ecef;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 11;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.card-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.card-notificacion {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
}

.card-stats {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.75rem;
    text-align: center;
}
</style>

<{{ $cardElement }}
    class="{{ $cardClasses }} {{ $loading ? 'card-loading' : '' }}"
    @if($href) {!! $cardAttributes !!} @endif
    @if($clickable && !$href)
        x-data
        @click="$dispatch('card-clicked', { card: $el })"
    @endif>

    {{-- Imagen superior --}}
    @if($image)
        <div class="position-relative">
            <img src="{{ $image }}"
                 class="card-img-top"
                 alt="{{ $imageAlt }}"
                 style="height: 200px; object-fit: cover;">

            {{-- notificacion sobre imagen --}}
            @isset($notificacion)
                <div class="card-notificacion">
                    {{ $notificacion }}
                </div>
            @endisset
        </div>
    @endif

    {{-- Header --}}
    @if($title || $subtitle || isset($header))
        <div class="card-header d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                @if($title)
                    <h5 class="card-title mb-0">{{ $title }}</h5>
                @endif
                @if($subtitle)
                    <small class="text-muted">{{ $subtitle }}</small>
                @endif

                {{-- Header personalizado --}}
                @isset($header)
                    {{ $header }}
                @endisset
            </div>

            {{-- Acciones en header --}}
            @isset($actions)
                <div class="d-flex gap-1">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    {{-- Body principal --}}
    <div class="card-body">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset

</{{ $cardElement }}>

{{-- Slot para tarjetas especializadas --}}
@isset($specialized)
    {{ $specialized }}
@endisset
