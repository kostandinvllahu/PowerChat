<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $faker = Faker::create();
    
        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => 'user' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123')
            ]);
        }
    }
}
