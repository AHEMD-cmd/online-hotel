<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('asd'), // Use a secure password
            'role' => 'admin',
            'phone' => '1234567890',
            'country' => 'USA',
            'address' => '123 Admin St',
            'state' => 'CA',
            'city' => 'San Francisco',
            'zip' => '94105',
            'photo' => null,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Regular User
        DB::table('users')->insert([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('asd'), // Use a secure password
            'role' => 'user',
            'phone' => '0987654321',
            'country' => 'USA',
            'address' => '456 User Ave',
            'state' => 'NY',
            'city' => 'New York',
            'zip' => '10001',
            'photo' => null,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}