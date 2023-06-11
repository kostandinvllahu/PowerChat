<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'kostandin_vllahu',
            'email' => 'vllahukostandin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('k05t21998')
        ]);

        User::create([
            'name' => 'eliska_koniarova',
            'email' => 'eliska.koniarova@seznam.cz',
            'email_verified_at' => now(),
            'password' => Hash::make('k05t21998')
        ]);
    }
}
