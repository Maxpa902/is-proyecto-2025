<style>
    .tabla-header th {
        background: var(--moonstone-2);
        /* Asegurate que esta variable esté definida */
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .tabla-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .tabla-main {
        overflow-x: auto;
    }

    .tabla-main table {
        width: 100%;
        border-collapse: collapse;
    }

    .tabla-main th {
        background: #f8fafc;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .tabla-main td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }

    .tabla-main tbody tr:hover {
        background: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }


    .tabla-vacia {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }

    .tabla-acciones {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .tabla-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .tabla-badge.activo {
        background: #d1fae5;
        color: #065f46;
    }

    .tabla-badge.inactivo {
        background: #f3f4f6;
        color: #343646;
    }

    .tabla-badge.moroso {
        background: #fee2e2;
        color: #991b1b;
    }

    .tabla-badge.suspendido {
        background: #fef3c7;
        color: #92400e;
    }

    table thead tr.tabla-header th {
        background-color: var(--moonstone-2) !important;
        color: white !important;
    }
</style>

<div class="tabla-container mt-4">
    <div class="tabla-main">
        <table>
            <thead>
                <tr class="tabla-header">
                    @foreach ($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                    @if ($mostrarAcciones)
                        <th>Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $fila)
                    <tr>
                        @foreach ($headers as $campo => $celda)
                            <td>
                                @if ($campo === 'estado')
                                    <span class="tabla-badge {{ strtolower($fila[$campo]) }}">
                                        {{ $fila[$campo] }}
                                    </span>
                                @else
                                    {{ $fila[$campo] ?? '-' }}
                                @endif
                            </td>
                        @endforeach

                        @if ($mostrarAcciones)
                            <td>
                                <div class="tabla-acciones">
                                    <x-boton variante="primario" ruta="clientes.ver" :parametros="['id' => $fila['id']]" tamanio="pequenio">
                                        <i class="fas fa-eye me-1"></i> Ver
                                    </x-boton>

                                    @if ($fila['estado'] == 'Activo')
                                        <x-boton variante="terciario" ruta="clientes.editar" :parametros="['id' => $fila['id']]"
                                            tamanio="pequenio">
                                            <i class="fas fa-pen me-1"></i> Editar
                                        </x-boton>
                                        <button wire:click="darBajaCliente({{ $fila['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:target="darBajaCliente({{ $fila['id'] }})"
                                            class="boton-acento boton-pequenio">
                                            <span wire:loading.remove
                                                wire:target="darBajaCliente({{ $fila['id'] }})">Dar de baja</span>
                                            <span wire:loading
                                                wire:target="darBajaCliente({{ $fila['id'] }})">Procesando...</span>
                                        </button>
                                    @else
                                        <button wire:click="reactivarCliente({{ $fila['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:target="reactivarCliente({{ $fila['id'] }})"
                                            class="boton-acento boton-pequenio">
                                            <span wire:loading.remove
                                                wire:target="reactivarCliente({{ $fila['id'] }})"></i>Activar</span>
                                            <span wire:loading
                                                wire:target="reactivarCliente({{ $fila['id'] }})">Procesando...</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) + ($mostrarAcciones ? 1 : 0) }}" class="tabla-vacia">
                            <i class="fas fa-inbox"></i><br>
                            {{ $mensajeVacio }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
