<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Popula o banco de dados da aplicação.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Executar seeders na ordem correta respeitando relacionamentos
        $this->call([
            CategorySeeder::class,      // 1. Categorias (não tem dependências)
            CustomerSeeder::class,       // 2. Clientes com endereços
            ProductSeeder::class,        // 3. Produtos com variantes e imagens (depende de categorias)
            CouponSeeder::class,         // 4. Cupons (não tem dependências)
            OrderSeeder::class,          // 5. Pedidos com itens (depende de clientes e produtos)
            ReviewSeeder::class,         // 6. Avaliações (depende de clientes, produtos e pedidos)
        ]);
    }
}
