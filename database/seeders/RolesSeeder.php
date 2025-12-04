<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminEmail =  'vipad@gmail.com';
        $superAdminUsername =  'vipad';

        // create super admin and assign existing permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superadminUser = \App\User::whereEmail($superAdminEmail)->first() ?? \App\User::factory()->create([
            'name' => 'Super Admin',
            'email' => $superAdminEmail,
            'username' => $superAdminUsername,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $superadminUser->assignRole($superAdmin);

        // permissions to admin
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $wardSecretary = Role::firstOrCreate(['name' => 'ward-secretary']);
        // $wardSecretary->syncPermissions([
        //     'organization.edit',
        //     'organization.delete',
        //     'organization.verify',
        // ]);

        // $user = Role::firstOrCreate(['name' => 'user']);
        // $user->syncPermissions([
        //     'organization.edit',
        //     'organization.delete',
        // ]);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $superAdmin->givePermissionTo($permission);
        }

    }
}
