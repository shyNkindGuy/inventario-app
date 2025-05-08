<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudReposicion extends Model
{
    protected $table = 'solicitudes_reposicion';
    
    protected $fillable = [
        'producto_id',
        'user_id',
        'cantidad_solicitada',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
