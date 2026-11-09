<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the customer data to be inserted
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'address' => '123 Main St, Springfield, IL',
                'phone' => '123-456-7890',
                'gender' => 'male',
                'age' => 30,
                'age_range' => 'middle',
                'remark' => 'A regular customer',
                'level_id' => 2,
                "user_id" => 1,
                "city" => "Ka Chin",
                "township" => "Hlaing",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'address' => '456 Oak St, Springfield, IL',
                'phone' => '987-654-3210',
                'gender' => 'female',
                'age' => 23,
                'age_range' => 'young',
                'remark' => 'VIP customer',
                'level_id' => 1,
                "user_id" => 1,  // Assuming level_id refers to some existing level in the 'levels' table
                "city" => "Shan",
                "township" => "Taunggyi",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'address' => '789 Pine St, Springfield, IL',
                'phone' => '555-123-9876',
                'gender' => 'female',
                'age' => 50,
                'age_range' => 'old',
                'remark' => 'Frequent visitor',
                'level_id' => 1,
                "user_id" => 1,  // Assuming level_id refers to some existing level in the 'levels' table
                "city" => "mon",
                "township" => "pha-an",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'address' => '901 Maple St, Springfield, IL',
                'phone' => '555-555-5555',
                'gender' => 'male',
                'age' => 35,
                'age_range' => 'middle',
                'remark' => 'New customer',
                'level_id' => 3,
                "user_id" => 1,  // Assuming level_id refers to some existing level in the 'levels' table
                "city" => "Chin",
                "township" => "Hlaing",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Lee',
                'email' => 'david.lee@example.com',
                'address' => '1111 Cedar St, Springfield, IL',
                'phone' => '555-123-4567',
                'gender' => 'male',
                'age' => 28,
                'age_range' => 'young',
                'remark' => 'Regular customer',
                'level_id' => 1,
                "user_id" => 1,  // Assuming level_id refers to some existing level in the 'levels' table
                "city" => "Shan",
                "township" => "Taunggyi",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emma Taylor',
                'email' => 'emma.taylor@example.com',
                'address' => '2222 Elm St, Springfield, IL',
                'phone' => '555-555-1010',
                'gender' => 'female',
                'age' => 22,
                'age_range' => 'young',
                'remark' => 'Returning customer',
                'level_id' => 2,
                "user_id" => 1,  // Assuming level_id refers to some existing level in the 'levels' table
                "city" => "Chin",
                "township" => "Hlaing",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Olivia Martin',
                'email' => 'olivia.martin@example.com',
                'address' => '3333 Oak St, Springfield, IL',
                'phone' => '555-987-6543',
                'gender' => 'female',
                'age' => 25,
                'age_range' => 'young',
                'remark' => 'VIP customer',
                'level_id' => 1,
                "user_id" => 1,  // Assuming level_id refers to some existing level in the 'levels' table
                "city" => "Chin",
                "township" => "Hlaing",
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        Customer::insert($customers);
        // Insert the customer data into the 'customers' table
    }
}
