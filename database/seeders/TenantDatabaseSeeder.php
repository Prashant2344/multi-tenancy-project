<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds for a tenant database.
     */
    public function run(): void
    {
        // Create a default admin user for this tenant
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@' . tenant('id') . '.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // You can add more default data here
        // For example, create additional users, settings, etc.
        
        // Uncomment the line below if you want to create multiple users
        // User::factory(3)->create();
    }
}
