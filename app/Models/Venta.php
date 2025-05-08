<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id',
        'total',
        'fecha'
    ];
    public function detalles(){
        return $this->hasMany(DetalleVenta::class);
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
