<?php

namespace App\Livewire;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteVentas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function exportarPDF($id)
    {
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.venta', compact('venta'));
        return $pdf->stream('venta-'.$venta->id.'.pdf');
    }
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
            ->paginate(10),
            'totalVentas' => Venta::count(),
            'montoTotal' => Venta::sum('total'),
            'ventasMes' => $ventasMes,
            'promedioVenta' => $promedioVenta
            ])->layout('layouts.app',[
                'title' => 'Reporte de Ventas'
        ]);
    }
}
