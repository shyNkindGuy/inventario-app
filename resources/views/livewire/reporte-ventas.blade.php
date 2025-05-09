<div class="container-fluid px-4">
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-primary text-white py-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0"><i class="bi bi-bar-chart-line me-2"></i>Reporte Integral de Ventas</h2>
                <div class="badge bg-white text-primary fs-6">Actualizado al {{ now()->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-4 mb-5">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase small mb-2">Ventas Totales</h5>
                                    <h2 class="mb-0">{{ $totalVentas }}</h2>
                                </div>
                                <i class="bi bi-cart-check fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase small mb-2">Monto Total</h5>
                                    <h2 class="mb-0">S/{{ number_format($montoTotal, 2) }}</h2>
                                </div>
                                <i class="bi bi-cash-stack fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase small mb-2">Ventas/Mes</h5>
                                    <h2 class="mb-0">{{ $ventasMes }}</h2>
                                </div>
                                <i class="bi bi-calendar-month fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-dark h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-uppercase small mb-2">Promedio/Venta</h5>
                                    <h2 class="mb-0">S/{{ number_format($promedioVenta, 2) }}</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0"><i class="bi bi-list-task me-2"></i>Registro Detallado</h5>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Fecha y Hora</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-end pe-4">Total</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $venta)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-clock-history me-2 text-muted"></i>
                                            {{ $venta->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($venta->cliente)
                                        <div class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $venta->cliente->nombre }}
                                        </div>
                                        @else
                                        <span class="badge bg-secondary bg-opacity-25 text-dark">Sin nombre</span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-4 fw-bold text-success">
                                        S/{{ number_format($venta->total, 2) }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('ventas.pdf', $venta->id) }}" class="btn btn-sm btn-outline-secondary" 
                                           target="_blank" title="Descargar PDF">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Mostrando {{ $ventas->count() }} de {{ $ventas->total() }} registros</small>
                        {{ $ventas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .pagination {
            justify-content: center;
        }
        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }
        .page-link {
            color: #0d6efd;
            transition: all 0.3s;
        }
        .page-link:hover {
            background-color: #e9ecef;
        }
    </style>
</div>
