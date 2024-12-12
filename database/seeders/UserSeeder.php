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

        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super_admin@meliora.web',
            'password' => Hash::make('pass123'),
        ]);
        $superAdminRole = $roles->where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdmin->assignRole($superAdminRole);
        }

        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@meliora.web',
            'password' => Hash::make('pass123'),
        ]);
        $adminRole = $roles->where('name', 'Admin')->first();
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        // Create Editor
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@meliora.web',
            'password' => Hash::make('pass123'),
        ]);
        $editorRole = $roles->where('name', 'Editor')->first();
        if ($editorRole) {
            $editor->assignRole($editorRole);
        }

        // Create Viewer
        $viewer = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@meliora.web',
            'password' => Hash::make('pass123'),
        ]);
        $viewerRole = $roles->where('name', 'Viewer')->first();
        if ($viewerRole) {
            $viewer->assignRole($viewerRole);
        }

        // Create users with a random role
        User::factory()->count(50)->create();
    }
}
