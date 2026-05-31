<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $mangerRole = Role::firstOrCreate(['name' => 'manager']);

        $manager = User::firstOrCreate(
            ['email' => 'manager@test.com'],
            [
                'name' => 'John',
                'password' => Hash::make('password'),
            ],
        );

        $manager->assignRole($mangerRole);
    }
}
