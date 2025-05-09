@php use App\Models\SolicitudReposicion; @endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{$title ?? 'Nova Salud'}}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('metronic/assets/css/style.bundle.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar-custom {
            background-color: #004085;
            padding: 1rem 1.5rem;
            font-size: 1.2rem;
            transition: background 0.3s;
        }

        .navbar-custom:hover {
            background-color: #003366;
        }

        .navbar-custom .navbar-brand img {
            height: 60px;
        }

        .navbar-custom .nav-link {
            color: #ffffff !important;
            font-weight: 600;
            margin-right: 1.5rem;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .navbar-custom .nav-link:hover {
            color: #ffdd57 !important;
        }

        .navbar-custom .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 0.4rem;
            padding: 0.5rem 1rem;
        }

        .navbar-custom .badge {
            font-size: 1rem;
            padding: 0.4rem 0.7rem;
        }

        .navbar-custom .bi {
            font-size: 1.5rem;
        }
    </style>
    @livewireStyles
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-5">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo_panel.png') }}" draggable="false" alt="Logo Panel" class="me-8">
            <span class="fs-2 text-white">Sistema de Inventario</span>
        </a>
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
                <li class="nav-item">
                    <a class="nav-link @if(Route::currentRouteName() == 'reporte-ventas') active @endif" 
                       href="{{ route('reportes') }}">
                       <i class="bi bi-receipt me-2"></i>Reporte de Ventas
                    </a>
                </li>
                @can('gestionar-inventario')
                <li class="nav-item position-relative">
                    <a class="nav-link @if(Route::currentRouteName() == 'solicitudes') active @endif" href="{{ route('solicitudes') }}">
                        <i class="bi bi-clipboard-plus"></i> Solicitudes
                        @if($count = SolicitudReposicion::where('estado', 'pendiente')->count())
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $count }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
            </ul>
            @auth
            <span class="navbar-text text-white me-3 fs-5">
                <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-lg px-4 py-2">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </button>
            </form>
            @endauth
        </div>
    </div>
</nav>

<div class="content d-flex flex-column flex-column-fluid">
    <main class="py-4">
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
