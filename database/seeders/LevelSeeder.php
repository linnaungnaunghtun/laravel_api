<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ["level" => "New", "discount" => 0, "user_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["level" => "VIP", "discount" => 5, "user_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["level" => "HS", "discount" => 10, "user_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["level" => "VVIP", "discount" => 20, "user_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
        ];
        Level::insert($levels);
    }
}
