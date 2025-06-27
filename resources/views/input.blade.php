{{-- Ejemplos de uso con las clases personalizadas --}}
<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Componente Input - Con tus clases CSS</h2>

        {{-- Ejemplo 1: Formulario de login (como tu ejemplo) --}}
        <div class="row">
            <div class="col-md-6">
                <h5>Formulario de Login</h5>
                <form>
                    {{-- Email como en tu ejemplo --}}
                    <x-input
                        type="email"
                        name="email"
                        label="Email"
                        placeholder="correo@ejemplo.com"
                        livewire="form.email"
                        errorField="form.email"
                        :loading="false"
                        required
                        autofocus
                        autocomplete="username" />

                    {{-- Password --}}
                    <x-input
                        type="password"
                        name="password"
                        label="Contraseña"
                        placeholder="Tu contraseña"
                        livewire="form.password"
                        errorField="form.password"
                        :loading="false"
                        required
                        autocomplete="current-password" />

                    {{-- Remember me checkbox --}}
                    <x-input
                        type="checkbox"
                        name="remember"
                        label="Recordar sesión"
                        livewire="form.remember"
                        errorField="form.remember"
                        :loading="false" />

                    <button type="submit" class="btn btn-primary">
                        Iniciar Sesión
                    </button>
                </form>
            </div>

            <div class="col-md-6">
                <h5>Formulario de Registro</h5>
                <form>
                    {{-- Nombre --}}
                    <x-input
                        name="name"
                        label="Nombre completo"
                        placeholder="Tu nombre"
                        livewire="form.name"
                        errorField="form.name"
                        :loading="false"
                        required
                        autocomplete="name" />

                    {{-- Email --}}
                    <x-input
                        type="email"
                        name="email"
                        label="Correo electrónico"
                        placeholder="tu@email.com"
                        livewire="form.email"
                        errorField="form.email"
                        :loading="false"
                        required
                        autocomplete="email" />

                    {{-- Teléfono --}}
                    <x-input
                        type="tel"
                        name="phone"
                        label="Teléfono"
                        placeholder="+1234567890"
                        livewire="form.phone"
                        errorField="form.phone"
                        :loading="false"
                        autocomplete="tel" />

                    {{-- Fecha de nacimiento --}}
                    <x-input
                        type="date"
                        name="birth_date"
                        label="Fecha de nacimiento"
                        livewire="form.birth_date"
                        errorField="form.birth_date"
                        :loading="false" />
                </form>
            </div>
        </div>

        <hr class="my-5">

        {{-- Ejemplo 2: Con Livewire completo --}}
        <div class="row">
            <div class="col-12">
                <h5>Con integración Livewire</h5>
                <div x-data="{ loading: false }">

                    {{-- Campos con diferentes modificadores de Livewire --}}
                    <div class="row">
                        <div class="col-md-4">
                            <x-input
                                name="title"
                                label="Título (Live)"
                                placeholder="Escribe aquí..."
                                livewire="post.title"
                                livewireModifier="live"
                                errorField="post.title"
                                ::loading="loading"
                                help="Se actualiza en tiempo real" />
                        </div>

                        <div class="col-md-4">
                            <x-input
                                name="slug"
                                label="Slug (Debounce 500ms)"
                                placeholder="url-amigable"
                                livewire="post.slug"
                                livewireModifier="live.debounce.500ms"
                                errorField="post.slug"
                                ::loading="loading"
                                help="Se actualiza después de 500ms" />
                        </div>

                        <div class="col-md-4">
                            <x-input
                                name="tags"
                                label="Tags (Lazy)"
                                placeholder="tag1, tag2, tag3"
                                livewire="post.tags"
                                livewireModifier="lazy"
                                errorField="post.tags"
                                ::loading="loading"
                                help="Se actualiza al salir del campo" />
                        </div>
                    </div>

                    {{-- Textarea --}}
                    <x-input
                        type="textarea"
                        name="content"
                        label="Contenido del post"
                        placeholder="Escribe el contenido..."
                        livewire="post.content"
                        errorField="post.content"
                        rows="5"
                        ::loading="loading"
                        help="Máximo 1000 caracteres" />

                    {{-- Select --}}
                    <div class="row">
                        <div class="col-md-6">
                            <x-input
                                type="select"
                                name="category"
                                label="Categoría"
                                livewire="post.category_id"
                                errorField="post.category_id"
                                :loading="false"
                                required
                                :options="[
                                    '' => 'Selecciona una categoría',
                                    '1' => 'Tecnología',
                                    '2' => 'Diseño',
                                    '3' => 'Marketing',
                                    '4' => 'Negocios'
                                ]" />
                        </div>
                    </div>

                    {{-- Radio buttons --}}
                    <x-input
                        type="radio"
                        name="status"
                        label="Estado del post"
                        livewire="post.status"
                        errorField="post.status"
                        :loading="false"
                        required
                        :options="[
                            'draft' => 'Borrador',
                            'published' => 'Publicado',
                            'scheduled' => 'Programado'
                        ]" />

                    {{-- Checkboxes independientes --}}
                    <div class="row">
                        <div class="col-md-4">
                            <x-input
                                type="checkbox"
                                name="featured"
                                label="Post destacado"
                                livewire="post.featured"
                                errorField="post.featured"
                                :loading="false" />
                        </div>

                        <div class="col-md-4">
                            <x-input
                                type="checkbox"
                                name="comments_enabled"
                                label="Permitir comentarios"
                                livewire="post.comments_enabled"
                                errorField="post.comments_enabled"
                                :loading="false"
                                help="Los usuarios podrán comentar" />
                        </div>

                        <div class="col-md-4">
                            <x-input
                                type="checkbox"
                                name="newsletter"
                                label="Incluir en newsletter"
                                livewire="post.newsletter"
                                errorField="post.newsletter"
                                :loading="false" />
                        </div>
                    </div>

                    {{-- Simulación de loading --}}
                    <div class="mt-4">
                        <button @click="loading = !loading" class="btn btn-info me-2">
                            <span x-text="loading ? 'Deshabilitar Loading' : 'Simular Loading'"></span>
                        </button>

                        <span x-show="loading" class="text-info">
                            <i class="fas fa-spinner fa-spin me-1"></i>
                            Todos los campos están deshabilitados
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        {{-- Ejemplo 3: Inputs especiales --}}
        <div class="row">
            <div class="col-12">
                <h5>Tipos especiales de input</h5>

                <div class="row">
                    <div class="col-md-6">
                        {{-- Number --}}
                        <x-input
                            type="number"
                            name="age"
                            label="Edad"
                            placeholder="25"
                            livewire="user.age"
                            errorField="user.age"
                            min="18"
                            max="100"
                            :loading="false"
                            help="Debe ser mayor de 18 años" />
                    </div>

                    <div class="col-md-6">
                        {{-- File --}}
                        <x-input
                            type="file"
                            name="avatar"
                            label="Foto de perfil"
                            livewire="user.avatar"
                            errorField="user.avatar"
                            :loading="false"
                            help="Formatos: JPG, PNG. Máximo 2MB" />

                        {{-- Time --}}
                        <x-input
                            type="time"
                            name="meeting_time"
                            label="Hora de reunión"
                            livewire="meeting.time"
                            errorField="meeting.time"
                            :loading="false" />
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        {{-- Ejemplo 4: Estados especiales --}}
        <div class="row">
            <div class="col-12">
                <h5>Estados especiales</h5>

                <div class="row">
                    <div class="col-md-4">
                        <h6>Campo normal</h6>
                        <x-input
                            name="normal_field"
                            label="Campo normal"
                            placeholder="Puedes escribir aquí"
                            :loading="false" />
                    </div>

                    <div class="col-md-4">
                        <h6>Campo deshabilitado</h6>
                        <x-input
                            name="disabled_field"
                            label="Campo deshabilitado"
                            placeholder="No puedes escribir"
                            disabled
                            :loading="false" />
                    </div>

                    <div class="col-md-4">
                        <h6>Campo en loading</h6>
                        <x-input
                            name="loading_field"
                            label="Campo con loading"
                            placeholder="Simulando carga..."
                            :loading="true" />
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6>Campo de solo lectura</h6>
                        <x-input
                            name="readonly_field"
                            label="Solo lectura"
                            value="Este valor no se puede editar"
                            readonly
                            :loading="false" />
                    </div>

                    <div class="col-md-6">
                        <h6>Campo con valor por defecto</h6>
                        <x-input
                            name="default_field"
                            label="Con valor inicial"
                            value="Valor por defecto"
                            :loading="false"
                            help="Este campo tiene un valor inicial" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
