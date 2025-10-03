<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);
        $price = fake()->randomFloat(2, 10, 1000);
        $subtotal = $price * $quantity;
        $discount = fake()->randomFloat(2, 0, $subtotal * 0.2);
        $total = $subtotal - $discount;

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'product_variant_id' => null,
            'product_name' => fake()->words(3, true),
            'product_sku' => strtoupper(fake()->bothify('???-####')),
            'variant_attributes' => null,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'ncm' => fake()->optional()->numerify('########'),
            'cfop' => fake()->optional()->numerify('####'),
            'tax_amount' => fake()->randomFloat(2, 0, $total * 0.15),
        ];
    }
}
