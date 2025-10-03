<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'path' => 'https://picsum.photos/800/800?random=' . fake()->numberBetween(1, 1000),
            'disk' => 'public',
            'order' => fake()->numberBetween(0, 10),
            'is_primary' => false,
            'alt_text' => fake()->sentence(3),
        ];
    }
}
