<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Get customer users
       $customers = User::where('role', 'customer')->pluck('id')->toArray();

       // Insert 5 orders for random customers
       $orders = [];

       for ($i = 0; $i < 5; $i++) {
        $customer = $customers[$i]; // Get the customer object

        // Fetch the first address of the customer
        $address = Address::where('user_id', $customer)->first();

        if ($address) { // Ensure an address exists
            $orders[] = [
                'user_id'        => $customer, // Use integer ID
                'address_id'     => $address->id, // Use integer ID
                'item_count'     => rand(1, 10),
                'total'          => rand(100000, 10000000),
                'discount'       => null,
                'coupon_code'    => null,
                'status'         => array_rand(['pending' => 'pending', 'confirmed' => 'confirmed']), // Correct array_rand usage
                'cancel_message' => '',
                'cancel_user_id' => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }
    }

    // Insert orders into the database
    Order::insert($orders);
    }
}
