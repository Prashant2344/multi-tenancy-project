<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds for a tenant.
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

        // You can add more default users or data here
        // User::factory(5)->create(); // Create 5 additional users
    }
}
