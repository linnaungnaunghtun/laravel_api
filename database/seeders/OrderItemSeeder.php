<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 product random

        // 1 stock random

        // order item seeding

        // Insert 20 order items
        $order_items = [];
        for($i=0; $i<25; $i++)
        {
            $stock_id = $i + 1; // Stock ID starts from 1
            $product_id = Stock::where('id', $stock_id)->first()->product_id; // Get the product_id related to stock_id

            $order_items[] = [
            'order_id' => rand(1, 5),
            'stock_id' => $stock_id,
            'product_id' => $product_id,
            'is_sold' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            ];
        }
        // Insert order items into the database
        OrderItem::insert($order_items);
    }
}
