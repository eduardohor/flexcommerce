<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['percentage', 'fixed', 'free_shipping']);
        $value = $type === 'percentage' ? fake()->numberBetween(5, 50) : fake()->randomFloat(2, 10, 200);

        return [
            'code' => strtoupper(fake()->bothify('???###')),
            'description' => fake()->optional()->sentence(),
            'type' => $type,
            'value' => $value,
            'min_purchase' => fake()->optional()->randomFloat(2, 50, 500),
            'max_discount' => $type === 'percentage' ? fake()->optional()->randomFloat(2, 50, 300) : null,
            'usage_limit' => fake()->optional()->numberBetween(10, 1000),
            'usage_limit_per_customer' => fake()->optional()->numberBetween(1, 5),
            'used_count' => fake()->numberBetween(0, 50),
            'starts_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'expires_at' => fake()->dateTimeBetween('now', '+3 months'),
            'applicable_categories' => null,
            'applicable_products' => null,
            'excluded_products' => null,
            'is_active' => fake()->boolean(80),
            'first_purchase_only' => fake()->boolean(20),
        ];
    }

    /**
     * Cupom ativo
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'starts_at' => now()->subDays(rand(1, 30)),
            'expires_at' => now()->addDays(rand(30, 90)),
        ]);
    }

    /**
     * Cupom percentual
     */
    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'percentage',
            'value' => fake()->numberBetween(5, 50),
        ]);
    }

    /**
     * Cupom valor fixo
     */
    public function fixed(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'fixed',
            'value' => fake()->randomFloat(2, 10, 200),
        ]);
    }

    /**
     * Cupom expirado
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'starts_at' => now()->subMonths(3),
            'expires_at' => now()->subDays(1),
        ]);
    }
}
