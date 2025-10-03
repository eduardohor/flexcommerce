<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Popula a tabela de pedidos.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $variants = ProductVariant::all();

        // Criar pedidos pendentes
        Order::factory(10)
            ->pending()
            ->create()
            ->each(function ($order) use ($variants) {
                $this->createOrderItems($order, $variants, rand(1, 5));
            });

        // Criar pedidos em processamento
        Order::factory(15)
            ->processing()
            ->create()
            ->each(function ($order) use ($variants) {
                $this->createOrderItems($order, $variants, rand(2, 4));
            });

        // Criar pedidos enviados
        Order::factory(20)
            ->shipped()
            ->create()
            ->each(function ($order) use ($variants) {
                $this->createOrderItems($order, $variants, rand(1, 4));
            });

        // Criar pedidos entregues
        Order::factory(30)
            ->delivered()
            ->create()
            ->each(function ($order) use ($variants) {
                $this->createOrderItems($order, $variants, rand(1, 5));
            });

        // Criar alguns pedidos cancelados
        Order::factory(5)
            ->cancelled()
            ->create()
            ->each(function ($order) use ($variants) {
                $this->createOrderItems($order, $variants, rand(1, 3));
            });
    }

    /**
     * Criar itens para um pedido
     */
    private function createOrderItems(Order $order, $variants, int $itemCount): void
    {
        $selectedVariants = $variants->random($itemCount);

        foreach ($selectedVariants as $variant) {
            $quantity = rand(1, 3);
            $price = $variant->price ?? $variant->product->price;
            $subtotal = $price * $quantity;

            $order->items()->create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variant->id,
                'product_name' => $variant->product->name,
                'product_sku' => $variant->sku,
                'variant_attributes' => $variant->attributes,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $subtotal,
            ]);
        }
    }
}
