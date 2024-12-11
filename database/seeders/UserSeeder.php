<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $roles = Role::all();

        if ($roles->isEmpty()) {
            $this->command->error('No roles found in the database. Please run the RoleSeeder first.');
            return;
        }

        // Create the Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super_admin@meliora.web',
            'password' => Hash::make('password'),
        ]);
        $superAdminRole = $roles->where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdmin->assignRole($superAdminRole);
        }

        // Create users with a random role
        User::factory()->count(50)->create();
    }
}
