{{-- resources/views/components/layouts/invitado.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Sistema Natatorio') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Meta tags para SEO -->
    <meta name="description" content="Sistema de gestión natatorio - Administra tu natatorio de forma eficiente">
    <meta name="keywords" content="natatorio, gestión, sistema, administración">
    <meta name="author" content="Sistema Natatorio">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Styles adicionales -->
    @stack('styles')
</head>

<body class="natatory-body">
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="d-flex flex-column align-items-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2 text-muted">Cargando...</p>
        </div>
    </div>

    <x-navbar />

    <!-- Contenido Principal -->
    <main class="main-content">
        <div class="content-scroll-area">
            <div class="content-wrapper">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer Simple -->
        <x-footer />
    </main>

    <x-notificacion />

    <!-- Livewire Scripts -->
    @livewireScripts

    {{-- <!-- Bootstrap JS (si lo necesitas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- Scripts adicionales de las páginas -->
    @stack('scripts')

</body>

</html>
