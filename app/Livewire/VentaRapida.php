<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\SolicitudReposicion;
use App\Models\Venta;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class VentaRapida extends Component
{
    public $nombreCliente;
    public $dniCliente;
    public $productos = [];
    public $cliente;
    public $busquedaProducto = '';
    public $totalVenta = 0;

    public function mount()
    {
        Gate::authorize('registrar-ventas');
    }

    public function addProducto($id)
    {
        $p = Producto::findOrFail($id);

        if ($p->stock < 1){
            $this->dispatch(
                'notification', type: 'error', message: 'No hay stock disponible para este producto'
            );
            return;
        }

        if (collect($this->productos)->firstWhere('id',$id)) {
            $this->dispatch('notification',type: 'warning', message:'Producto ya agregado');
            return;
        }
        $p = Producto::findOrFail($id);
        $this->productos[] = [
            'id'=>$p->id, 'nombre'=>$p->nombre,
            'precio'=>$p->precio, 'cantidad'=>1
        ];
        $this->calcularTotal();
    }

    public function incrementarCantidad($i)
    {
        $this->productos[$i]['cantidad']++;
        $this->calcularTotal();
    }

    public function decrementarCantidad($i)
    {
        if($this->productos[$i]['cantidad']>1){
            $this->productos[$i]['cantidad']--;
            $this->calcularTotal();
        }
    }

    public function eliminarProducto($i)
    {
        unset($this->productos[$i]);
        $this->productos = array_values($this->productos);
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->totalVenta = collect($this->productos)
            ->sum(fn($x)=> $x['precio'] * $x['cantidad']);
    }

    public function finalizarVenta()
    {
        $this->validate([
            'nombreCliente' => 'required|string|max:100',
            'dniCliente' => 'nullable|digits:8',
        ],
            [
                'nombreCliente.required' => 'El nombre del cliente es obligatorio.',
                'dniCliente.digits' => 'El DNI debe tener 8 dígitos.',
            ]);
         foreach ($this->productos as $p) {
        $prodModel = Producto::findOrFail($p['id']);
        if ($prodModel->stock < $p['cantidad']) {
            $this->dispatch('notification', type: 'error', message: "No hay suficiente stock de {$prodModel->nombre}");
            return;
        }
        }
        if (!empty($this->dniCliente)) {
            $cliente = Cliente::firstOrCreate(
                ['dni' => $this->dniCliente],
                ['nombre' => $this->nombreCliente]
            );
        } else {
            $cliente = Cliente::firstOrCreate(
                ['nombre' => $this->nombreCliente, 'dni' => null]
            );
        }
        $v = Venta::create([
            'cliente_id'=>$cliente->id,
            'total'=>$this->totalVenta,
            'fecha'=>now(),
        ]);
        foreach($this->productos as $p){
            $v->detalles()->create([
                'producto_id'=>$p['id'],
                'cantidad'=>$p['cantidad'],
                'precio_unitario'=>$p['precio'],
            ]);
            Producto::where('id',$p['id'])->decrement('stock',$p['cantidad']);
        }

        $this->productos = [];
        $this->totalVenta = 0;
        $this->dispatch('notification',type: 'success',message:'Venta registrada');
    }

    public function solicitarReposicion($productoId)
    {
        $producto = Producto::findOrFail($productoId);

        if($producto->stock > 10){
            $this->dispatch('notification', type: 'warning', message: 'El stock del producto es suficiente');
        }

        $existeSolicitud = SolicitudReposicion::where('producto_id', $productoId)
        ->where('user_id', auth()->id())
        ->where('estado', 'pendiente')
        ->exists();

        if ($existeSolicitud) {
            $this->dispatch('notification', type: 'warning', message: 'Ya hay una solicitud pendiente para este producto');
            return;
        }

        SolicitudReposicion::create([
            'producto_id' => $productoId,
            'user_id' => auth()->id(),
            'cantidad_solicitada' => 100,
            'estado' => 'pendiente',
        ]);

        $this->dispatch('notification', type: 'success', message: 'Solicitud enviada a administración');
    }


    public function render()
    {
        $resultados = Producto::where('nombre', 'like', "%{$this->busquedaProducto}%")
            ->orWhere('sku', $this->busquedaProducto)
            ->limit(5)
            ->get();
        return view('livewire.venta-rapida', compact('resultados'))->layout('layouts.app', [
            'title' => 'Ventas'
        ]);
    }
}
