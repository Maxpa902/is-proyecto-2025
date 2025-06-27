<div class="form-layout">
    <div class="form-container">
        <div class="form-header "
            style="border: 2px solid #00bcd4ff; border-top-left-radius: 10px; border-top-right-radius: 10px; background: #e0f7faff;">
            <h2 class="mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41L18.37 3.29a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                </svg>
                Editar Cliente
            </h2>
            <p class="text-muted">Modificar datos del cliente seleccionado</p>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
        </div>

        <div class="form-body">
            <form wire:submit.prevent="actualizar" novalidate>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-section">
                            <x-input label="Nombre" type="text" :required="true" livewire="form.nombre" />
                            <x-input label="Apellido" type="text" :required="true" livewire="form.apellido" />
                            <x-input label="DNI" type="number" :required="true" livewire="form.dni" />
                            <x-input label="Fecha de nacimiento" type="date" :required="true"
                                livewire="form.nacimiento" />
                            <x-input label="Correo electrónico" type="email" :required="true"
                                livewire="form.email" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-section">
                            <x-input label="Teléfono (opcional)" type="tel" pattern="^[+0-9()\s\-]{7,20}$"
                                help="Puede incluir +, espacios, guiones o paréntesis" livewire="form.telefono" />
                            <x-input label="Sexo (opcional)" type="select" :options="[
                                \App\Models\Usuario::SEXO_FEMENINO => 'Femenino',
                                \App\Models\Usuario::SEXO_MASCULINO => 'Masculino',
                            ]" livewire="form.sexo" />
                            <x-input label="Altura (opcional)" type="number" min="100" max="250"
                                livewire="form.altura" />
                            <x-input label="Peso (opcional)" type="number" min="30" max="200"
                                livewire="form.peso" />
                        </div>
                    </div>
                </div>



                <div class="form-footer">
                    <div class="d-flex justify-content-between">
                        <x-boton variante="terciario" ruta="clientes.mostrar" :deshabilitado="$guardando">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                            </svg>
                            Cancelar
                        </x-boton>

                        <x-boton tipo="submit" variante="primario" tamanio="mediano" :cargando="$cargando ?? false"
                        textoCargando="Guardando..." wire:target="actualizar" wire:loading.attr="disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                            <path
                                d="M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41L18.37 3.29a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg> Actualizar Cliente
                    </x-boton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
