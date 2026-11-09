<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultProductType = [
            [
                "type" => "Clothings",
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,

            ],
            [
                "type" => "Accessories",
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,

            ],
            [
                "type" => "Footwear",
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,

            ],
        ];

        ProductType::insert($defaultProductType);
    }
}
