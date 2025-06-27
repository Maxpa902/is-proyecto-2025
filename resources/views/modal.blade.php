{{-- Ejemplo de uso del componente modal con CSS externo --}}
<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Modal Component - Con CSS Externo</h2>

        <!-- Botones para abrir modales -->
        <div class="row">
            <div class="col-12 mb-4">
                <h5>Diferentes Tamaños:</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <button x-data @click="$dispatch('open-modal-pequeno')" class="btn btn-outline-primary btn-sm">
                        Modal Pequeño (SM)
                    </button>
                    <button x-data @click="$dispatch('open-modal-mediano')" class="btn btn-outline-primary">
                        Modal Mediano (MD)
                    </button>
                    <button x-data @click="$dispatch('open-modal-grande')" class="btn btn-outline-primary">
                        Modal Grande (LG)
                    </button>
                    <button x-data @click="$dispatch('open-modal-extragrande')" class="btn btn-outline-primary">
                        Modal Extra Grande (XL)
                    </button>
                </div>
            </div>

            <div class="col-12 mb-4">
                <h5>Diferentes Tipos:</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <button x-data @click="$dispatch('open-modal-success')" class="btn btn-success">
                        Éxito
                    </button>
                    <button x-data @click="$dispatch('open-modal-warning')" class="btn btn-warning">
                        Advertencia
                    </button>
                    <button x-data @click="$dispatch('open-modal-danger')" class="btn btn-danger">
                        Peligro
                    </button>
                    <button x-data @click="$dispatch('open-modal-info')" class="btn btn-info">
                        Información
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pequeño -->
    <x-modal name="pequeno" title="Confirmación" size="sm">
        <div class="text-center">
            <p><strong>¿Confirmas esta acción?</strong></p>
            <p class="text-muted small">Esta operación no se puede deshacer.</p>
        </div>

        <x-slot name="footer">
            <div class="d-flex justify-content-end gap-2">
                <button x-data @click="$dispatch('close-modal-pequeno')" class="btn btn-secondary btn-sm">
                    Cancelar
                </button>
                <button x-data @click="$dispatch('close-modal-pequeno')" class="btn btn-primary btn-sm">
                    Confirmar
                </button>
            </div>
        </x-slot>
    </x-modal>

    <!-- Modal Mediano -->
    <x-modal name="mediano" title="Modal Estándar" size="md">
        <p>Este es un modal de tamaño mediano estándar.</p>
        <p>Perfecto para la mayoría de contenidos y formularios simples.</p>

        <div class="mb-3">
            <label class="form-label">Ejemplo de formulario</label>
            <input type="text" class="form-control" placeholder="Escribe algo...">
        </div>
    </x-modal>

    <!-- Modal Grande -->
    <x-modal name="grande" title="Formulario Detallado" size="lg">
        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Apellido</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="tel" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
        </form>

        <x-slot name="footer">
            <div class="d-flex justify-content-between w-100">
                <button x-data @click="$dispatch('close-modal-grande')" class="btn btn-outline-secondary">
                    Cancelar
                </button>
                <button class="btn btn-primary">
                    Guardar Datos
                </button>
            </div>
        </x-slot>
    </x-modal>

    <!-- Modal Extra Grande -->
    <x-modal name="extragrande" title="Dashboard Completo" size="xl">
        <div class="row">
            <div class="col-md-8">
                <h6>Contenido Principal</h6>
                <p>Este modal extra grande es perfecto para dashboards, tablas grandes o contenido complejo.</p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>juan@email.com</td>
                            <td><span class="notificacion bg-success">Activo</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>María García</td>
                            <td>maria@email.com</td>
                            <td><span class="notificacion bg-warning">Pendiente</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h6>Panel Lateral</h6>
                <div class="card">
                    <div class="card-body">
                        <h7 class="card-title">Estadísticas</h7>
                        <p class="card-text">Usuarios activos: 150</p>
                        <p class="card-text">Nuevos registros: 12</p>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>

    <!-- Modales por Tipo -->

    <!-- Success Modal -->
    <x-modal name="success" title="Operación Exitosa" type="success" size="sm">
        <div class="text-center">
            <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
            <p><strong>¡Todo salió perfecto!</strong></p>
            <p class="text-muted">La operación se completó sin errores.</p>
        </div>
    </x-modal>

    <!-- Warning Modal -->
    <x-modal name="warning" title="Advertencia Importante" type="warning">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-triangle text-warning me-3 mt-1" style="font-size: 1.5rem;"></i>
            <div>
                <p><strong>Ten cuidado con esta acción.</strong></p>
                <p>Algunos datos podrían verse afectados. ¿Estás seguro de continuar?</p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="d-flex justify-content-end gap-2">
                <button x-data @click="$dispatch('close-modal-warning')" class="btn btn-secondary">
                    Cancelar
                </button>
                <button class="btn btn-warning">
                    Continuar de todas formas
                </button>
            </div>
        </x-slot>
    </x-modal>

    <!-- Danger Modal -->
    <x-modal name="danger" title="¡Zona de Peligro!" type="danger" :closeOnOutside="false">
        <div class="text-center">
            <i class="fas fa-skull-crossbones text-danger mb-3" style="font-size: 3rem;"></i>
            <p><strong>Esta acción es irreversible</strong></p>
            <p>Se eliminarán todos los datos permanentemente.</p>
            <p class="text-muted small">Escribe "ELIMINAR" para confirmar:</p>
            <input type="text" class="form-control text-center" placeholder="ELIMINAR">
        </div>

        <x-slot name="footer">
            <div class="d-flex justify-content-center w-100">
                <button class="btn btn-danger disabled">
                    Confirmar Eliminación
                </button>
            </div>
        </x-slot>
    </x-modal>

    <!-- Info Modal -->
    <x-modal name="info" title="Información del Sistema" type="info">
        <div class="row">
            <div class="col-2 text-center">
                <i class="fas fa-info-circle text-info" style="font-size: 2rem;"></i>
            </div>
            <div class="col-10">
                <h6>Versión 2.1.0</h6>
                <p>Nueva actualización disponible con las siguientes mejoras:</p>
                <ul>
                    <li>Mejor rendimiento en modales</li>
                    <li>Soporte para temas personalizados</li>
                    <li>Corrección de bugs menores</li>
                </ul>
            </div>
        </div>
    </x-modal>

</x-app-layout>
