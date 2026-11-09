<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'voucher_no'=> 'qwertyuiopasdfgh',
                'customer_id' => 1,
                'type' => 'online',
                'payment_method' => 'wallet',
                'discount_percent' => 20,
                'discount_cash' => 0,
                'tax' => 1000,
                'total' => 100000,
                'total_charges' => 3000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_no' => 'azxcvbnmkloiuytr',
                'customer_id' => 2,
                'type' => 'online',
                'payment_method' => 'card',
                'discount_percent' => 10,
                'discount_cash' => 0,
                'tax' => 2000,
                'total' => 200000,
                'total_charges' => 3000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_no' => 'sdfghjkloiuytrew',
                'customer_id' => 3,
                'type' => 'offline',
                'payment_method' => 'cash',
                'discount_percent' => 0,
                'discount_cash' => 10000,
                'tax' => 3000,
                'total' => 300000,
                'total_charges' => 3000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_no' => 'dfghjklmnbvcxzas',
                'customer_id' => 4,
                'type' => 'online',
                'payment_method' => 'card',
                'discount_percent' => 0,
                'discount_cash' => 15000,
                'tax' => 2500,
                'total' => 250000,
                'total_charges' => 3000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_no' => 'lmnbvcxzasvbnmkj',
                'customer_id' => 5,
                'type' => 'offline',
                'payment_method' => 'cash',
                'discount_percent' => 20,
                'discount_cash' => 0,
                'tax' => 5000,
                'total' => 500000,
                'total_charges' => 3000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_no' => 'lmnbvcxzafvbnmk',
                'customer_id' => 6,
                'type' => 'offline',
                'payment_method' => 'cash',
                'discount_percent' => 50,
                'discount_cash' => 0,
                'tax' => 12000,
                'total' => 120000,
                'total_charges' => 3000,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_no' => 'lmngtreswfvbnmk',
                'customer_id' => 7,
                'type' => 'offline',
                'payment_method' => 'cash',
                'discount_percent' => 50,
                'discount_cash' => 0,
                'tax' => 12000,
                'total' => 120000,
                'total_charges' => 3000,
                'user_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Voucher::insert($vouchers);
    }
}
