<!DOCTYPE html>
<html>
<head>
    <title>Boleta de Venta</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Boleta de Venta #{{ $venta->id }}</h2>
    <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Sin nombre' }}</p>
    <p><strong>DNI:</strong> {{ $venta->cliente->dni ?? 'Sin Documento' }}</p>
    <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombre }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>S/{{ number_format($detalle->precio_unitario, 2) }}</td>
                <td>S/{{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th>S/{{ number_format($venta->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
