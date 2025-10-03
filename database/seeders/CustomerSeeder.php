<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create customers with addresses
        Customer::factory(20)
            ->hasAddresses(2)
            ->create();

        // Create a specific test customer
        Customer::factory()
            ->hasAddresses(3)
            ->create([
                'email' => 'customer@example.com',
                'first_name' => 'João',
                'last_name' => 'Silva',
            ]);
    }
}
