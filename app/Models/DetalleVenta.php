<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio_unitario',
        'venta_id',
    ];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
