<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $usuario = Role::firstOrCreate(['name' => 'usuario']);

        Permission::firstOrCreate(['name' => 'gestionar-inventario']);
        Permission::firstOrCreate(['name' => 'registrar-ventas']);

        $admin->syncPermissions(['gestionar-inventario', 'registrar-ventas']);
        $usuario->syncPermissions(['registrar-ventas']);
    }
}
