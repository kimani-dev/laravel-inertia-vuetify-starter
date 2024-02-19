<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminRole();
        $this->createUserRole();
    }

    public function createAdminRole(): void
    {
        // Create admin role
        $role = Role::create(['name' => 'admin']);

        // Assign all permissions to admin role
        $permissions = Permission::all();

        $role->syncPermissions($permissions);
    }

    public function createUserRole(): void
    {
        // Create user role
        $role = Role::create(['name' => 'user']);

        // Assign read permission to user role
        $permissions = Permission::where('name', 'read')->get();

        $role->syncPermissions($permissions);
    }
}
