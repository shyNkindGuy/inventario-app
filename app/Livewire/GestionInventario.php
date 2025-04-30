<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class GestionInventario extends Component
{
    public $modalAbierto = false;
    public $productoId = null;
    public $nombre = '';
    public $descripcion = '';
    public $precio;
    public $stock;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        Gate::authorize('gestionar-inventario');
    }

    public function abrirModal($productoId = null)
    {
        $this->productoId = $productoId;
        
        if($productoId) {
            $producto = Producto::find($productoId);
            $this->nombre = $producto->nombre;
            $this->descripcion = $producto->descripcion;
            $this->precio = $producto->precio;
            $this->stock = $producto->stock;
        }
        
        $this->modalAbierto = true;
    }

    public function editarProducto($productoId)
    {
        Gate::authorize('gestionar-inventario');
        $this->abrirModal($productoId);
    }

    public function cerrarModal()
    {
        $this->reset(['modalAbierto', 'productoId', 'nombre', 'descripcion', 'precio', 'stock']);
    }

    public function guardarProducto()
    {
        $data = $this->validate([
            'nombre' => 'required|min:3|max:120',
            'descripcion' => 'nullable|max:500',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        if($this->productoId) {
            Producto::find($this->productoId)->update($data);
            $this->dispatch('notification', type: 'success', message: 'Producto actualizado');
        } else {
            Producto::create(array_merge($data, ['sku' => Str::uuid()]));
            $this->dispatch('notification', type: 'success', message: 'Producto creado');
        }

        $this->cerrarModal();
    }

    public function confirmarEliminacion($productoId)
    {
        $this->dispatch('confirmar', 
            type: 'warning',
            title: '¿Eliminar producto?',
            text: 'Esta acción no se puede deshacer',
            confirmButtonText: 'Sí, eliminar',
            method: 'eliminarProducto',
            params: $productoId
        );
    }

    public function eliminarProducto($productoId)
    {
        Producto::find($productoId)->delete();
        $this->dispatch('notification', type: 'success', message: 'Producto eliminado');
    }

    public function mostrarModalStock($productoId)
    {
        $this->dispatch('abrirModalStock', productoId: $productoId);
    }

    public function render()
    {
        return view('livewire.gestion-inventario', [
            'productos' => Producto::orderBy('nombre')->get()
        ])->layout('layouts.app');
    }
}