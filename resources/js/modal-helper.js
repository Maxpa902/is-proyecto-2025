/**
 * Clase Modal Helper para simplificar operaciones con modales - CORREGIDA
 */
class ModalHelper {
    /**
     * Abre un modal por su nombre
     * @param {string} modalName - Nombre del modal (sin prefijo)
     */
    static open(modalName) {
        window.dispatchEvent(new CustomEvent(`open-modal-${modalName}`));
    }

    /**
     * Cierra un modal por su nombre
     * @param {string} modalName - Nombre del modal (sin prefijo)
     */
    static close(modalName) {
        window.dispatchEvent(new CustomEvent(`close-modal-${modalName}`));
    }

    /**
     * Alterna un modal (abre si está cerrado, cierra si está abierto)
     * @param {string} modalName - Nombre del modal (sin prefijo)
     */
    static toggle(modalName) {
        window.dispatchEvent(new CustomEvent(`toggle-modal-${modalName}`));
    }

    /**
     * Cierra todos los modales abiertos - CORREGIDO
     */
    static closeAll() {
        // Buscar todos los elementos con isOpen=true en Alpine
        document.querySelectorAll('[x-data]').forEach(el => {
            // Verificar si es un modal
            if (el.classList.contains('modal-overlay')) {
                // Usar Alpine.js para manipular el estado
                if (window.Alpine) {
                    const component = window.Alpine.$data(el);
                    if (component && component.isOpen) {
                        component.isOpen = false;
                    }
                }
            }
        });
    }

    /**
     * Crea un modal de confirmación dinámico - SIMPLIFICADO
     * @param {Object} options - Opciones del modal
     */
    static confirm(options = {}) {
        const defaults = {
            title: 'Confirmar',
            message: '¿Estás seguro?',
            confirmText: 'Confirmar',
            cancelText: 'Cancelar',
            type: 'warning',
            onConfirm: () => { },
            onCancel: () => { }
        };

        const config = { ...defaults, ...options };
        const modalId = 'dynamic-confirm-' + Date.now();

        // Crear modal dinámico más simple
        const modalHTML = `
            <div
                x-data="{
                    isOpen: false,

                    init() {
                        this.isOpen = true;
                        this.$watch('isOpen', value => {
                            if (!value) {
                                setTimeout(() => {
                                    this.$el.remove();
                                }, 300);
                            }
                        });
                    },

                    confirm() {
                        ${config.onConfirm.toString()}
                        this.isOpen = false;
                    },

                    cancel() {
                        ${config.onCancel.toString()}
                        this.isOpen = false;
                    }
                }"
                x-show="isOpen"
                x-cloak
                class="modal-overlay modal-${config.type}"
                x-transition:enter="modal-enter"
                x-transition:enter-start="modal-enter-start"
                x-transition:enter-end="modal-enter-end"
                x-transition:leave="modal-leave"
                x-transition:leave-start="modal-leave-start"
                x-transition:leave-end="modal-leave-end"
                @keydown.escape.window="cancel()"
            >
                <div class="modal-backdrop" @click="cancel()"></div>
                <div class="modal-container">
                    <div class="modal-content modal-sm" @click.stop>
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <span class="modal-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                                    </svg>
                                </span>
                                ${config.title}
                            </h5>
                            <button type="button" class="modal-close-btn" @click="cancel()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${config.message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cancel()">
                                ${config.cancelText}
                            </button>
                            <button type="button" class="btn btn-primary" @click="confirm()">
                                ${config.confirmText}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Insertar en el DOM
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = modalHTML;
        document.body.appendChild(modalContainer);

        // Inicializar Alpine.js en el nuevo elemento
        if (window.Alpine) {
            window.Alpine.initTree(modalContainer);
        }
    }

    /**
     * Crea un modal de alerta dinámico - SIMPLIFICADO
     * @param {Object} options - Opciones del modal
     */
    static alert(options = {}) {
        const defaults = {
            title: 'Información',
            message: 'Mensaje de alerta',
            type: 'info',
            buttonText: 'Aceptar',
            onClose: () => { }
        };

        const config = { ...defaults, ...options };

        // Usar el mismo patrón que confirm pero con un solo botón
        this.confirm({
            title: config.title,
            message: config.message,
            type: config.type,
            confirmText: config.buttonText,
            cancelText: '', // Sin botón cancelar
            onConfirm: config.onClose,
            onCancel: () => { } // No hacer nada
        });
    }

    /**
     * Escucha eventos de modal globalmente
     * @param {string} eventType - Tipo de evento ('opened', 'closed')
     * @param {Function} callback - Función callback
     */
    static on(eventType, callback) {
        window.addEventListener(`modal-${eventType}`, callback);
    }

    /**
     * Remueve un listener de eventos de modal
     * @param {string} eventType - Tipo de evento
     * @param {Function} callback - Función callback
     */
    static off(eventType, callback) {
        window.removeEventListener(`modal-${eventType}`, callback);
    }

    /**
     * Verifica si un modal específico está abierto
     * @param {string} modalName - Nombre del modal
     * @returns {boolean}
     */
    static isOpen(modalName) {
        const modal = document.querySelector(`[x-data][class*="modal-overlay"]`);
        if (modal && window.Alpine) {
            const data = window.Alpine.$data(modal);
            return data && data.isOpen === true;
        }
        return false;
    }

    /**
     * Obtiene todos los modales abiertos
     * @returns {Array<string>} Array con los nombres de los modales abiertos
     */
    static getOpenModals() {
        const openModals = [];
        document.querySelectorAll('[x-data][class*="modal-overlay"]').forEach(modal => {
            if (window.Alpine) {
                const data = window.Alpine.$data(modal);
                if (data && data.isOpen) {
                    // Extraer el nombre del modal del id
                    const id = modal.id || '';
                    if (id.startsWith('modal-')) {
                        openModals.push(id.substring(6));
                    }
                }
            }
        });
        return openModals;
    }
}

// Hacer disponible globalmente
window.Modal = ModalHelper;

// Aliases para facilidad de uso - CORREGIDOS
window.openModal = (name) => ModalHelper.open(name);
window.closeModal = (name) => ModalHelper.close(name);
window.toggleModal = (name) => ModalHelper.toggle(name);

// BONUS: Funciones de conveniencia adicionales
window.confirmModal = (message, onConfirm, title = 'Confirmar') => {
    ModalHelper.confirm({
        title: title,
        message: message,
        onConfirm: onConfirm
    });
};

window.alertModal = (message, title = 'Información', type = 'info') => {
    ModalHelper.alert({
        title: title,
        message: message,
        type: type
    });
};
