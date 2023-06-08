<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);

        $adminPermissions = [
            'create-job',
            'edit-job',
            'delete-job',
            'view-job',
            'submit-bid',
            'view-bid',
            'edit-bid',
            'withdraw-bid',
        ];

        $clientPermissions = [
            'create-job',
            'edit-job',
            'delete-job',
            'view-job',
            'view-bid',
        ];

        $vendorPermissions = [
            'submit-bid',
            'view-bid',
            'edit-bid',
            'withdraw-bid',
        ];

                // Create admin user
                $adminUser = User::create([
                    'first_name' => 'Tabish',
                    'last_name' => 'Raza',
                    'email' => 'haseebishtiaq300@gmail.com',
                    'password' => bcrypt('password'),
                ]);
                $adminUser->assignRole($adminRole);
        

        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission])->assignRole($adminRole);
        }

        foreach ($clientPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission])->assignRole($clientRole);
        }

        foreach ($vendorPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission])->assignRole($vendorRole);
        }
    }
}
