<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view products', 'create products', 'edit products', 'delete products',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        // Create Roles and assign permissions
        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);
        $adminRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        $userRole = \Spatie\Permission\Models\Role::create(['name' => 'User']);
        $userRole->givePermissionTo(['view products']);

        // Create Test User
        $user = User::factory()->create([
            'name' => 'Alex Rivera',
            'email' => 'admin@nexus.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $user->assignRole($adminRole);
    }
}
