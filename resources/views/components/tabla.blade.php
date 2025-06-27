{{-- resources/views/components/tabla.blade.php --}}
@props([
    'headers' => [],
    'data' => [],
    'titulo' => '',
    'busqueda' => false,
    'acciones' => [], // Acciones del header
    'accionesFila' => [], // 🆕 Acciones para cada fila
    'mensajeVacio' => 'No hay datos para mostrar',
    'esEditar' => false,
])

@php
    // Preparar todas las variables primero
    $mostrarHeader = $titulo || $busqueda || count($acciones) > 0;
    $tieneHeaders = count($headers) > 0;
    $tieneData = count($data) > 0;
    $tieneAccionesFila = count($accionesFila) > 0;

    // Si hay acciones de fila, agregar columna de acciones automáticamente
    if ($tieneAccionesFila && !isset($headers['acciones'])) {
        $headers['acciones'] = 'Acciones';
    }

    $totalColumnas = count($headers);

    // Procesar acciones del header
    $accionesHeader = [];
    foreach ($acciones as $accion) {
        $accionData = [
            'texto' => $accion['texto'] ?? '',
            'icono' => $accion['icono'] ?? '',
            'variante' => $accion['variante'] ?? 'primario',
            'tamanio' => $accion['tamanio'] ?? 'mediano',
            'tipo' => 'button',
        ];

        if (isset($accion['modal'])) {
            $accionData['modal'] = $accion['modal'];
        } elseif (isset($accion['ruta'])) {
            $accionData['ruta'] = $accion['ruta'];
        }

        $accionesHeader[] = $accionData;
    }

    // Procesar acciones de fila
    $accionesFilaProcesadas = [];
    foreach ($accionesFila as $accion) {
        $accionData = [
            'icono' => $accion['icono'] ?? '',
            'texto' => $accion['texto'] ?? '',
            'variante' => $accion['variante'] ?? 'terciario',
            'tamanio' => 'pequenio',
        ];

        if (isset($accion['modal'])) {
            $accionData['tipo'] = 'modal';
            $accionData['modal'] = $accion['modal'];
        } elseif (isset($accion['ruta'])) {
            $accionData['tipo'] = 'ruta';
            $accionData['ruta'] = $accion['ruta'];
        } elseif (isset($accion['confirmar'])) {
            $accionData['tipo'] = 'confirmar';
            $accionData['confirmar'] = $accion['confirmar'];
            $accionData['accion'] = $accion['accion'] ?? '';
        } else {
            $accionData['tipo'] = 'simple';
        }

        $accionesFilaProcesadas[] = $accionData;
    }

    // Procesar filas de datos
    $filasData = [];
    foreach ($data as $fila) {
        $filaProcessed = [];

        foreach ($headers as $campo => $header) {
            if ($campo === 'acciones') {
                // Para la columna de acciones, guardar el ID de la fila
                $filaProcessed[$campo] = [
                    'valor' => 'acciones',
                    'tipo' => 'acciones',
                    'id' => $fila['id'] ?? 0,
                    'data' => $fila,
                ];
            } else {
                $valor = $fila[$campo] ?? '-';
                $filaProcessed[$campo] = [
                    'valor' => $valor,
                    'tipo' => $campo,
                    'data' => $fila,
                ];
            }
        }

        $filasData[] = $filaProcessed;
    }
@endphp

<style>
    /* Estilos para la tabla */
    .tabla-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .tabla-header {
        background: var(--moonstone-2);
        color: white;
        padding: 1.5rem;
    }

    .tabla-titulo {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .tabla-busqueda {
        margin-top: 1rem;
    }

    .tabla-busqueda input {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        width: 100%;
        max-width: 300px;
    }

    .tabla-busqueda input::placeholder {
        color: #64748b;
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

    .tabla-main tbody tr {
        transition: all 0.2s ease;
    }

    .tabla-main tbody tr:hover {
        background: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .tabla-main tbody tr:last-child td {
        border-bottom: none;
    }

    .tabla-vacia {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }

    .tabla-vacia i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
        opacity: 0.5;
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
        color: #374151;
    }

    .tabla-badge.moroso {
        background: #fee2e2;
        color: #991b1b;
    }

    .tabla-badge.suspendido {
        background: #fef3c7;
        color: #92400e;
    }

    .tabla-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .tabla-avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .tabla-main th,
        .tabla-main td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }

        .tabla-header {
            padding: 1rem;
        }

        .tabla-titulo {
            font-size: 1.25rem;
        }
    }
</style>

<div class="tabla-container" x-data="tablaSimple()">
    {{-- Header --}}
    @if ($mostrarHeader)
        <div class="tabla-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    @if ($titulo)
                        <h3 class="tabla-titulo">{{ $titulo }}</h3>
                    @endif

                    @if ($busqueda)
                        <div class="tabla-busqueda">
                            <input type="text" x-model="busquedaTerm" placeholder="Buscar en la tabla..."
                                class="form-control">
                        </div>
                    @endif
                </div>

                @if (count($accionesHeader) > 0)
                    <div class="d-flex gap-2">
                        @foreach ($accionesHeader as $accion)
                            @if (isset($accion['modal']))
                                <x-boton variante="{{ $accion['variante'] }}" tamanio="{{ $accion['tamanio'] }}"
                                    @click="$dispatch('open-modal-{{ $accion['modal'] }}')">
                                    @if ($accion['icono'])
                                        <i class="{{ $accion['icono'] }} me-2"></i>
                                    @endif
                                    {{ $accion['texto'] }}
                                </x-boton>
                            @elseif(isset($accion['ruta']))
                                <x-boton variante="{{ $accion['variante'] }}" tamanio="{{ $accion['tamanio'] }}"
                                    ruta="{{ $accion['ruta'] }}">
                                    @if ($accion['icono'])
                                        <i class="{{ $accion['icono'] }} me-2"></i>
                                    @endif
                                    {{ $accion['texto'] }}
                                </x-boton>
                            @else
                                <x-boton variante="{{ $accion['variante'] }}" tamanio="{{ $accion['tamanio'] }}">
                                    @if ($accion['icono'])
                                        <i class="{{ $accion['icono'] }} me-2"></i>
                                    @endif
                                    {{ $accion['texto'] }}
                                </x-boton>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Tabla --}}
    <div class="tabla-main">
        <table>
            {{-- Headers --}}
            @if ($tieneHeaders)
                <thead>
                    <tr>
                        @foreach ($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            {{-- Body --}}
            <tbody>
                @if ($tieneData)
                    @foreach ($filasData as $fila)
                        <tr x-show="!busquedaTerm || filaCoincide({{ json_encode(array_column($fila, 'valor')) }})">
                            @foreach ($fila as $campo => $celda)
                                <td>
                                    @if ($campo === 'avatar')
                                        @if ($celda['valor'])
                                            <img src="{{ $celda['valor'] }}" class="tabla-avatar" alt="Avatar">
                                        @else
                                            <div class="tabla-avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    @elseif($campo === 'estado')
                                        <span class="tabla-badge {{ strtolower($celda['valor']) }}">
                                            {{ $celda['valor'] }}
                                        </span>
                                    @elseif($campo === 'acciones')
                                        <div class="tabla-acciones">
                                            @foreach ($accionesFilaProcesadas as $accion)
                                                @if ($accion['tipo'] === 'modal')
                                                    <x-boton variante="{{ $accion['variante'] }}"
                                                        tamanio="{{ $accion['tamanio'] }}"
                                                        @click="$dispatch('open-modal-{{ $accion['modal'] }}', { id: {{ $celda['id'] }} })">
                                                        @if ($accion['icono'])
                                                            <i class="{{ $accion['icono'] }}"></i>
                                                        @endif
                                                        {{ $accion['texto'] }}
                                                    </x-boton>
                                                @elseif($accion['tipo'] === 'ruta')
                                                    <x-boton variante="{{ $accion['variante'] }}"
                                                        tamanio="{{ $accion['tamanio'] }}"
                                                        {{-- ruta="{{ str_replace('{id}', $celda['id'], $accion['ruta']) }}"> --}}
                                                        ruta="{{ $accion['ruta'] }}"
                                                        :parametros="['id' => $celda['id']]">
                                                        @if ($accion['icono'])
                                                            <i class="{{ $accion['icono'] }}"></i>
                                                        @endif
                                                        {{ $accion['texto'] }}
                                                    </x-boton>
                                                @elseif($accion['tipo'] === 'confirmar')
                                                    <x-boton variante="{{ $accion['variante'] }}"
                                                        tamanio="{{ $accion['tamanio'] }}"
                                                        @click="if(confirm('{{ $accion['confirmar'] }}')) { {{ str_replace('{id}', $celda['id'], $accion['accion']) }} }">
                                                        @if ($accion['icono'])
                                                            <i class="{{ $accion['icono'] }}"></i>
                                                        @endif
                                                        {{ $accion['texto'] }}
                                                    </x-boton>
                                                @else
                                                    <x-boton variante="{{ $accion['variante'] }}"
                                                        tamanio="{{ $accion['tamanio'] }}">
                                                        @if ($accion['icono'])
                                                            <i class="{{ $accion['icono'] }}"></i>
                                                        @endif
                                                        {{ $accion['texto'] }}
                                                    </x-boton>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        {{ $celda['valor'] }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ $totalColumnas }}" class="tabla-vacia">
                            <i class="fas fa-inbox"></i>
                            <div>{{ $mensajeVacio }}</div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    function tablaSimple() {
        return {
            busquedaTerm: '',

            filaCoincide(valores) {
                if (!this.busquedaTerm) return true;

                const busqueda = this.busquedaTerm.toLowerCase();
                return valores.some(valor =>
                    String(valor).toLowerCase().includes(busqueda)
                );
            }
        }
    }
</script>
