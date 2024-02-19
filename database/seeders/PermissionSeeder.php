<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPermissions();
    }

    public function createPermissions(): void
    {
        // Create permissions
        $resources = [
            'users',
            'roles',
            'permissions',
        ];

        $permissions = [
            'create',
            'read',
            'update',
            'delete',
        ];

        foreach ($resources as $resource) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission . ' ' . $resource]);
            }
        }
    }
}
