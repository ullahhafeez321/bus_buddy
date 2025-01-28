<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Create an admin user with a hashed password
        User::factory()->create([
            'name' => 'Allah Bakhsh',
            'email' => 'driver@driver.com',
            'password' => Hash::make('123'), // Hash the password
            'role' => 'driver',
        ]);

        User::factory()->create([
            'name' => 'Hafeez Ullah',
            'email' => 'hafeez@ullah.com',
            'password' => Hash::make('123'), // Hash the password
            'role' => 'student',
        ]);
       
    }
}
