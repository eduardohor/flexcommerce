<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories
        $electronics = Category::factory()->create([
            'name' => 'Eletrônicos',
            'slug' => 'eletronicos',
            'is_active' => true,
        ]);

        $fashion = Category::factory()->create([
            'name' => 'Moda',
            'slug' => 'moda',
            'is_active' => true,
        ]);

        $home = Category::factory()->create([
            'name' => 'Casa e Decoração',
            'slug' => 'casa-decoracao',
            'is_active' => true,
        ]);

        // Create subcategories for Electronics
        Category::factory()->create([
            'name' => 'Smartphones',
            'slug' => 'smartphones',
            'parent_id' => $electronics->id,
            'is_active' => true,
        ]);

        Category::factory()->create([
            'name' => 'Notebooks',
            'slug' => 'notebooks',
            'parent_id' => $electronics->id,
            'is_active' => true,
        ]);

        Category::factory()->create([
            'name' => 'Câmeras',
            'slug' => 'cameras',
            'parent_id' => $electronics->id,
            'is_active' => true,
        ]);

        // Create subcategories for Fashion
        Category::factory()->create([
            'name' => 'Roupas Masculinas',
            'slug' => 'roupas-masculinas',
            'parent_id' => $fashion->id,
            'is_active' => true,
        ]);

        Category::factory()->create([
            'name' => 'Roupas Femininas',
            'slug' => 'roupas-femininas',
            'parent_id' => $fashion->id,
            'is_active' => true,
        ]);

        Category::factory()->create([
            'name' => 'Calçados',
            'slug' => 'calcados',
            'parent_id' => $fashion->id,
            'is_active' => true,
        ]);

        // Create subcategories for Home
        Category::factory()->create([
            'name' => 'Móveis',
            'slug' => 'moveis',
            'parent_id' => $home->id,
            'is_active' => true,
        ]);

        Category::factory()->create([
            'name' => 'Decoração',
            'slug' => 'decoracao',
            'parent_id' => $home->id,
            'is_active' => true,
        ]);

        // Create additional random categories
        Category::factory(5)->create();
    }
}
