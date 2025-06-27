{{-- Ejemplos para tu sistema de natación con x-boton --}}
<x-app-layout>
    <div class="container py-4">

        <h2 class="mb-4">Sistema de Natación - Ejemplos de Componentes</h2>

        {{-- 2. TARJETAS DE CLASES --}}
        <section class="mb-5">
            <h3>CU-11: Listado de Clases (Vista de tarjetas)</h3>

            <div class="row">
                {{-- Clase programada --}}
                <div class="col-md-4 mb-3">
                    <x-tarjeta title="Natación Infantil" subtitle="Lunes, Miércoles, Viernes">
                        <x-slot name="notificacion">
                            <x-notificacion type="programado" size="sm">Programada</x-notificacion>
                        </x-slot>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><strong>Horario:</strong> 16:00 - 17:00</span>
                            <x-notificacion type="principiante" size="sm">Principiante</x-notificacion>
                        </div>

                        <div class="mb-2">
                            <strong>Instructor:</strong> Ana Martínez
                        </div>

                        <div class="mb-3">
                            <strong>Inscritos:</strong> 8/12
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: 67%"></div>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <div class="d-flex gap-2">
                                <x-boton variante="terciario" tamanio="pequenio">
                                    <i class="fas fa-users me-1"></i> Ver Inscritos
                                </x-boton>
                                <x-boton variante="secundario" tamanio="pequenio">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </x-boton>
                            </div>
                        </x-slot>
                    </x-tarjeta>
                </div>

                {{-- Clase en curso --}}
                <div class="col-md-4 mb-3">
                    <x-tarjeta title="Natación Adultos" subtitle="Martes, Jueves">
                        <x-slot name="notificacion">
                            <x-notificacion type="en-curso" size="sm" pulse>En Curso</x-notificacion>
                        </x-slot>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><strong>Horario:</strong> 19:00 - 20:00</span>
                            <x-notificacion type="intermedio" size="sm">Intermedio</x-notificacion>
                        </div>

                        <div class="mb-2">
                            <strong>Instructor:</strong> Roberto Silva
                        </div>

                        <div class="mb-3">
                            <strong>Inscritos:</strong> 12/12
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                            <small class="text-success">Clase llena</small>
                        </div>

                        <x-slot name="footer">
                            <div class="d-flex gap-2">
                                <x-boton variante="primario" tamanio="pequenio">
                                    <i class="fas fa-play me-1"></i> En vivo
                                </x-boton>
                                <x-boton variante="terciario" tamanio="pequenio">
                                    <i class="fas fa-users me-1"></i> Asistencia
                                </x-boton>
                            </div>
                        </x-slot>
                    </x-tarjeta>
                </div>

                {{-- Clase cancelada --}}
                <div class="col-md-4 mb-3">
                    <x-tarjeta title="Aqua Aeróbicos" subtitle="Sábados">
                        <x-slot name="notificacion">
                            <x-notificacion type="cancelado" size="sm">Cancelada</x-notificacion>
                        </x-slot>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><strong>Horario:</strong> 10:00 - 11:00</span>
                            <x-notificacion type="principiante" size="sm">Principiante</x-notificacion>
                        </div>

                        <div class="mb-2">
                            <strong>Instructor:</strong> -
                        </div>

                        <div class="mb-3">
                            <strong>Motivo:</strong> <span class="text-muted">Instructor enfermo</span>
                        </div>

                        {{-- <x-slot name="footer">
                            <div class="d-flex gap-2">
                                <x-boton variante="secundario" tamanio="pequenio">
                                    <i class="fas fa-calendar me-1"></i> Reprogramar
                                </x-boton>
                                <x-boton variante="acento" tamanio="pequenio">
                                    <i class="fas fa-trash me-1"></i> Eliminar
                                </x-boton>
                            </div>
                        </x-slot> --}}
                    </x-tarjeta>
                </div>
            </div>
        </section>

        {{-- 3. EJEMPLOS DE notificacionS --}}
        <section class="mb-5">
            <h3>Ejemplos de notificacions en el Sistema</h3>

            <div class="row">
                <div class="col-md-6">
                    <h5>Estados de Clientes</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-notificacion type="activo">Activo</x-notificacion>
                        <x-notificacion type="inactivo">Inactivo</x-notificacion>
                        <x-notificacion type="moroso">Moroso</x-notificacion>
                        <x-notificacion type="suspendido">Suspendido</x-notificacion>
                    </div>

                    <h5>Niveles de Natación</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-notificacion type="principiante" variant="soft">Principiante</x-notificacion>
                        <x-notificacion type="intermedio" variant="soft">Intermedio</x-notificacion>
                        <x-notificacion type="avanzado" variant="soft">Avanzado</x-notificacion>
                        <x-notificacion type="competencia" variant="soft">Competencia</x-notificacion>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5>Estados de Clases</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-notificacion type="programado" variant="outline">Programada</x-notificacion>
                        <x-notificacion type="en-curso" variant="outline" pulse>En Curso</x-notificacion>
                        <x-notificacion type="finalizado" variant="outline">Finalizada</x-notificacion>
                        <x-notificacion type="cancelado" variant="outline">Cancelada</x-notificacion>
                    </div>

                    <h5>Indicadores de Estado</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-notificacion type="success" dot /> Cliente al día
                        <x-notificacion type="warning" dot /> Pago pendiente
                        <x-notificacion type="danger" dot /> Cuenta suspendida
                        <x-notificacion type="info" dot /> Clase disponible
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. BOTONES DE PRUEBA PARA TOASTS --}}
        <section class="mb-5">
            <h3>Ejemplos de Notificaciones (Toast)</h3>

            <div class="d-flex flex-wrap gap-2">
                <x-boton variante="primario" @click="showToast({
                             type: 'success',
                             title: 'Cliente registrado',
                             message: 'Juan Pérez ha sido registrado exitosamente en el sistema.',
                             duration: 3000
                         })">
                    Cliente Registrado
                </x-boton>

                <x-boton variante="acento" @click="showToast({
                             type: 'error',
                             title: 'Error de pago',
                             message: 'No se pudo procesar el pago de la mensualidad.',
                             duration: 5000
                         })">
                    Error de Pago
                </x-boton>

                <x-boton variante="secundario" @click="showToast({
                             type: 'warning',
                             title: 'Clase llena',
                             message: 'La clase está completa. El cliente fue agregado a la lista de espera.',
                             duration: 4000
                         })">
                    Clase Llena
                </x-boton>

                <x-boton variante="terciario" @click="showToast({
                             type: 'info',
                             title: 'Recordatorio',
                             message: 'La clase de natación infantil comienza en 15 minutos.',
                             duration: 6000
                         })">
                    Recordatorio
                </x-boton>

                <x-boton variante="secundario" @click="showToast({
                             type: 'info',
                             title: 'Notificación persistente',
                             message: 'Esta notificación no se cierra automáticamente.',
                             persistent: true
                         })">
                    Persistente
                </x-boton>
            </div>
        </section>

        {{-- 5. CARD DE PERFIL DE CLIENTE --}}
        <section class="mb-5">
            <h3>CU-4/CU-6: Perfil de Cliente</h3>

            <div class="row">
                <div class="col-md-8">
                    <x-tarjeta title="Juan Pérez" subtitle="Cliente desde Enero 2024">
                        <x-slot name="actions">
                            <x-boton variante="terciario" tamanio="pequenio">
                                <i class="fas fa-edit"></i>
                            </x-boton>
                            <x-boton variante="acento" tamanio="pequenio">
                                <i class="fas fa-trash"></i>
                            </x-boton>
                        </x-slot>

                        <div class="row">
                            <div class="col-sm-6">
                                <p><strong>Email:</strong> juan@email.com</p>
                                <p><strong>Teléfono:</strong> +1234567890</p>
                                <p><strong>Nivel:</strong> <x-notificacion type="intermedio"
                                        size="sm">Intermedio</x-notificacion></p>
                            </div>
                            <div class="col-sm-6">
                                <p><strong>Estado:</strong> <x-notificacion type="activo"
                                        size="sm">Activo</x-notificacion></p>
                                <p><strong>Mensualidad:</strong> $150.00</p>
                                <p><strong>Último pago:</strong> 15/06/2024</p>
                            </div>
                        </div>

                        <x-slot name="footer">
                            <div class="d-flex justify-content-between">
                                <x-boton variante="terciario" tamanio="pequenio">
                                    <i class="fas fa-history me-1"></i> Historial
                                </x-boton>
                                <x-boton variante="primario" tamanio="pequenio">
                                    <i class="fas fa-plus me-1"></i> Inscribir a Clase
                                </x-boton>
                            </div>
                        </x-slot>
                    </x-tarjeta>
                </div>

                <div class="col-md-4">
                    <x-tarjeta title="Clases Activas">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between align-items-center mb-2">
                                <span>Natación Intermedio</span>
                                <x-notificacion type="en-curso" size="sm">Activa</x-notificacion>
                            </li>
                            <li class="d-flex justify-content-between align-items-center mb-2">
                                <span>Aqua Aeróbicos</span>
                                <x-notificacion type="programado" size="sm">Programada</x-notificacion>
                            </li>
                        </ul>

                        <x-slot name="footer">
                            <x-boton variante="terciario" tamanio="pequenio" anchoCompleto="true">
                                Ver todas las clases
                            </x-boton>
                        </x-slot>
                    </x-tarjeta>
                </div>
            </div>
        </section>

        {{-- 6. EJEMPLOS DE ESTADOS DE BOTONES --}}
        <section class="mb-5">
            <h3>Estados de Botones con tu Componente</h3>

            <div class="row">
                <div class="col-md-6">
                    <h5>Variantes y Tamaños</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-boton variante="primario" tamanio="pequenio">Pequeño Primario</x-boton>
                        <x-boton variante="secundario" tamanio="mediano">Mediano Secundario</x-boton>
                        <x-boton variante="terciario" tamanio="grande">Grande Terciario</x-boton>
                        <x-boton variante="acento" tamanio="mediano">Mediano Acento</x-boton>
                    </div>

                    <h5>Estados Especiales</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-boton variante="primario" :deshabilitado="true">
                            Botón Deshabilitado
                        </x-boton>

                        <x-boton variante="secundario" :cargando="true" textoCargando="Guardando...">
                            Botón Cargando
                        </x-boton>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5>Botones con Enlaces</h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <x-boton variante="primario" ruta="bienvenida">
                            <i class="fas fa-users me-1"></i> Ir a Clientes
                        </x-boton>

                        <x-boton variante="terciario" ruta="bienvenida">
                            <i class="fas fa-swimming-pool me-1"></i> Ir a Clases
                        </x-boton>
                    </div>

                    <h5>Botón Ancho Completo</h5>
                    <x-boton variante="primario" :anchoCompleto="true">
                        <i class="fas fa-save me-2"></i>
                        Guardar Cliente
                    </x-boton>
                </div>
            </div>
        </section>

        {{-- 7. FORMULARIO CON TODOS LOS COMPONENTES --}}
        <section class="mb-5">
            <h3>CU-4: Formulario de Alta de Cliente</h3>

            <x-tarjeta title="Nuevo Cliente" subtitle="Registro en el sistema">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <x-input name="nombre" label="Nombre completo" placeholder="Ingrese el nombre del cliente"
                                required />
                        </div>
                        <div class="col-md-6">
                            <x-input type="email" name="email" label="Correo electrónico"
                                placeholder="cliente@email.com" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <x-input type="tel" name="telefono" label="Teléfono" placeholder="+1234567890" />
                        </div>
                        <div class="col-md-6">
                            <x-input type="select" name="nivel" label="Nivel de natación" :options="[
        '' => 'Selecciona el nivel',
        'principiante' => 'Principiante',
        'intermedio' => 'Intermedio',
        'avanzado' => 'Avanzado',
        'competencia' => 'Competencia'
    ]" required />
                        </div>
                    </div>

                    <x-input type="textarea" name="observaciones" label="Observaciones"
                        placeholder="Notas adicionales sobre el cliente..." rows="3" />
                </form>

                <x-slot name="footer">
                    <div class="d-flex justify-content-end gap-2">
                        <x-boton variante="secundario">
                            <i class="fas fa-times me-1"></i>
                            Cancelar
                        </x-boton>

                        <x-boton variante="primario" tipo="submit">
                            <i class="fas fa-save me-1"></i>
                            Guardar Cliente
                        </x-boton>
                    </div>
                </x-slot>
            </x-tarjeta>
        </section>

    </div>

</x-app-layout>
