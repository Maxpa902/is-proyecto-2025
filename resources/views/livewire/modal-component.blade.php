{{-- resources/views/livewire/modal-component.blade.php --}}
<div>
    <!-- Botón para abrir modal -->
    <button wire:click="openModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Abrir Modal
    </button>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">

            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>

                <!-- Header del modal -->
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Contenido del modal -->
                <div class="py-4">
                    <p class="text-gray-700">{{ $content }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        Usuario: {{ Auth::user()->name ?? 'No autenticado' }}
                    </p>
                </div>

                <!-- Footer del modal -->
                <div class="flex justify-end pt-4 space-x-2">
                    <button wire:click="closeModal"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button wire:click="confirm"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Mensaje de confirmación -->
    @if (session()->has('message'))
        <div class="mt-3 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
