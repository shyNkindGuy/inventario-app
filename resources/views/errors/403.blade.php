
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="text-center">
        <div class="error-icon mb-4">
            <i class="bi bi-shield-lock text-danger" style="font-size: 5rem;" aria-hidden="true"></i>
        </div>
        
        <h1 class="text-danger mb-3">403 - Acceso Denegado</h1>
        <p class="lead text-muted mb-4">
            <i class="bi bi-exclamation-circle-fill"></i>
            No tienes los permisos necesarios para acceder a esta sección.
        </p>

        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-2"></i>Volver atrás
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-2"></i>Ir al Inicio
            </a>
        </div>

        @if(auth()->check())
        <div class="mt-4 text-muted small">
            Usuario actual: {{ auth()->user()->email }}<br>
            Rol: {{ auth()->user()->roles->first()->name ?? 'Sin rol asignado' }}
        </div>
        @endif
    </div>
</div>

<style>
    .error-icon {
        animation: bounce 1.5s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
</style>
