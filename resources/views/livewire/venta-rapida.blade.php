
<div>
    <div class="container mt-5">
        @if(session()->has('notification'))
            <div class="alert alert-{{ session('notification.type') }} alert-dismissible fade show mb-5">
                {{ session('notification.message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row g-4">
            <div class="col-12">
                <div class="card card-flush shadow-sm mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Búsqueda de Productos</h3>
                    </div>
                    <div class="card-body">
                        <div class="input-group input-group-solid">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   placeholder="Buscar producto" 
                                   wire:model.live="busquedaProducto">
                        </div>
                        
                        <div class="mt-4">
                            @forelse($resultados as $p)
                                <div class="d-flex align-items-center mb-3 p-3 bg-light rounded cursor-pointer"
                                     wire:click="addProducto({{ $p->id }})">
                                    <div class="symbol symbol-50px me-3">
                                        <span class="symbol-label bg-primary text-white">
                                            {{ substr($p->nombre, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fs-5 fw-bold text-gray-800">{{ $p->nombre }}</span>
                                        <span class="text-muted">Stock: {{ $p->stock }} | ${{ number_format($p->precio, 2) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    No se encontraron productos
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card card-flush shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Detalle de la Venta</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="min-w-200px">Producto</th>
                                        <th class="min-w-120px">Cantidad</th>
                                        <th class="min-w-120px">P. Unitario</th>
                                        <th class="min-w-120px">Total</th>
                                        <th class="min-w-100px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $i => $prod)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-40px me-3">
                                                        <span class="symbol-label bg-light-primary">
                                                            {{ substr($prod['nombre'], 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <span class="fw-bold text-gray-800">{{ $prod['nombre'] }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-icon btn-light btn-sm me-2"
                                                            wire:click="decrementarCantidad({{ $i }})">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </button>
                                                    <input type="text" 
                                                           class="form-control form-control-solid w-60px text-center"
                                                           value="{{ $prod['cantidad'] }}" readonly>
                                                    <button class="btn btn-icon btn-light btn-sm ms-2"
                                                            wire:click="incrementarCantidad({{ $i }})">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-primary fw-bold">${{ number_format($prod['precio'], 2) }}</td>
                                            <td class="text-success fw-bold">${{ number_format($prod['precio'] * $prod['cantidad'], 2) }}</td>
                                            <td>
                                                <button class="btn btn-icon btn-danger btn-sm"
                                                        wire:click="eliminarProducto({{ $i }})">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-5">
                                                <div class="mt-1">No hay productos en el carrito</div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                                </svg>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="d-flex flex-column">
                                <span class="text-muted">Total de la Venta</span>
                                <h2 class="text-primary">${{ number_format($totalVenta, 2) }}</h2>
                            </div>
                            <button class="btn btn-primary btn-lg px-6"
                                    wire:click="finalizarVenta"
                                    @disabled(!count($productos))>
                                <i class="bi bi-check2 fs-4 me-2"></i>
                                Finalizar Venta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    fontSize: '1.3rem',
                    padding: '2rem 2rem'
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
</div>  
