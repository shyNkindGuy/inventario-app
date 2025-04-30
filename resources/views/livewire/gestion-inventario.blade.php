<div class="card card-custom gutter-b">
    <div class="container mt-4">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-box-seam me-2"></i><h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-white">Gestión de Inventario</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">Total de productos: {{ $productos->count() }}</span>
                        </h3>
                    </h3>
                    <button class="btn btn-light btn-xl" wire:click="abrirModal">
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
                    </button>
                </div>
            </div>
    
            <div class="card-body bg-light">
                <div class="table-responsive rounded-3">
                    <table class="table table-hover align-middle bg-white">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th style="width: 25%">Producto</th>
                                <th style="width: 25%">Descripción</th>
                                <th style="width: 15%">Precio</th>
                                <th style="width: 20%">Stock</th>
                                <th style="width: 15%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $producto)
                            <tr class="text-center @if($producto->stock <= 10) table-warning @endif">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45 bg-info text-white rounded-circle me-3">
                                            <span class="fs-5 fw-bold">{{ substr($producto->nombre, 0, 1) }}</span>
                                        </div>
                                        <div class="text-start">
                                            <span class="fw-bold text-dark fs-5">{{ $producto->nombre }}</span><br>
                                            <small class="text-muted">SKU: {{ $producto->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted fs-5">{{ Str::limit($producto->descripcion, 40) }}</td>
                                <td>
                                    <span class="badge bg-success fs-5">${{ number_format($producto->precio, 2) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <span class="fs-4 fw-bold @if($producto->stock <= 10) text-danger @endif">
                                            {{ $producto->stock }}
                                        </span>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="dropdown">
                                                <i class="bi bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" 
                                                       wire:click="mostrarModalStock('{{ $producto->id }}')">
                                                        <i class="bi bi-plus-lg me-2"></i>Agregar Stock
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" 
                                                       wire:click="solicitarStock('{{ $producto->id }}')">
                                                        <i class="bi bi-bell me-2"></i>Solicitar Stock
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        @can('gestionar-inventario')
                                        <button class="btn btn-sm btn-outline-warning"
                                                wire:click="editarProducto('{{ $producto->id }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger"
                                                wire:click="confirmarEliminacion('{{ $producto->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 bg-light">
                                    <div class="fs-4 text-muted">
                                        <i class="bi bi-boxes me-2"></i>No hay productos registrados
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($modalAbierto)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $productoId ? 'Editar' : 'Nuevo' }} Producto</h5>
                        <button type="button" class="close" wire:click="cerrarModal">
                                <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="guardarProducto">
                            <div class="form-group">
                                <label>Nombre del Producto</label>
                                <input type="text" class="form-control" wire:model="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" wire:model="descripcion" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="number" step="0.01" class="form-control" wire:model="precio" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Stock Inicial</label>
                                        <input type="number" class="form-control" wire:model="stock" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary" wire:click="cerrarModal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@script
<script>
    window.addEventListener('notification', event => {
        Toastify({
            text: event.detail.message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            style: {
                fontSize: '1.1rem',
                padding: '1rem 2rem'
            },
            backgroundColor: {
                'success': '#1BC5BD',
                'warning': '#FFA800',
                'error': '#F64E60'
            }[event.detail.type],
            stopOnFocus: true
        }).showToast();
    });
</script>
@endscript