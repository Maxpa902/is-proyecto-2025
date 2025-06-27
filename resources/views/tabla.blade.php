{{-- Ejemplo de uso de la tabla con acciones como props --}}
<x-app-layout>
    <div class="container py-4">

        {{-- 1. TABLA BÁSICA SIN ACCIONES --}}
        <div class="mb-5">
            <h3 class="mb-3">1. Tabla Básica (Sin acciones)</h3>

            <x-tabla :headers="[
                'nombre' => 'Nombre',
                'email' => 'Email',
                'telefono' => 'Teléfono',
            ]" :data="[
                ['id' => 1, 'nombre' => 'Juan Pérez', 'email' => 'juan@email.com', 'telefono' => '123-456-7890'],
                ['id' => 2, 'nombre' => 'María García', 'email' => 'maria@email.com', 'telefono' => '098-765-4321'],
                ['id' => 3, 'nombre' => 'Carlos López', 'email' => 'carlos@email.com', 'telefono' => '555-123-4567'],
            ]" />
        </div>

        {{-- 2. TABLA CON ACCIONES SIMPLES --}}
        <div class="mb-5">
            <h3 class="mb-3">2. Con Acciones Básicas</h3>

            <x-tabla titulo="Clientes con Acciones" :headers="[
                'nombre' => 'Nombre',
                'email' => 'Email',
                'estado' => 'Estado',
            ]" :data="[
                ['id' => 1, 'nombre' => 'Juan Pérez', 'email' => 'juan@email.com', 'estado' => 'Activo'],
                ['id' => 2, 'nombre' => 'María García', 'email' => 'maria@email.com', 'estado' => 'Moroso'],
                ['id' => 3, 'nombre' => 'Carlos López', 'email' => 'carlos@email.com', 'estado' => 'Suspendido'],
                ]" {{-- 🆕 ACCIONES COMO PROPS --}}
                :accionesFila="[
                    ['icono' => 'fas fa-eye', 'variante' => 'terciario', 'ruta' => 'recepcionista.bienvenida'],
                    ['icono' => 'fas fa-edit', 'variante' => 'primario', 'modal' => 'edit-cliente'],
                    ]" />
                </div>
                {{-- ['icono' => 'fas fa-eye', 'variante' => 'terciario', 'ruta' => 'clientes.show.{id}'], --}}

        {{-- 3. TABLA COMPLETA PARA NATACIÓN --}}
        <div class="mb-5">
            <h3 class="mb-3">3. Tabla Completa para Natación</h3>

            <x-tabla titulo="Gestión de Clientes" :busqueda="true" :headers="[
                'avatar' => 'Avatar',
                'nombre' => 'Nombre',
                'email' => 'Email',
                'estado' => 'Estado',
                'nivel' => 'Nivel',
            ]" :data="[
                [
                    'id' => 1,
                    'avatar' => 'https://via.placeholder.com/40',
                    'nombre' => 'Juan Pérez',
                    'email' => 'juan@email.com',
                    'estado' => 'Activo',
                    'nivel' => 'Intermedio',
                ],
                [
                    'id' => 2,
                    'avatar' => null,
                    'nombre' => 'María García',
                    'email' => 'maria@email.com',
                    'estado' => 'Moroso',
                    'nivel' => 'Principiante',
                ],
                [
                    'id' => 3,
                    'avatar' => 'https://via.placeholder.com/40',
                    'nombre' => 'Carlos López',
                    'email' => 'carlos@email.com',
                    'estado' => 'Suspendido',
                    'nivel' => 'Avanzado',
                ],
                [
                    'id' => 4,
                    'avatar' => null,
                    'nombre' => 'Ana Martínez',
                    'email' => 'ana@email.com',
                    'estado' => 'Activo',
                    'nivel' => 'Competencia',
                ],
            ]"
                {{-- 🆕 ACCIONES DEL HEADER --}} :acciones="[
                    [
                        'texto' => 'Nuevo Cliente',
                        'icono' => 'fas fa-plus',
                        'variante' => 'primario',
                        'modal' => 'create-cliente',
                    ],
                    [
                        'texto' => 'Exportar',
                        'icono' => 'fas fa-download',
                        'variante' => 'secundario',
                        'ruta' => 'recepcionista.bienvenida',
                    ],
                ]" {{-- 🆕 ACCIONES DE CADA FILA --}} :accionesFila="[
                    ['icono' => 'fas fa-eye', 'variante' => 'terciario', 'ruta' => 'recepcionista.bienvenida'],
                    ['icono' => 'fas fa-edit', 'variante' => 'primario', 'modal' => 'edit-cliente'],
                    [
                        'icono' => 'fas fa-trash',
                        'variante' => 'acento',
                        'confirmar' => '¿Eliminar cliente?',
                        'accion' => 'eliminarCliente({id})',
                    ],
                ]" />
        </div>

        {{-- 4. TABLA DE CLASES --}}
        <div class="mb-5">
            <h3 class="mb-3">4. Tabla de Clases</h3>

            <x-tabla titulo="Clases de Natación" :busqueda="true" :headers="[
                'nombre' => 'Clase',
                'instructor' => 'Instructor',
                'horario' => 'Horario',
                'estado' => 'Estado',
                'inscritos' => 'Inscritos',
            ]" :data="[
                [
                    'id' => 1,
                    'nombre' => 'Natación Infantil',
                    'instructor' => 'Ana Martínez',
                    'horario' => 'L-M-V 16:00-17:00',
                    'estado' => 'Activo',
                    'inscritos' => '8/12',
                ],
                [
                    'id' => 2,
                    'nombre' => 'Natación Adultos',
                    'instructor' => 'Roberto Silva',
                    'horario' => 'M-J 19:00-20:00',
                    'estado' => 'Activo',
                    'inscritos' => '12/12',
                ],
                [
                    'id' => 3,
                    'nombre' => 'Aqua Aeróbicos',
                    'instructor' => 'Carmen López',
                    'horario' => 'S 10:00-11:00',
                    'estado' => 'Suspendido',
                    'inscritos' => '0/15',
                ],
            ]"
                :acciones="[
                    [
                        'texto' => 'Nueva Clase',
                        'icono' => 'fas fa-plus',
                        'variante' => 'primario',
                        'modal' => 'create-clase',
                    ],
                ]" {{-- 🆕 ACCIONES ESPECÍFICAS PARA CLASES --}} :accionesFila="[
                    ['icono' => 'fas fa-users', 'variante' => 'terciario', 'modal' => 'ver-inscritos'],
                    ['icono' => 'fas fa-edit', 'variante' => 'primario', 'modal' => 'edit-clase'],
                    ['icono' => 'fas fa-calendar', 'variante' => 'secundario', 'modal' => 'horarios-clase'],
                    [
                        'icono' => 'fas fa-trash',
                        'variante' => 'acento',
                        'confirmar' => '¿Eliminar clase?',
                        'accion' => 'eliminarClase({id})',
                    ],
                ]" />
        </div>

        {{-- 5. TABLA CON DIFERENTES TIPOS DE ACCIONES --}}
        <div class="mb-5">
            <h3 class="mb-3">5. Todos los Tipos de Acciones</h3>

            <x-tabla titulo="Ejemplo de Acciones" :headers="[
                'nombre' => 'Producto',
                'precio' => 'Precio',
                'stock' => 'Stock',
            ]" :data="[
                ['id' => 1, 'nombre' => 'Producto A', 'precio' => '$100', 'stock' => '15'],
                ['id' => 2, 'nombre' => 'Producto B', 'precio' => '$200', 'stock' => '8'],
                ['id' => 3, 'nombre' => 'Producto C', 'precio' => '$50', 'stock' => '0'],
            ]" {{-- 🆕 DIFERENTES TIPOS DE ACCIONES --}}
                :accionesFila="[
                    [
                        'icono' => 'fas fa-eye',
                        'variante' => 'terciario',
                        'ruta' => 'recepcionista.bienvenida',
                        'texto' => '',
                    ],
                    [
                        'icono' => 'fas fa-edit',
                        'variante' => 'primario',
                        'modal' => 'edit-producto',
                    ],
                    [
                        'icono' => 'fas fa-copy',
                        'variante' => 'secundario',
                        'modal' => 'duplicate-producto',
                    ],
                    [
                        'icono' => 'fas fa-trash',
                        'variante' => 'acento',
                        'confirmar' => '¿Estás seguro de eliminar este producto?',
                        'accion' => 'eliminarProducto({id})',
                    ],
                ]" />
        </div>

    </div>


    {{-- Funciones de ejemplo --}}
    <script>
        function eliminarCliente(id) {
            console.log('Eliminando cliente ID:', id);
            // Aquí iría tu lógica de eliminación
            alert(`Cliente ${id} eliminado (simulado)`);
        }

        function eliminarClase(id) {
            console.log('Eliminando clase ID:', id);
            alert(`Clase ${id} eliminada (simulada)`);
        }

        function eliminarProducto(id) {
            console.log('Eliminando producto ID:', id);
            alert(`Producto ${id} eliminado (simulado)`);
        }
    </script>
</x-app-layout>
