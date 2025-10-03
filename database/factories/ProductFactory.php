<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $price = fake()->randomFloat(2, 10, 1000);
        $compareAtPrice = fake()->boolean(30) ? $price * fake()->randomFloat(2, 1.1, 1.5) : null;

        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'sku' => strtoupper(fake()->bothify('???-####')),
            'description' => fake()->paragraphs(3, true),
            'full_description' => fake()->paragraphs(5, true),
            'price' => $price,
            'cost_price' => $price * fake()->randomFloat(2, 0.4, 0.7),
            'compare_at_price' => $compareAtPrice,
            'weight' => fake()->randomFloat(3, 0.1, 50),
            'height' => fake()->randomFloat(2, 5, 100),
            'width' => fake()->randomFloat(2, 5, 100),
            'length' => fake()->randomFloat(2, 5, 100),
            'ncm' => fake()->numerify('########'),
            'cfop' => fake()->numerify('####'),
            'origem' => fake()->randomElement(['0', '1', '2']),
            'is_active' => fake()->boolean(90),
            'is_featured' => fake()->boolean(15),
            'track_inventory' => fake()->boolean(80),
            'allow_backorder' => fake()->boolean(20),
            'min_purchase' => 1,
            'max_purchase' => fake()->optional()->numberBetween(5, 100),
            'meta_title' => ucfirst($name),
            'meta_description' => fake()->sentence(15),
            'meta_keywords' => json_encode(fake()->words(5)),
        ];
    }

    /**
     * Produto em destaque
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Produto em promoção
     */
    public function onSale(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'];
            return [
                'compare_at_price' => $price * fake()->randomFloat(2, 1.2, 1.8),
            ];
        });
    }
}
