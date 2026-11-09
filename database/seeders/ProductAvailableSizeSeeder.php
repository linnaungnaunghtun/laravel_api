<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAvailableSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::with("sizes")->get();
        $products->each(function ($product) {
            $sizes = $product->sizes->pluck('size')->unique()->toArray();
            $product->available_size = count($sizes) ? "." . join(".", $sizes) . "." : null;
            $product->save();
        });
    }
}
