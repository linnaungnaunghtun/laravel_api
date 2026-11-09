<?php
namespace Database\Seeders;

use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $wishlists = [
            ['product_id' => 1, 'user_id' => 3],
            ['product_id' => 2, 'user_id' => 3],
            ['product_id' => 3, 'user_id' => 3],
            ['product_id' => 4, 'user_id' => 3],
            ['product_id' => 5, 'user_id' => 3],
            ['product_id' => 1, 'user_id' => 4],
            ['product_id' => 2, 'user_id' => 4],
            ['product_id' => 3, 'user_id' => 7],
            ['product_id' => 4, 'user_id' => 5],
            ['product_id' => 5, 'user_id' => 6],
        ];

        Wishlist::insert($wishlists);

    }
}
