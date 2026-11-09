<?php

namespace Database\Seeders;

use App\Models\VoucherItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucher_items = [
            [
                'voucher_id'=> 1,
                'product_id'=> 1,
                'barcode' => 'BAR649A2',
                'price' => 10000,
                'quantity' => 1,
                'discount_percent' => 20,
                'discount_cash' => 0,
                'cost' => 8000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_id' => 1,
                'product_id'=> 2,
                'barcode' => 'BAR64A32',
                'price' => 25000,
                'quantity' => 1,
                'discount_percent' => 0,
                'discount_cash' => 5000,
                'cost' => 20000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_id' => 2,
                'product_id'=> 3,
                'barcode' => 'BAR64G0A',
                'price' => 40000,
                'quantity' => 1,
                'discount_percent' => 0,
                'discount_cash' => 7000,
                'cost' => 33000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_id' => 3,
                'product_id'=> 4,
                'barcode' => 'BAR64C82',
                'price' => 100000,
                'quantity' => 1,
                'discount_percent' => 50,
                'discount_cash' => 0,
                'cost' => 50000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_id' => 3,
                'product_id'=> 5,
                'barcode' => 'BAR64F02',
                'price' => 38000,
                'quantity' => 1,
                'discount_percent' => 0,
                'discount_cash' => 3000,
                'cost' => 35000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_id' => 3,
                'product_id'=> 6,
                'barcode' => 'BAR649A2',
                'price' => 10000,
                'quantity' => 1,
                'discount_percent' => 0,
                'discount_cash' => 1500,
                'cost' => 8500,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_id' => 7,
                'product_id'=> 7,
                'barcode' => 'BAR64C82',
                'price' => 67000,
                'quantity' => 1,
                'discount_percent' => 10,
                'discount_cash' => 0,
                'cost' => 663300,
                'user_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        VoucherItem::insert($voucher_items);
    }
}
