<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Popula a tabela de avaliações.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        // Obter pedidos entregues para criar avaliações realistas
        $deliveredOrders = Order::where('status', 'delivered')->get();

        // Criar avaliações para produtos de pedidos entregues
        foreach ($deliveredOrders as $order) {
            // 70% de chance de avaliar produtos do pedido
            if (rand(1, 100) <= 70) {
                foreach ($order->items as $item) {
                    // 60% de chance de avaliar cada produto do pedido
                    if (rand(1, 100) <= 60) {
                        Review::factory()->create([
                            'customer_id' => $order->customer_id,
                            'product_id' => $item->product_id,
                        ]);
                    }
                }
            }
        }

        // Criar avaliações adicionais aleatórias
        Review::factory(30)->create();

        // Criar algumas avaliações com imagens
        Review::factory(15)
            ->withImages()
            ->create();

        // Criar avaliações pendentes de aprovação
        Review::factory(10)
            ->pending()
            ->create();
    }
}
