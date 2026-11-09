<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PosUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name' => 'POS Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('asdffdsa'),
            'role' => "admin",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::insert([
            'name' => 'POS Sale',
            'email' => 'sale@gmail.com',
            'password' => Hash::make('asdffdsa'),
            'role' => "sale",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
