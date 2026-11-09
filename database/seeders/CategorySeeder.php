<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ["user_id" => 1, "category_name" => "Polo Shirt", "slug" => "polo-shirt", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "T-Shirt", "slug" => "t-shirt", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Hoodie", "slug" => "hoodie", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["user_id" => 1, "category_name" => "Jacket", "slug" => "jacket", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Sweatshirt", "slug" => "sweatshirt", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["user_id" => 1, "category_name" => "Shirt", "slug" => "shirt", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Underwear", "slug" => "underwear", "product_type_id" => 1, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["user_id" => 1, "category_name" => "Cap", "slug" => "cap", "product_type_id" => 2, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Bag", "slug" => "bag", "product_type_id" => 2, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["user_id" => 1, "category_name" => "Laptop Case", "slug" => "laptop-case", "product_type_id" => 2, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
            ["user_id" => 1, "category_name" => "Belt", "slug" => "belt", "product_type_id" => 2, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Wallet", "slug" => "wallet", "product_type_id" => 2, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Slider", "slug" => "slider", "product_type_id" => 3, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Shoe", "slug" => "shoe", "product_type_id" => 3, "created_at" => now(), "updated_at" => now(), 'is_archive' => null],
            ["user_id" => 1, "category_name" => "Sock", "slug" => "sock", "product_type_id" => 3, "created_at" => now(), "updated_at" => now(), "is_archive" => null],
        ];

        Category::insert($categories);
    }
}
