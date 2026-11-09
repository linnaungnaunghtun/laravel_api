<?php

namespace Database\Seeders;

use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Add this import
use Faker\Factory as Faker;

class ShopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $shopCategory = [
            [
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'title' => "Special Discount",
                'link' => "https://boss-e-commerce.vercel.app/shop?item=new_in&sort_by=discount&sort_direction=desc",
                'image' => 'https://www.retail4growth.com/public/uploads/editor/2022-11-18/1668744871.jpg'
            ],
            [
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'title' => "Accessories",
                'link' => "https://boss-e-commerce.vercel.app/shop?item=new_in&filters%5Bproduct_type_id%5D=2",
                'image' => "https://b2bgiftsshop.com/cdn/shop/articles/HUGO_BOSS_Ladies_accessories_1728x.jpg?v=1704185836"
            ],
            [
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'title' => "Last Item",
                'link' => 'https://boss-e-commerce.vercel.app/shop?item=new_in&filters%5Bstock_count%5D=1',
                'image' => 'https://retailwire.com/wp-content/uploads/Hugo-Boss-iStock.com-salarko.jpg'
            ],
        ];
        ShopCategory::insert($shopCategory);
    }
}
