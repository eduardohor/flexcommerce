<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => fake()->randomElement(['Casa', 'Trabalho', 'Principal']),
            'type' => fake()->randomElement(['billing', 'shipping', 'both']),
            'recipient_name' => fake()->name(),
            'recipient_phone' => fake()->phoneNumber(),
            'zip_code' => fake()->numerify('########'),
            'street' => fake()->streetName(),
            'number' => fake()->buildingNumber(),
            'complement' => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake()->citySuffix(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'country' => 'BR',
            'reference' => fake()->optional()->sentence(6),
            'is_default' => fake()->boolean(20),
            'is_active' => true,
        ];
    }
}
