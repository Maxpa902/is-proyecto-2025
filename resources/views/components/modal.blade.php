{{-- resources/views/components/modal.blade.php --}}
@props([
    'name' => 'modal',
    'title' => 'Modal',
    'size' => 'md',
    'type' => 'default',
    'closeOnOutside' => true,
    'showCloseButton' => true
])

@php
// Clases de tamaño
$sizeClasses = [
    'sm' => 'modal-size-sm',
    'md' => 'modal-size-md',
    'lg' => 'modal-size-lg',
    'xl' => 'modal-size-xl'
];

// Clases de tipo
$typeClasses = [
    'default' => '',
    'success' => 'modal-type-success',
    'warning' => 'modal-type-warning',
    'danger' => 'modal-type-danger',
    'info' => 'modal-type-info'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
$typeClass = $typeClasses[$type] ?? '';
$backdropClick = $closeOnOutside ? 'isOpen = false' : '';
@endphp

<div x-data="modal{{ ucfirst($name) }}()">
    <div x-show="isOpen"
         x-cloak
         @open-modal-{{ $name }}.window="isOpen = true"
         @close-modal-{{ $name }}.window="isOpen = false"
         @keydown.escape.window="isOpen = false"
         @if($closeOnOutside)
             @click="{{ $backdropClick }}"
         @endif
         class="modal-backdrop {{ $sizeClass }} {{ $typeClass }}"
         x-transition:enter="modal-enter"
         x-transition:enter-start="modal-enter-start"
         x-transition:enter-end="modal-enter-end"
         x-transition:leave="modal-leave"
         x-transition:leave-start="modal-leave-start"
         x-transition:leave-end="modal-leave-end">

        <div @click.stop
             class="modal-content"
             x-transition:enter="modal-content-enter"
             x-transition:enter-start="modal-content-enter-start"
             x-transition:enter-end="modal-content-enter-end"
             x-transition:leave="modal-content-leave"
             x-transition:leave-start="modal-content-leave-start"
             x-transition:leave-end="modal-content-leave-end">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom modal-header">
                <h5 class="modal-title mb-0">{{ $title }}</h5>

                @if($showCloseButton)
                <button @click="isOpen = false"
                        class="modal-close-custom"
                        aria-label="Cerrar modal">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
                @endif
            </div>

            <!-- Body -->
            <div class="p-3">
                {{ $slot }}
            </div>

            <!-- Footer (si se proporciona) -->
            @isset($footer)
            <div class="modal-footer">
                {{ $footer }}
            </div>
            @endisset
        </div>
    </div>
</div>

<script>
function modal{{ ucfirst($name) }}() {
    return {
        isOpen: false,

        init() {
            console.log('Modal {{ $name }} inicializado');

            // Control del body scroll
            this.$watch('isOpen', (value) => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }
    }
}
</script>
