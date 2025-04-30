<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Livewire\GestionInventario;
use App\Livewire\VentaRapida;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:gestionar-inventario'])->group(function () {
    Route::get('/inventario', GestionInventario::class)->name('inventario');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/ventas', VentaRapida::class)->name('ventas');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
});