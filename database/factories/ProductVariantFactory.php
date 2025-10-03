<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 10, 1000);
        $compareAtPrice = fake()->boolean(30) ? $price * fake()->randomFloat(2, 1.1, 1.5) : null;

        $colors = ['Preto', 'Branco', 'Azul', 'Vermelho', 'Verde', 'Amarelo'];
        $sizes = ['P', 'M', 'G', 'GG', 'XG'];

        $color = fake()->randomElement($colors);
        $size = fake()->randomElement($sizes);

        return [
            'product_id' => Product::factory(),
            'sku' => strtoupper(fake()->bothify('VAR-???-####')),
            'name' => $color . ' - ' . $size,
            'attributes' => json_encode(['cor' => $color, 'tamanho' => $size]),
            'price' => $price,
            'cost_price' => $price * fake()->randomFloat(2, 0.4, 0.7),
            'compare_at_price' => $compareAtPrice,
            'weight' => fake()->optional()->randomFloat(3, 0.1, 50),
            'height' => fake()->optional()->randomFloat(2, 5, 100),
            'width' => fake()->optional()->randomFloat(2, 5, 100),
            'length' => fake()->optional()->randomFloat(2, 5, 100),
            'image' => null,
            'is_active' => true,
        ];
    }
}
