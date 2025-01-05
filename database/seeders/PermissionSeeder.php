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
        $actions = ['create', 'view', 'update', 'delete'];
        $resources = ['users', 'roles', 'permissions', 'logs'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $action . ' ' . $resource,
                    // 'description' => 'Allows a user to ' . $action . ' ' . $resource,
                    // 'resource_type' => 'App\Models\Users\\' . ucfirst($resource),
                    // 'resource_id' => null
                ]);
            }
        }
    }
}
