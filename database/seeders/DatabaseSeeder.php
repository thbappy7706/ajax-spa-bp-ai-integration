<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            Permission::create(['name' => $permission]);
        }

        // Create Roles and assign permissions
        $adminRole = Role::create(['name' => 'Super Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo(['view products']);

        // Create Test User
        $user = User::factory()->create([
            'name' => 'Alex Rivera',
            'email' => 'admin@nexus.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole($adminRole);

        // Run ProductSeeder for 1 Lac products
//        $this->call(ProductSeeder::class);

        // Run PostSeeder for 50k posts
        $this->call(PostSeeder::class);
    }
}
