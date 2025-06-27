@push('styles')
    @vite('resources/css/components/colores.css')
@endpush
<div class="form-layout">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header quinto"
            style="border: 2px solid #00bcd4ff; border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Nuevo Cliente
                    </h2>
                    <p class="text-muted mb-0">Crear un nuevo cliente para el sistema</p>
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="form-body">
            <form wire:submit="crearCliente" novalidate>
                <div class="row">
                    <!-- COLUMNA 1: CAMPOS REQUERIDOS -->
                    <div class="col-lg-6">
                        <div class="form-section">
                            <h5 class="section-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                                    class="me-2">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                Información Necesaria
                            </h5>
                            <x-input label="Nombre" type="text" :required="true" livewire="form.nombre" />
                            <x-input label="Apellido" type="text" :required="true" livewire="form.apellido" />
                            <x-input label="DNI" type="number" :required="true" min="10000000" max="99999999"
                                livewire="form.dni" />
                            <x-input label="Fecha de nacimiento" type="date" :required="true"
                                min="{{ \Carbon\Carbon::now()->subYears(90)->format('Y-m-d') }}"
                                max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                                livewire="form.nacimiento" />
                            <x-input label="Correo electrónico" type="email" :required="true"
                                livewire="form.email" />
                            <x-input label="Contraseña" type="password" :required="true" livewire="form.password" />
                            <x-input label="Confirmar contraseña" type="password" :required="true"
                                livewire="form.password_confirmation" />
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-section">
                            <h5 class="section-title">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2a10 10 0 1 0 10 10A10.01142 10.01142 0 0 0 12 2Zm1 15h-2v-2h2Zm0-4h-2V7h2Z" />
                                </svg>
                                Datos Opcionales
                            </h5>
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
                <!-- Footer con Acción Volver -->
                <div class="form-footer">
                    <div class="d-flex justify-content-between">

                        <x-boton variante="terciario" ruta="recepcionista.bienvenida" tamanio="mediano">
                            <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 24 24">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                            </svg>
                            Volver
                        </x-boton>

                        <x-boton tipo="submit" variante="primario" tamanio="mediano" :cargando="$cargando ?? false"
                            textoCargando="Creando..." wire:target="crearCliente" wire:loading.attr="disabled">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                            </svg> Crear Cliente
                        </x-boton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
