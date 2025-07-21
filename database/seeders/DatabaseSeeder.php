<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class, // Call the UserSeeder
  
        ]);

        \App\Models\User::updateOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin12345'), // Change to a secure password!
                'is_admin' => 1,
            ]
        );
    }
}
