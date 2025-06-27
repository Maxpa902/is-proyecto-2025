<div x-data x-show="$wire.mostrar" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md" @click.away="$wire.cerrar()">
        <h2 class="text-lg font-bold mb-4 text-center {{ $esReactivacion ? 'text-green-600' : 'text-red-600' }}">
            {{ $esReactivacion ? 'Reactivar cliente' : 'Dar de baja cliente' }}
        </h2>

        <p class="mb-4 text-center">
            ¿Estás seguro que querés 
            {{ $esReactivacion ? 'reactivar' : 'dar de baja' }} 
            al cliente <strong>{{ $clienteNombre }}</strong>?
        </p>

        <div class="flex justify-center gap-4">
            <button wire:click="cerrar" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancelar</button>
            <button wire:click="confirmar"
                class="px-4 py-2 rounded {{ $esReactivacion ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white">
                Confirmar
            </button>
        </div>
    </div>
</div>
