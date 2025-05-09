<div>
    <div> 
        @forelse($solicitudes as $solicitud)
        <div class="card solicitud-card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h5 class="card-title">{{ $solicitud->producto->nombre }}</h5>
                    <p class="card-text mb-0">
                        <span class="text-muted">Solicitado por:</span> 
                        {{ $solicitud->usuario }}
                    </p>
                    <p class="card-text">
                        <span class="text-muted">Cantidad requerida:</span> 
                        <span class="badge bg-warning text-dark">{{ $solicitud->cantidad_solicitada }}</span>
                    </p>
                </div>
                <button wire:click="marcarComoAtendida({{ $solicitud->id }})" 
                        class="btn btn-success btn-icon">
                    <i class="bi bi-check2-circle fs-3"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <div class="empty-icon mb-6">
                <i class="bi bi-inbox fs-1 text-primary"></i>
            </div>
            <h2 class="text-muted">No hay solicitudes pendientes</h2>
            <p class="text-muted ">Parece que no hay solicitudes de reposición en este momento.</p>
        </div>
    @endforelse
    </div>

    <style>
        .empty-icon {
            font-size: 4rem;
            color: #6c757d;
        }
    </style>
</div>