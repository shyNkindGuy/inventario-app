<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('roles') && Schema::hasTable('permissions')) {
            Gate::before(function ($user, $ability) {
                if ($user->hasRole('admin') || $user->hasPermissionTo($ability)) {
                    return true;
                }
                return null;

            });
    
            $this->createRolesAndPermissions();
        }
    }
    private function createRolesAndPermissions()
{
    try {
        $gestionInventario = Permission::firstOrCreate(['name' => 'gestionar-inventario']);
        $realizarVentas = Permission::firstOrCreate(['name' => 'realizar-ventas']);
        $registrarVentas = Permission::firstOrCreate(['name' => 'registrar-ventas']);

        Role::findByName('admin')->syncPermissions([$gestionInventario, $realizarVentas, $registrarVentas]);
        Role::findByName('usuario')->syncPermissions([$realizarVentas, $registrarVentas]);

    } catch (\Exception $e) {
        logger()->error('Error creando roles: '.$e->getMessage());
    }
    
}
}