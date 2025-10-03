<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['individual', 'business']);
        $isIndividual = $type === 'individual';

        return [
            'user_id' => User::factory(),
            'type' => $type,
            // Dados PF
            'first_name' => $isIndividual ? fake()->firstName() : null,
            'last_name' => $isIndividual ? fake()->lastName() : null,
            'cpf' => $isIndividual ? fake()->numerify('###########') : null,
            'birth_date' => $isIndividual ? fake()->date() : null,
            // Dados PJ
            'company_name' => !$isIndividual ? fake()->company() : null,
            'trading_name' => !$isIndividual ? fake()->companySuffix() . ' ' . fake()->lastName() : null,
            'cnpj' => !$isIndividual ? fake()->numerify('##############') : null,
            'state_registration' => !$isIndividual ? fake()->numerify('###########') : null,
            'municipal_registration' => !$isIndividual ? fake()->numerify('#########') : null,
            // Contato
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            // Status
            'is_active' => fake()->boolean(95),
            'accepts_marketing' => fake()->boolean(40),
            // Estatísticas
            'total_orders' => fake()->numberBetween(0, 50),
            'total_spent' => fake()->randomFloat(2, 0, 10000),
            'last_order_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
