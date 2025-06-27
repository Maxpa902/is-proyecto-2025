{{-- resources/views/components/toast.blade.php --}}
@props([
    'type' => 'info',     // success, error, warning, info
    'title' => null,
    'message' => '',
    'duration' => 3000,   // Duración en milisegundos (3 segundos)
    'dismissible' => true,
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left, top-center, bottom-center
    'icon' => null,
    'persistent' => false, // No se cierra automáticamente
])

@php
$toastId = 'toast_' . uniqid();

$typeClasses = [
    'success' => 'toast-success',
    'error' => 'toast-error',
    'warning' => 'toast-warning',
    'info' => 'toast-info'
];

$typeIcons = [
    'success' => 'fas fa-check-circle',
    'error' => 'fas fa-exclamation-circle',
    'warning' => 'fas fa-exclamation-triangle',
    'info' => 'fas fa-info-circle'
];

$toastClass = $typeClasses[$type] ?? $typeClasses['info'];
$defaultIcon = $typeIcons[$type] ?? $typeIcons['info'];
$toastIcon = $icon ?? $defaultIcon;

$positionClasses = [
    'top-right' => 'toast-top-right',
    'top-left' => 'toast-top-left',
    'bottom-right' => 'toast-bottom-right',
    'bottom-left' => 'toast-bottom-left',
    'top-center' => 'toast-top-center',
    'bottom-center' => 'toast-bottom-center'
];

$positionClass = $positionClasses[$position] ?? $positionClasses['top-right'];
@endphp

<style>
/* Container principal de toasts */
.toast-container {
    position: fixed;
    z-index: 9999;
    pointer-events: none;
    max-width: 400px;
}

/* Posiciones */
.toast-top-right {
    top: 1rem;
    right: 1rem;
}

.toast-top-left {
    top: 1rem;
    left: 1rem;
}

.toast-bottom-right {
    bottom: 1rem;
    right: 1rem;
}

.toast-bottom-left {
    bottom: 1rem;
    left: 1rem;
}

.toast-top-center {
    top: 1rem;
    left: 50%;
    transform: translateX(-50%);
}

.toast-bottom-center {
    bottom: 1rem;
    left: 50%;
    transform: translateX(-50%);
}

/* Toast individual */
.toast-item {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    margin-bottom: 0.75rem;
    padding: 1rem;
    pointer-events: auto;
    position: relative;
    border-left: 4px solid;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateX(100%);
}

.toast-item.show {
    opacity: 1;
    transform: translateX(0);
}

.toast-item.hide {
    opacity: 0;
    transform: translateX(100%);
}

/* Tipos de toast */
.toast-success {
    border-left-color: #10b981;
}

.toast-success .toast-icon {
    color: #10b981;
}

.toast-error {
    border-left-color: #ef4444;
}

.toast-error .toast-icon {
    color: #ef4444;
}

.toast-warning {
    border-left-color: #f59e0b;
}

.toast-warning .toast-icon {
    color: #f59e0b;
}

.toast-info {
    border-left-color: #3b82f6;
}

.toast-info .toast-icon {
    color: #3b82f6;
}

/* Elementos internos */
.toast-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.toast-icon {
    font-size: 1.25rem;
    margin-top: 0.125rem;
    flex-shrink: 0;
}

.toast-body {
    flex-grow: 1;
    min-width: 0;
}

.toast-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1f2937;
    font-size: 0.875rem;
}

.toast-message {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.4;
    margin: 0;
}

.toast-close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    font-size: 1.125rem;
    padding: 0.25rem;
    transition: color 0.2s ease;
    line-height: 1;
}

.toast-close:hover {
    color: #4b5563;
}

/* Barra de progreso */
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 0 0 0.5rem 0.5rem;
    overflow: hidden;
}

.toast-progress-bar {
    height: 100%;
    transition: width linear;
}

.toast-success .toast-progress-bar {
    background: #10b981;
}

.toast-error .toast-progress-bar {
    background: #ef4444;
}

.toast-warning .toast-progress-bar {
    background: #f59e0b;
}

.toast-info .toast-progress-bar {
    background: #3b82f6;
}

/* Animaciones para mobile */
@media (max-width: 576px) {
    .toast-container {
        left: 1rem;
        right: 1rem;
        max-width: none;
        transform: none;
    }

    .toast-item {
        transform: translateY(-100%);
    }

    .toast-item.show {
        transform: translateY(0);
    }

    .toast-item.hide {
        transform: translateY(-100%);
    }
}
</style>

{{-- Container global de toasts --}}
<div id="toast-container"
     class="toast-container {{ $positionClass }}"
     x-data="toastManager()"
     x-init="init()">
</div>

{{-- Template para toasts individuales --}}
<template id="toast-template">
    <div class="toast-item"
         x-data="toastItem()"
         x-show="visible"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform"
         x-transition:enter-end="opacity-100 transform"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform"
         x-transition:leave-end="opacity-0 transform">

        <div class="toast-content">
            <i class="toast-icon" x-bind:class="iconClass"></i>

            <div class="toast-body">
                <div class="toast-title" x-show="title" x-text="title"></div>
                <div class="toast-message" x-text="message"></div>
            </div>
        </div>

        <button class="toast-close"
                x-show="dismissible"
                @click="close()"
                type="button">
            <i class="fas fa-times"></i>
        </button>

        <div class="toast-progress" x-show="!persistent">
            <div class="toast-progress-bar"
                 x-bind:style="`width: ${progress}%; transition-duration: ${duration}ms`"></div>
        </div>
    </div>
</template>

<script>
// Manager global de toasts
function toastManager() {
    return {
        toasts: [],
        container: null,

        init() {
            this.container = this.$el;

            // Escuchar eventos globales para mostrar toasts
            window.addEventListener('show-toast', (event) => {
                this.showToast(event.detail);
            });

            // Helper global para JavaScript
            window.showToast = (options) => {
                this.showToast(options);
            };
        },

        showToast(options) {
            const toast = {
                id: 'toast_' + Date.now() + Math.random(),
                type: options.type || 'info',
                title: options.title || null,
                message: options.message || '',
                duration: options.duration || {{ $duration }},
                dismissible: options.dismissible !== false,
                persistent: options.persistent || false,
                icon: options.icon || null
            };

            this.addToast(toast);
        },

        addToast(toast) {
            // Crear elemento del DOM
            const template = document.getElementById('toast-template');
            const clone = template.content.cloneNode(true);
            const element = clone.querySelector('.toast-item');

            // Configurar datos del toast
            element._toastData = toast;
            element.classList.add(`toast-${toast.type}`);

            // Agregar al container
            this.container.appendChild(element);

            // Trigger Alpine
            Alpine.initTree(element);

            // Mostrar con delay para animación
            setTimeout(() => {
                element.classList.add('show');
            }, 10);

            // Auto-close si no es persistente
            if (!toast.persistent && toast.duration > 0) {
                setTimeout(() => {
                    this.removeToast(element);
                }, toast.duration);
            }
        },

        removeToast(element) {
            element.classList.remove('show');
            element.classList.add('hide');

            setTimeout(() => {
                if (element.parentNode) {
                    element.parentNode.removeChild(element);
                }
            }, 300);
        }
    }
}

// Datos individuales de cada toast
function toastItem() {
    return {
        visible: true,
        progress: 100,

        get title() {
            return this.$el._toastData?.title;
        },

        get message() {
            return this.$el._toastData?.message;
        },

        get duration() {
            return this.$el._toastData?.duration || {{ $duration }};
        },

        get dismissible() {
            return this.$el._toastData?.dismissible !== false;
        },

        get persistent() {
            return this.$el._toastData?.persistent || false;
        },

        get iconClass() {
            const type = this.$el._toastData?.type || 'info';
            const customIcon = this.$el._toastData?.icon;

            if (customIcon) return customIcon;

            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };

            return icons[type] || icons.info;
        },

        init() {
            if (!this.persistent && this.duration > 0) {
                this.startProgress();
            }
        },

        startProgress() {
            this.progress = 100;
            setTimeout(() => {
                this.progress = 0;
            }, 10);
        },

        close() {
            this.visible = false;
            setTimeout(() => {
                if (this.$el.parentNode) {
                    this.$el.parentNode.removeChild(this.$el);
                }
            }, 200);
        }
    }
}

// Helpers para usar desde PHP/Livewire
@if(session()->has('toast'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast(@json(session('toast')));
    });
@endif
</script>
