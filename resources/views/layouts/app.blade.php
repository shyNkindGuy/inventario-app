<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'Nova Salud')</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" />
        <link href="{{ asset('metronic/assets/css/style.bundle.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        @livewireStyles
    </head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Inventario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'inventario') active @endif" 
                        href="{{ route('inventario') }}">
                            <i class="bi bi-boxes me-2"></i>Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() == 'ventas') active @endif" 
                           href="{{ route('ventas') }}">
                            <i class="bi bi-cash-coin me-2"></i>Ventas
                        </a>
                    </li>
                </ul>
                @auth
                <span class="navbar-text text-white me-3">
                    <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i>Cerrar Sesión
                    </button>
                </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm me-2">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-person-plus"></i> Registro
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    <div class="content d-flex flex-column flex-column-fluid">
        <main class="py-4">
            @yield('content')
            {{ $slot }}
        </main>
    </div>
    <script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
</body>
</html>