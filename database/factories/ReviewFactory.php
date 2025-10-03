<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isApproved = fake()->boolean(90);

        return [
            'product_id' => Product::factory(),
            'customer_id' => Customer::factory(),
            'order_id' => null,
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence(5),
            'comment' => fake()->paragraph(3),
            'photos' => null,
            'status' => $isApproved ? 'approved' : 'pending',
            'approved_at' => $isApproved ? now()->subDays(rand(1, 30)) : null,
            'approved_by' => null,
            'rejection_reason' => null,
            'store_response' => fake()->optional(30)->paragraph(2),
            'store_response_at' => fake()->optional(30)->dateTimeBetween('-30 days', 'now'),
            'helpful_count' => fake()->numberBetween(0, 50),
            'not_helpful_count' => fake()->numberBetween(0, 10),
            'is_verified_purchase' => fake()->boolean(80),
        ];
    }

    /**
     * Avaliação com imagens
     */
    public function withImages(): static
    {
        return $this->state(fn (array $attributes) => [
            'photos' => json_encode([
                'https://picsum.photos/400/400?random=' . fake()->numberBetween(1, 1000),
                'https://picsum.photos/400/400?random=' . fake()->numberBetween(1, 1000),
            ]),
        ]);
    }

    /**
     * Avaliação pendente
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }
}
