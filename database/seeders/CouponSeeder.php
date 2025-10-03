<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Popula a tabela de cupons.
     */
    public function run(): void
    {
        // Criar cupons de desconto percentual ativos
        Coupon::factory(5)
            ->percentage()
            ->active()
            ->create();

        // Criar cupons de desconto fixo ativos
        Coupon::factory(5)
            ->fixed()
            ->active()
            ->create();

        // Criar cupons expirados
        Coupon::factory(3)
            ->expired()
            ->create();

        // Criar cupons promocionais específicos
        Coupon::factory()->create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10.00,
            'is_active' => true,
            'min_purchase' => 50.00,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(3),
        ]);

        Coupon::factory()->create([
            'code' => 'FREESHIP',
            'type' => 'fixed',
            'value' => 15.00,
            'is_active' => true,
            'min_purchase' => 100.00,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(6),
        ]);

        Coupon::factory()->create([
            'code' => 'SAVE50',
            'type' => 'fixed',
            'value' => 50.00,
            'is_active' => true,
            'min_purchase' => 200.00,
            'usage_limit' => 100,
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);
    }
}
