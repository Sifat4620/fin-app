<?php

namespace Database\Seeders;

use App\Enum\Super;
use App\Models\User;
use App\Enum\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a Super Admin user with NID
        $user = User::factory()->create([
            'name'        => 'Super Admin',
            'email'       => 'admin@crm.com',
            'nid_number'  => '198745612345', 
            'password'    => Hash::make('12345678'),
        ]);

        // Create a Role for Super Admin
        Role::create([
            'name' => Super::Admin,
        ]);

        // Assign Role to User
        $user->assignRole(Super::Admin->value);

        // Create Permissions
        foreach (Permissions::cases() as $case) {
            Permission::create([
                'name' => $case->value,
            ]);
        }

        // Optionally seed products, categories, etc.
        // ProductCategory::factory(5)->create();
        // Product::factory(50)->create();
        // $this->call(OrderStatusSeeder::class);
    }
}
