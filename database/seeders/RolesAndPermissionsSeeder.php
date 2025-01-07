<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-link']);
        Permission::create(['name' => 'edit-link']);
        Permission::create(['name' => 'delete-link']);
        Permission::create(['name' => 'generate-qrcode']);
        Permission::create(['name' => 'delete-qrcode']);

        // Admin
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        Role::create(['name' => 'administrator']);
        Role::create(['name' => 'users']);

        $roleAdmin = Role::findByName('administrator');
        $roleAdmin->givePermissionTo(Permission::all());

        $roleUser = Role::findByName('users');
        $roleUser->givePermissionTo(['create-link', 'edit-link', 'delete-link', 'generate-qrcode', 'delete-qrcode']);
    }
}
