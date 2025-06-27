
<div style="padding-top: 15px; padding-left: 15px; padding-right: 15px;">
    <livewire:notificacion />
    <x-tabla-simple 
    :headers="[
        'nombre' => 'Cliente',
        'email' => 'Correo',
        'estado' => 'Estado'
    ]"
    :data="$clientes"
    :mostrarAcciones="true"
/>

</div>
