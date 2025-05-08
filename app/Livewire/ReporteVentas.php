<?php

namespace App\Livewire;

use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class ReporteVentas extends Component
{
    public function render()
    {
        $totalVentas = Venta::count();
        $montoTotal = Venta::sum('total') ?? 0;
        $ventasMes = Venta::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();
        $promedioVenta = $totalVentas > 0 ? $montoTotal / $totalVentas : 0;

        return view('livewire.reporte-ventas',[
            'ventas' => Venta::with(['cliente', 'detalles.producto'])
            ->latest()
            ->paginate(15),
            'totalVentas' => Venta::count(),
            'montoTotal' => Venta::sum('total'),
            'ventasMes' => $ventasMes,
            'promedioVenta' => $promedioVenta
            ])->layout('layouts.app',[
                'title' => 'Reporte de Ventas'
        ]);
    }
}
