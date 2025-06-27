{{-- resources/views/components/navbar.blade.php --}}
<nav class="navbar">
    <!-- Logo -->
    <div class="navbar-brand">
        @if (Auth::user())
            @if (Auth::user()->hasRole('cliente'))
                <a href="{{ route('cliente.bienvenida') }}" class="brand-link">
                    <img src="{{ asset('img/1.png') }}" alt="Logo" class="navbar-logo">
                </a>
            @endif
        @else
            <a href="{{ route('inicio') }}" class="brand-link">
                <img src="{{ asset('img/1.png') }}" alt="Logo" class="navbar-logo">
            </a>
        @endif
    </div>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggle" onclick="toggleMenu()" aria-label="Abrir menú">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
        </svg>
    </button>

    <!-- Acciones del usuario -->
    <div class="navbar-actions" id="navbarMenu">
        @guest
            <x-boton variante="terciario" tamanio="pequenio" ruta="iniciosesion">Iniciar Sesión</x-boton>
            <x-boton variante="primario" tamanio="pequenio" ruta="registro">Registrarse</x-boton>
        @endguest

        @auth
            @if (Auth::user()->hasRole('cliente'))
                <div class="user-menu">
                    <a href="{{ route('cliente.bienvenida') }}" class="user-link">
                        <span class="user-name {{ request()->routeIs('cliente.bienvenida') ? 'active' : '' }}">Inicio</span>
                    </a>
                    <a href="{{ route('cliente.perfil') }}" class="user-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <span class="user-name {{ request()->routeIs('cliente.perfil') ? 'active' : '' }}">{{ Auth::user()->nombreCompleto }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-button" title="Cerrar Sesión">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1
                                                        0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</nav>
<script>
    function toggleMenu() {
        const menu = document.getElementById('navbarMenu');
        menu.classList.toggle('show');
    }
</script>
