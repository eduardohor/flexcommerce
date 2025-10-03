<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Eletrônicos',
            'Moda Masculina',
            'Moda Feminina',
            'Casa e Decoração',
            'Esportes',
            'Livros',
            'Brinquedos',
            'Beleza',
            'Alimentos',
            'Pet Shop',
            'Informática',
            'Celulares',
            'Games',
            'Cama, Mesa e Banho',
            'Ferramentas',
        ];

        $name = fake()->randomElement($categories) . ' ' . fake()->word();
        $slug = Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 100000);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(20),
            'image' => null,
            'is_active' => fake()->boolean(90),
            'meta_title' => $name,
            'meta_description' => fake()->sentence(15),
        ];
    }
}
