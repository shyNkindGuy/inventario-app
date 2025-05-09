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
                                    <div class="symbol symbol-60px me-3">
                                        <span class="symbol-label bg-primary text-white">
                                            {{ substr($p->nombre, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fs-5 fw-bold text-gray-800 ">{{ $p->nombre }}</span>
                                        <span class="text-muted">Stock:
                                            <span class="{{ $p->stock <= 10 ? 'text-danger ' : 'text-muted' }}">
                                                {{ $p->stock }}
                                            </span>
                                            <span class="text-muted">| S/{{ number_format($p->precio, 2) }}</span>
                                        </span>
                                    </div>
                                    @if($p->stock <= 10 && !$p->solicitudEnviada)
                                        <button class="btn btn-sm btn-warning ms-2 py-1 px-2" 
                                                wire:click.stop="solicitarReposicion({{ $p->id }})">
                                            <i class="bi bi-exclamation-triangle"></i> Solicitar Reposición
                                        </button>
                                    @elseif($p->stock <= 10 && $p->solicitudEnviada)
                                        <button class="btn btn-sm btn-success ms-2 py-1 px-2" disabled>
                                            <i class="bi bi-check"></i> Solicitud Enviada
                                        </button>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    No se encontraron productos <br>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                    </svg>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card card-flush shadow-sm">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                        <h3 class="card-title fs-2"><i class="bi bi-receipt me-2"></i>Boleta de Venta</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Cliente</label>
                                <input type="text" class="form-control form-control-solid @error('nombreCliente') is-invalid @enderror" 
                                       placeholder="Nombre del cliente" wire:model="nombreCliente" required>
                                @error('nombreCliente') 
                                <span class="text-danger small">{{ $message }}</span> 
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">DNI</label>
                                <input type="text" class="form-control form-control-solid @error('dniCliente') is-invalid @enderror" 
                                       placeholder="DNI (opcional)" wire:model="dniCliente">
                                @error('dniCliente') 
                                <span class="text-danger small">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>
                
                        <div class="table-responsive mb-4">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">P. Unitario</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $i => $prod)
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-3 bg-light-primary text-primary fw-bold rounded-circle">
                                                {{ substr($prod['nombre'], 0, 1) }}
                                            </div>
                                            <span class="fw-bold">{{ $prod['nombre'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group input-group-sm justify-content-center">
                                                <button class="btn btn-outline-secondary" wire:click="decrementarCantidad({{ $i }})">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="text" class="form-control text-center w-50" 
                                                       value="{{ $prod['cantidad'] }}" readonly>
                                                <button class="btn btn-outline-secondary" wire:click="incrementarCantidad({{ $i }})">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-end">S/{{ number_format($prod['precio'], 2) }}</td>
                                        <td class="text-end fw-bold text-primary">S/{{ number_format($prod['precio'] * $prod['cantidad'], 2) }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-icon btn-danger btn-sm" wire:click="eliminarProducto({{ $i }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Observaciones</label>
                                <textarea class="form-control form-control-solid" placeholder="Observaciones (opcional)" 
                                          rows="3" wire:model="observaciones"></textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex justify-content-between fs-5 mb-2">
                                        <span>Subtotal:</span>
                                        <span>S/{{ number_format($totalVenta, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between fs-5 mb-2">
                                        <span>IGV (18%):</span>
                                        <span>S/{{ number_format($totalVenta * 0.18, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between fs-4 text-primary fw-bold border-top pt-2">
                                        <span>TOTAL:</span>
                                        <span>S/{{ number_format($totalVenta * 1.18, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-primary btn-lg px-5 fw-bold" 
                                    wire:click="finalizarVenta" 
                                    @disabled(!count($productos))>
                                <i class="bi bi-check-circle me-2"></i> Generar Venta
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
