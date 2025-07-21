<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // List of admin users to create
        $admins = [
            [
                'name' => 'Admin 1',
                'email' => 'admin1@example.com',
                'password' => bcrypt('admin123'),
                'phone' => '1234567890',
                'id_card_number' => 'ID123456',
                'is_admin' => true,
            ],
            [
                'name' => 'Admin 2',
                'email' => 'admin2@example.com',
                'password' => bcrypt('admin123'),
                'phone' => '2345678901',
                'id_card_number' => 'ID234567',
                'is_admin' => true,
            ],
            [
                'name' => 'Admin 3',
                'email' => 'admin3@example.com',
                'password' => bcrypt('admin123'),
                'phone' => '3456789012',
                'id_card_number' => 'ID345678',
                'is_admin' => true,
            ],
        ];

        // Loop through and insert each admin user
        foreach ($admins as $admin) {
            User::updateOrCreate(['email' => $admin['email']], $admin);
        }
    }
}