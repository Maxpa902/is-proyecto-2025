{{-- resources/views/components/etiqueta.blade.php --}}
@props([
    'type' => 'secondary',    // primary, secondary, success, danger, warning, info, light, dark
    'size' => 'md',          // sm, md, lg
    'variant' => 'solid',    // solid, outline, soft
    'icon' => null,
    'dot' => false,          // Solo mostrar un punto de color
    'pulse' => false,        // Animación de pulso
    'rounded' => true,       // Bordes redondeados
    'text' => null,          // Texto del etiqueta (alternativa al slot)
])

@php
$etiquetaClasses = 'etiqueta';

// Tipos base
$typeClasses = [
    'primary' => 'etiqueta-primary',
    'secondary' => 'etiqueta-secondary',
    'success' => 'etiqueta-success',
    'danger' => 'etiqueta-danger',
    'warning' => 'etiqueta-warning',
    'info' => 'etiqueta-info',
    'light' => 'etiqueta-light',
    'dark' => 'etiqueta-dark',

    // Estados específicos para natación
    'activo' => 'etiqueta-success',
    'inactivo' => 'etiqueta-secondary',
    'moroso' => 'etiqueta-danger',
    'suspendido' => 'etiqueta-warning',
    'pendiente' => 'etiqueta-warning',
    'cancelado' => 'etiqueta-danger',
    'programado' => 'etiqueta-info',
    'en-curso' => 'etiqueta-primary',
    'finalizado' => 'etiqueta-success',

    // Niveles de natación
    'principiante' => 'etiqueta-info',
    'intermedio' => 'etiqueta-warning',
    'avanzado' => 'etiqueta-success',
    'competencia' => 'etiqueta-primary',
];

$etiquetaClasses .= ' ' . ($typeClasses[$type] ?? $typeClasses['secondary']);

// Variantes
$etiquetaClasses .= ' etiqueta-' . $variant;

// Tamaños
switch($size) {
    case 'sm':
        $etiquetaClasses .= ' etiqueta-sm';
        break;
    case 'lg':
        $etiquetaClasses .= ' etiqueta-lg';
        break;
}

// Modificadores
if (!$rounded) $etiquetaClasses .= ' etiqueta-square';
if ($pulse) $etiquetaClasses .= ' etiqueta-pulse';
if ($dot) $etiquetaClasses .= ' etiqueta-dot';
@endphp

<style>
/* Base etiqueta styles */
.etiqueta {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    transition: all 0.15s ease;
}

/* Tamaños */
.etiqueta-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.625rem;
}

.etiqueta-lg {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Variante sólida (por defecto) */
.etiqueta-solid.etiqueta-primary {
    background-color: #007bff;
    color: white;
}

.etiqueta-solid.etiqueta-secondary {
    background-color: #6c757d;
    color: white;
}

.etiqueta-solid.etiqueta-success {
    background-color: #28a745;
    color: white;
}

.etiqueta-solid.etiqueta-danger {
    background-color: #dc3545;
    color: white;
}

.etiqueta-solid.etiqueta-warning {
    background-color: #ffc107;
    color: #212529;
}

.etiqueta-solid.etiqueta-info {
    background-color: #17a2b8;
    color: white;
}

.etiqueta-solid.etiqueta-light {
    background-color: #f8f9fa;
    color: #212529;
}

.etiqueta-solid.etiqueta-dark {
    background-color: #343a40;
    color: white;
}

/* Variante outline */
.etiqueta-outline.etiqueta-primary {
    background-color: transparent;
    border: 1px solid #007bff;
    color: #007bff;
}

.etiqueta-outline.etiqueta-secondary {
    background-color: transparent;
    border: 1px solid #6c757d;
    color: #6c757d;
}

.etiqueta-outline.etiqueta-success {
    background-color: transparent;
    border: 1px solid #28a745;
    color: #28a745;
}

.etiqueta-outline.etiqueta-danger {
    background-color: transparent;
    border: 1px solid #dc3545;
    color: #dc3545;
}

.etiqueta-outline.etiqueta-warning {
    background-color: transparent;
    border: 1px solid #ffc107;
    color: #ffc107;
}

.etiqueta-outline.etiqueta-info {
    background-color: transparent;
    border: 1px solid #17a2b8;
    color: #17a2b8;
}

.etiqueta-outline.etiqueta-light {
    background-color: transparent;
    border: 1px solid #f8f9fa;
    color: #212529;
}

.etiqueta-outline.etiqueta-dark {
    background-color: transparent;
    border: 1px solid #343a40;
    color: #343a40;
}

/* Variante soft */
.etiqueta-soft.etiqueta-primary {
    background-color: rgba(0, 123, 255, 0.1);
    color: #007bff;
}

.etiqueta-soft.etiqueta-secondary {
    background-color: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

.etiqueta-soft.etiqueta-success {
    background-color: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.etiqueta-soft.etiqueta-danger {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.etiqueta-soft.etiqueta-warning {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.etiqueta-soft.etiqueta-info {
    background-color: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.etiqueta-soft.etiqueta-light {
    background-color: rgba(248, 249, 250, 0.5);
    color: #212529;
}

.etiqueta-soft.etiqueta-dark {
    background-color: rgba(52, 58, 64, 0.1);
    color: #343a40;
}

/* Modificadores */
.etiqueta-square {
    border-radius: 0.25rem;
}

.etiqueta-dot {
    padding: 0;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    min-width: 8px;
}

.etiqueta-dot.etiqueta-lg {
    width: 12px;
    height: 12px;
    min-width: 12px;
}

.etiqueta-dot.etiqueta-sm {
    width: 6px;
    height: 6px;
    min-width: 6px;
}

/* Animación de pulso */
.etiqueta-pulse {
    animation: etiqueta-pulse 2s infinite;
}

@keyframes etiqueta-pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Hover effects */
.etiqueta:not(.etiqueta-dot):hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Icons en etiquetas */
.etiqueta i {
    font-size: 0.75em;
}

.etiqueta-sm i {
    font-size: 0.7em;
}

.etiqueta-lg i {
    font-size: 0.8em;
}

/* Responsive */
@media (max-width: 576px) {
    .etiqueta {
        font-size: 0.7rem;
    }

    .etiqueta-sm {
        font-size: 0.6rem;
    }

    .etiqueta-lg {
        font-size: 0.8rem;
    }
}
</style>

@if($dot)
    <span class="{{ $etiquetaClasses }}"
          @if($text) title="{{ $text }}" @endif
          {{ $attributes }}>
    </span>
@else
    <span class="{{ $etiquetaClasses }}" {{ $attributes }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif

        @if($text)
            {{ $text }}
        @else
            {{ $slot }}
        @endif
    </span>
@endif
