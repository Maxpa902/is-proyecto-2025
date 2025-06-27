<!-- Botón primario simple -->
<x-app-layout>
    <!-- Botones con ancho automático -->
    <div class="d-flex gap-2">
        <x-boton variante="primario">Guardar</x-boton>
        <x-boton variante="secundario">Cancelar</x-boton>
    </div>

    <!-- El botón toma el ancho del contenedor -->
    <div class="col-md-6">
        <x-boton variante="primario">
            Botón en Columna
        </x-boton>
    </div>

    <!-- En cards -->
    <div class="card-footer">
        <x-boton variante="terciario" class="me-2">Ver</x-boton>
        <x-boton variante="acento">Eliminar</x-boton>
    </div>

    <!-- Usando clases de Bootstrap para ancho -->
    <x-boton variante="primario" class="w-50">
        Medio Ancho
    </x-boton>

    <x-boton variante="secundario" class="w-25">
        Cuarto de Ancho
    </x-boton>

    <!-- Botón de login que ocupe todo el ancho -->
    <x-boton variante="primario" :anchoCompleto="true" tipo="submit">
        Iniciar Sesión
    </x-boton>


    <!-- Submit normal -->
    <x-boton tipo="submit" variante="primario">
        Iniciar Sesión
    </x-boton>

    <!-- Submit cargando -->
    <x-boton tipo="submit" variante="primario" tamanio="pequenio" :cargando="true">
        Iniciando Sesión
    </x-boton>
    <p>---------------------------------------------------------------------------------------</p>
    <p>---------------------------------------------------------------------------------------</p>
    <p>---------------------------------------------------------------------------------------</p>

    <button onclick="openModal('nombre-modal')">Abrir Modal</button>

    <!-- Implementación del modal -->
    <x-modal name="nombre-modal" title="Título del Modal" size="md" type="default">
        <p>Contenido del modal aquí...</p>

        <x-slot:footer>
            <button @click="closeModal()" class="btn btn-secondary">Cancelar</button>
            <button @click="closeModal()" class="btn btn-primary">Aceptar</button>
        </x-slot:footer>
    </x-modal>


</x-app-layout>
