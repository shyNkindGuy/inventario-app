<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'sku',
        'stock',
        'precio',
    ];

    public function solicitudesReposicion()
    {
        return $this->hasMany(SolicitudReposicion::class);
    }
}
