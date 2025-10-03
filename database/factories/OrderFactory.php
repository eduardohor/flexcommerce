<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 50, 5000);
        $discount = fake()->randomFloat(2, 0, $subtotal * 0.3);
        $shippingCost = fake()->randomFloat(2, 0, 100);
        $tax = fake()->randomFloat(2, 0, $subtotal * 0.15);
        $total = $subtotal - $discount + $shippingCost + $tax;

        return [
            'order_number' => fake()->unique()->numerify('ORD-######'),
            'customer_id' => Customer::factory(),
            'billing_address_id' => null,
            'shipping_address_id' => null,
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_cost' => $shippingCost,
            'tax' => $tax,
            'total' => $total,
            'coupon_id' => null,
            'coupon_code' => null,
            'shipping_method' => fake()->optional()->randomElement(['PAC', 'SEDEX', 'Transportadora']),
            'shipping_provider' => fake()->optional()->randomElement(['Correios', 'Jadlog', 'Loggi']),
            'tracking_code' => fake()->optional()->bothify('??########??'),
            'estimated_delivery_days' => fake()->optional()->numberBetween(3, 15),
            'shipped_at' => null,
            'delivered_at' => null,
            'payment_method' => fake()->optional()->randomElement(['credit_card', 'pix', 'boleto']),
            'payment_gateway' => fake()->optional()->randomElement(['Mercado Pago', 'Stripe', 'PagSeguro']),
            'paid_at' => null,
            'invoice_issued' => false,
            'invoice_issued_at' => null,
            'customer_notes' => fake()->optional()->sentence(),
            'admin_notes' => fake()->optional()->sentence(),
            'ip_address' => fake()->optional()->ipv4(),
            'user_agent' => fake()->optional()->userAgent(),
        ];
    }

    /**
     * Pedido pendente
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
    }

    /**
     * Pedido em processamento
     */
    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processing',
            'payment_status' => 'paid',
            'paid_at' => now()->subDays(rand(1, 5)),
        ]);
    }

    /**
     * Pedido enviado
     */
    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'shipped',
            'payment_status' => 'paid',
            'paid_at' => now()->subDays(rand(5, 15)),
            'shipped_at' => now()->subDays(rand(1, 10)),
            'tracking_code' => fake()->bothify('??########??'),
        ]);
    }

    /**
     * Pedido entregue
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
            'payment_status' => 'paid',
            'paid_at' => now()->subDays(rand(15, 30)),
            'shipped_at' => now()->subDays(rand(10, 25)),
            'delivered_at' => now()->subDays(rand(1, 15)),
            'tracking_code' => fake()->bothify('??########??'),
        ]);
    }

    /**
     * Pedido cancelado
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => 'refunded',
        ]);
    }
}
