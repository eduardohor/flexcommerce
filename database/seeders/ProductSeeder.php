<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        // Criar produtos normais com variantes e imagens
        Product::factory(50)
            ->hasImages(rand(1, 5))
            ->hasVariants(rand(1, 3))
            ->create()
            ->each(function ($product) use ($categories) {
                // Anexar 1-3 categorias aleatórias por produto
                $product->categories()->attach(
                    $categories->random(rand(1, 3))->pluck('id')->toArray()
                );
            });

        // Criar produtos em destaque
        Product::factory(10)
            ->featured()
            ->hasImages(4)
            ->hasVariants(2)
            ->create()
            ->each(function ($product) use ($categories) {
                $product->categories()->attach(
                    $categories->random(rand(1, 2))->pluck('id')->toArray()
                );
            });

        // Criar produtos em promoção
        Product::factory(15)
            ->onSale()
            ->hasImages(3)
            ->hasVariants(1)
            ->create()
            ->each(function ($product) use ($categories) {
                $product->categories()->attach(
                    $categories->random(1)->pluck('id')->toArray()
                );
            });
    }
}
