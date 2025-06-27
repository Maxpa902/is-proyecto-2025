{{-- resources/views/components/sidebar.blade.php --}}
<aside class="sidebar" id="sidebar">
    {{-- DEJAR POR AHORA, SE SACA CUANDO SE AGA EL CILEENT --}}
    @php
        $user = Auth::user();

        if ($user->hasRole('recepcionista')) {
            $ruta = 'recepcionista.bienvenida';
        }
    @endphp

    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <a href="{{ route($ruta) }}" class="sidebar-brand">
            <!-- Logo directo -->
            <img src="{{ asset('img/1.png') }}" alt="Logo Natatorio" class="navbar-logo">
        </a>
    </div>

    <!-- Menú de Navegación -->
    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="sidebar-menu-item {{ request()->routeIs($ruta) ? 'active' : '' }}">
                <a href="{{ route($ruta) }}" class="menu-link">
                    <div class="menu-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                    </div>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!-- Gestión de Clientes -->
            <li
                class="sidebar-menu-item has-submenu {{ request()->routeIs('clientes.*') ? 'active submenu-open' : '' }}">
                <a href="#" class="menu-link">
                    <div class="menu-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3z" />
                        </svg>
                    </div>
                    <span class="menu-text">Gestión de Clientes</span>
                    <div class="menu-arrow">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                        </svg>
                    </div>
                </a>
                <ul class="submenu"
                    style="{{ request()->routeIs('clientes.*') ? 'max-height: 200px;' : 'max-height: 0;' }}">
                    <li class="submenu-item {{ request()->routeIs('clientes.mostrar') ? 'active' : '' }}">
                        <a href="{{ route('clientes.mostrar') }}" class="submenu-link">
                            <div class="submenu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                </svg>
                            </div>
                            <span class="submenu-text">Ver todos</span>
                        </a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('clientes.crear') ? 'active' : '' }}">
                        <a href="{{ route('clientes.crear') }}" class="submenu-link">
                            <div class="submenu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <span class="submenu-text">Nuevo cliente</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Calendario y Clases -->
            <li
                class="sidebar-menu-item has-submenu {{ request()->routeIs('clases.*') || request()->routeIs('calendario.*') ? 'active submenu-open' : '' }}">
                <a href="#" class="menu-link">
                    <div class="menu-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z" />
                        </svg>
                    </div>
                    <span class="menu-text">Calendario y Clases</span>
                    <div class="menu-arrow">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                        </svg>
                    </div>
                </a>
                <ul class="submenu"
                    style="{{ request()->routeIs('clases.*') || request()->routeIs('calendario.*') ? 'max-height: 200px;' : 'max-height: 0;' }}">
                    {{-- <li class="submenu-item {{ request()->routeIs('calendario.index') ? 'active' : '' }}">
                        <a href="{{ route('calendario.index') }}" class="submenu-link">
                            <div class="submenu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                                </svg>
                            </div>
                            <span class="submenu-text">Ver calendario</span>
                        </a>
                    </li> --}}
                    <li class="submenu-item {{ request()->routeIs('clases.crear') ? 'active' : '' }}">
                    <a href="{{ route('clases.crear') }}" class="submenu-link">
                        <div class="submenu-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                            </svg>
                        </div>
                        <span class="submenu-text">Programar clase</span>
                    </a>
            </li>
            <li class="submenu-item {{ request()->routeIs('clases.mostrar') ? 'active' : '' }}">
                <a href="{{ route('clases.mostrar') }}" class="submenu-link">
                    <div class="submenu-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                        </svg>
                    </div>
                    <span class="submenu-text">Horarios</span>
                </a>
            </li>
        </ul>
        </li>

        <!-- Planes -->
        <li class="sidebar-menu-item has-submenu {{ request()->routeIs('planes.*') ? 'active submenu-open' : '' }}">
            <a href="#" class="menu-link">
                <div class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                </div>
                <span class="menu-text">Planes</span>
                <div class="menu-arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                    </svg>
                </div>
            </a>
            <ul class="submenu"
                style="{{ request()->routeIs('planes.*') ? 'max-height: 200px;' : 'max-height: 0;' }}">
                <li class="submenu-item {{ request()->routeIs('planes.mostrar') ? 'active' : '' }}">
                    <a href="{{ route('planes.mostrar') }}" class="submenu-link">
                        <div class="submenu-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                        </div>
                        <span class="submenu-text">Ver planes</span>
                    </a>
                </li>
                {{-- DESCOMENTAR CUANDO SE PUEDA ASIGNAR PLAN --}}
                {{-- <li class="submenu-item {{ request()->routeIs('planes.assign') ? 'active' : '' }}">
                        <a href="{{ route('planes.assign') }}" class="submenu-link">
                            <div class="submenu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                </svg>
                            </div>
                            <span class="submenu-text">Asignar plan</span>
                        </a>
                    </li> --}}
            </ul>
        </li>

        <!-- Reportes -->
        {{-- <li class="sidebar-menu-item has-submenu {{ request()->routeIs('reportes.*') ? 'active submenu-open' : '' }}">
            <a href="#" class="menu-link">
                <div class="menu-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                    </svg>
                </div>
                <span class="menu-text">Reportes</span>
                <div class="menu-arrow">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                    </svg>
                </div>
            </a>
            <ul class="submenu"
                style="{{ request()->routeIs('reportes.*') ? 'max-height: 250px;' : 'max-height: 0;' }}">
                <li class="submenu-item {{ request()->routeIs('reportes.asistencia') ? 'active' : '' }}">
                    <a href="{{ route('reportes.asistencia') }}" class="submenu-link">
                    <a class="submenu-link">
                        <div class="submenu-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3v-6h2.5l-2.54-7.63A3.002 3.002 0 0 0 16.5 6.5h-3c-1.38 0-2.54 1.17-2.96 2.87L8 16.5h2.5V22h3z" />
                            </svg>
                        </div>
                        <span class="submenu-text">Asistencia</span>
                    </a>
                </li>
                <li class="submenu-item {{ request()->routeIs('reportes.ingresos') ? 'active' : '' }}">
                    <a href="{{ route('reportes.ingresos') }}" class="submenu-link">
                    <a class="submenu-link">
                        <div class="submenu-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                            </svg>
                        </div>
                        <span class="submenu-text">Ingresos</span>
                    </a>
                </li>
                <li class="submenu-item {{ request()->routeIs('reportes.estadisticas') ? 'active' : '' }}">
                    <a href="{{ route('reportes.estadisticas') }}" class="submenu-link">
                    <a class="submenu-link">
                        <div class="submenu-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                            </svg>
                        </div>
                        <span class="submenu-text">Estadísticas</span>
                    </a>
                </li>
            </ul>
        </li> --}}
        </ul>
    </nav>

    <!-- Footer del Sidebar -->
    <div class="sidebar-footer">
        <div class="sidebar-divider"></div>

        <!-- Usuario -->
        <div class="sidebar-user">
            <a href="{{ route('recepcionista.perfil') }}" class="user-link">
                <div class="user-avatar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->nombreCompleto }}</span>
                    <span class="user-role">{{ Auth::user()->rol }}</span>
                </div>
            </a>
        </div>

        <!-- Cerrar Sesión -->
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-link">
                    <div class="logout-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                        </svg>
                    </div>
                    <span class="logout-text">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>
</aside>
