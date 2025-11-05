<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            'view-courses',
            'create-courses',
            'edit-courses',
            'delete-courses',
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',
        ];

       foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }



       $superAdmin = Role::create(['name' => 'Super Admin']);
       $admin = Role::create(['name' => 'Admin']);
       $user = Role::create(['name' => 'User']);

       $permissions = Permission::all();

       $superAdmin->syncPermissions($permissions);

        // Assign specific permissions to Admin
        $admin->givePermissionTo([
            'view-users',
            'create-users',
            'edit-users',
            'view-roles',
            'view-permissions',
            'view-courses',
            'create-courses',
            'edit-courses',
            'view-categories',
            'create-categories',
            'edit-categories',
        ]);

       // User role gets basic permissions
        $user->givePermissionTo(['view-users']);
        
    }
}
