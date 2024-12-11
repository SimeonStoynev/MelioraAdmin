<?php

namespace Database\Seeders;

use App\Models\User;
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
        $superAdmin = Role::create(['name' => User::ROLE_SUPER_ADMIN]);
        $admin = Role::create(['name' => User::ROLE_ADMIN]);
        $editor = Role::create(['name' => User::ROLE_EDITOR]);
        $viewer = Role::create(['name' => User::ROLE_VIEWER]);

        $permissions = [
            'manage_ads',
            'manage_ad_templates',
            'read_dashboard',
            'system_configurations'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage_ads', 'manage_ad_templates', 'read_dashboard']);
        $editor->givePermissionTo(['manage_ads', 'manage_ad_templates']);
        $viewer->givePermissionTo(['read_dashboard']);
    }
}
