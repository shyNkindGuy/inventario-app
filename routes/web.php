<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Livewire\GestionInventario;
use App\Livewire\GestionSolicitudesReposicion;
use App\Livewire\ReporteVentas;
use App\Livewire\VentaRapida;
use Illuminate\Support\Facades\Route;


Route::get('/ventas/{id}/pdf', [ReporteVentas::class, 'exportarPDF'])->name('ventas.pdf');
Route::get('/reporte-ventas', ReporteVentas::class)
    ->middleware('auth')->name('reportes');

Route::get('/solicitudes', GestionSolicitudesReposicion::class)
    ->middleware(['auth', 'can:gestionar-inventario'])->name('solicitudes');

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('ventas')
        : redirect()->route('login');
});
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    });

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('can:realizar-ventas')->group(function () {
        Route::get('/ventas', VentaRapida::class)->name('ventas');
    });

    Route::get('/inventario', GestionInventario::class)
        ->middleware('can:gestionar-inventario')
        ->name('inventario');
});