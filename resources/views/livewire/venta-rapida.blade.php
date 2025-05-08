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
                <div class="card card-flush shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title fs-2"><i class="bi bi-receipt me-2"></i>Boleta de Venta</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-person-badge fs-4"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-lg border-start-0 @error('nombreCliente') is-invalid @enderror"
                                           placeholder="Nombre del cliente"
                                           wire:model="nombreCliente" required>
                                </div>
                                @error('nombreCliente') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-credit-card fs-4"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-lg border-start-0 @error('dniCliente') is-invalid @enderror"
                                           placeholder="DNI/RUC (opcional)"
                                           wire:model="dniCliente">
                                </div>
                                @error('dniCliente') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                        </div>
    
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle fs-5">
                                <thead class="border-bottom border-1 border-dark">
                                    <tr>
                                        <th class="py-3">Producto</th>
                                        <th class="text-center py-3">Cantidad</th>
                                        <th class="text-end py-3">P. Unitario</th>
                                        <th class="text-end py-3">Total</th>
                                        <th class="text-center py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $i => $prod)
                                    <tr class="border-bottom">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-3">
                                                    <span class="symbol-label bg-light-success fs-4">
                                                        {{ substr($prod['nombre'], 0, 1) }}
                                                    </span>
                                                </div>
                                                <span class="fw-bold">{{ $prod['nombre'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-icon btn-light btn-sm me-2"
                                                        wire:click="decrementarCantidad({{ $i }})">
                                                    <i class="bi bi-dash-lg fs-5"></i>
                                                </button>
                                                <input type="text" 
                                                       class="form-control form-control-solid w-80px text-center fs-5"
                                                       value="{{ $prod['cantidad'] }}" readonly>
                                                <button class="btn btn-icon btn-light btn-sm ms-2"
                                                        wire:click="incrementarCantidad({{ $i }})">
                                                    <i class="bi bi-plus-lg fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-end py-3">S/{{ number_format($prod['precio'], 2) }}</td>
                                        <td class="text-end py-3 fw-bold text-success">S/{{ number_format($prod['precio'] * $prod['cantidad'], 2) }}</td>
                                        <td class="text-center py-3">
                                            <button class="btn btn-icon btn-danger btn-sm"
                                                    wire:click="eliminarProducto({{ $i }})">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="bi bi-chat-text fs-4"></i>
                                    </span>
                                    <textarea class="form-control" 
                                              placeholder="Observaciones (opcional)"
                                              rows="2"
                                              wire:model="observaciones"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-4">
                                    <div class="d-flex justify-content-between fs-4 mb-2">
                                        <span class="text-muted">Subtotal:</span>
                                        <span class="fw-bold">S/{{ number_format($totalVenta, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between fs-4 mb-3">
                                        <span class="text-muted">IGV (18%):</span>
                                        <span class="fw-bold">S/{{ number_format($totalVenta * 0.18, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between fs-2 text-success fw-bold border-top pt-3">
                                        <span>TOTAL:</span>
                                        <span>S/{{ number_format($totalVenta * 1.18, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-success btn-lg px-8 py-3 fw-bold"
                                    wire:click="finalizarVenta"
                                    @disabled(!count($productos))>
                                <i class="bi bi-check2-circle fs-3 me-2"></i>
                                GENERAR VENTA
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
