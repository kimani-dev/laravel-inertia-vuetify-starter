<?php

namespace Database\Seeders\Users;

use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $this->createAdminUser();
    }

    public function createAdminUser(): void
    {
        $user = User::firstOrCreate([
            'email' => 'admin@test.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
        ]);
    }
}
