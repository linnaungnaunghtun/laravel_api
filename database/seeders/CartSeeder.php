<?php
namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = [
            ['product_id' => 1, 'stock_id' => 1, 'user_id' => 3],
            ['product_id' => 2, 'stock_id' => 3, 'user_id' => 3],
            ['product_id' => 3, 'stock_id' => 2, 'user_id' => 3],
            ['product_id' => 4, 'stock_id' => 3, 'user_id' => 3],
            ['product_id' => 5, 'stock_id' => 4, 'user_id' => 3],
            ['product_id' => 1, 'stock_id' => 5, 'user_id' => 4],
            ['product_id' => 2, 'stock_id' => 3, 'user_id' => 4],
            ['product_id' => 3, 'stock_id' => 2, 'user_id' => 7],
            ['product_id' => 4, 'stock_id' => 4, 'user_id' => 5],
            ['product_id' => 5, 'stock_id' => 3, 'user_id' => 6],
        ];

        Cart::insert($carts);
    }
}
