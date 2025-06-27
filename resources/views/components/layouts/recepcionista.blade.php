{{-- resources/views/components/layouts/recepcionista.blade.php --}}
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
    <meta name="description" content="Sistema de gestión natatorio - Panel de administración">
    <meta name="keywords" content="natatorio, gestión, sistema, administración, dashboard">
    <meta name="author" content="Sistema Natatorio">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Styles adicionales -->
    @stack('styles')
</head>

<body class="recepcionista-body">
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="d-flex flex-column align-items-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2 text-muted">Cargando...</p>
        </div>
    </div>

    <!-- Layout con Sidebar -->
    <div class="admin-layout">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Contenido Principal -->
        <main class="main-content-admin">
            <!-- Header con breadcrumbs -->
            <div class="content-header d-lg-none">
                <!-- Toggle sidebar para mobile -->
                <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                    </svg>
                </button>
            </div>

            <!-- Área de contenido con scroll -->
            <div class="content-scroll-area-admin">
                <div class="content-wrapper-admin">
                    {{ $slot }}

                    <!-- Footer -->
                    <x-footer />
                </div>
            </div>

        </main>
    </div>

    <!-- Overlay para mobile cuando sidebar está abierto -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <livewire:notificacion />
    <x-notificacion />

    <!-- Livewire Scripts -->
    @livewireScripts

    {{-- <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- Sidebar JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-open');
                overlay.classList.toggle('show');
                body.classList.toggle('sidebar-mobile-open');
            }

            function closeSidebar() {
                sidebar.classList.remove('sidebar-open');
                overlay.classList.remove('show');
                body.classList.remove('sidebar-mobile-open');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Cerrar sidebar en resize a desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                }
            });

            // Submenús
            document.querySelectorAll('.sidebar-menu-item.has-submenu > .menu-link').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const menuItem = this.parentElement;
                    const submenu = menuItem.querySelector('.submenu');

                    menuItem.classList.toggle('submenu-open');

                    if (submenu) {
                        if (menuItem.classList.contains('submenu-open')) {
                            submenu.style.maxHeight = submenu.scrollHeight + 'px';
                        } else {
                            submenu.style.maxHeight = '0';
                        }
                    }
                });
            });
        });
    </script>

    <!-- Scripts adicionales de las páginas -->
    @stack('scripts')

</body>

</html>
