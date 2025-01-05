<?php

namespace Database\Seeders;

use App\RolesEnum;
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

    public function createAdminRole()
    {
        $role = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $permissions = Permission::all();

        $role->permissions()->sync($permissions->pluck('id'));
    }

    public function createUserRole()
    {
        $role = Role::firstOrCreate([
            'name' => 'user',
        ]);

        $permissions = Permission::where('name', 'like', '%view%')->get();

        $role->permissions()->sync($permissions->pluck('id'));
    }

    public function createOtherRoles()
    {
        foreach(RolesEnum::cases() as $role) {
            Role::firstOrCreate([
                'name' => $role->value,
            ]);
        }
    }
}
