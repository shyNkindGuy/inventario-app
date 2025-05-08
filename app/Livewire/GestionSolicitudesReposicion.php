<?php

namespace App\Livewire;

use App\Models\SolicitudReposicion;
use Livewire\Component;

class GestionSolicitudesReposicion extends Component
{
    public function marcarComoAtendida($solicitudId){

        $solicitud = SolicitudReposicion::find($solicitudId);

        $solicitud->update(['estado' => 'atendida']);

        $this->dispatch('notification', type: 'success', message: "Stock actualizado (+ {$solicitud->cantidad_solicitada} unidades)");
    }

    public function render()
    {
        return view('livewire.gestion-solicitudes-reposicion', [
            'solicitudes' => SolicitudReposicion::with(['producto', 'usuario'])
            ->where('estado', 'pendiente')
            ->get()
        ])->layout('layouts.app', ['title' => 'Solicitudes de Reposicion']);
    }
}
