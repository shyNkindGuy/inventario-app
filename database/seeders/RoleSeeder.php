<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'gestionar-inventario', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'realizar-ventas', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'registrar-ventas', 'guard_name' => 'web']); 

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(['gestionar-inventario', 'realizar-ventas', 'registrar-ventas']);


        $userRole = Role::firstOrCreate(['name' => 'usuario', 'guard_name' => 'web']);
        $userRole->syncPermissions(['realizar-ventas', 'registrar-ventas']);

    }
    
}
