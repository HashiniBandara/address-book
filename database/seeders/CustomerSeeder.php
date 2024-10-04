<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 customers
        Customer::factory(10)->create()->each(function ($customer) {
            // For each customer, create 2 addresses
            Address::factory(2)->create(['customer_id' => $customer->id]);
        });
    }
}
