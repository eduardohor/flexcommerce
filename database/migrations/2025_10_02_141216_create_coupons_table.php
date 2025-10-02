<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // Tipo de desconto
            $table->enum('type', ['percentage', 'fixed', 'free_shipping'])->default('percentage');
            $table->decimal('value', 10, 2);

            // Limitações
            $table->decimal('min_purchase', 10, 2)->nullable()->comment('Valor mínimo de compra');
            $table->decimal('max_discount', 10, 2)->nullable()->comment('Desconto máximo (para percentuais)');
            $table->integer('usage_limit')->nullable()->comment('Limite total de usos');
            $table->integer('usage_limit_per_customer')->nullable()->comment('Limite por cliente');
            $table->integer('used_count')->default(0);

            // Datas de validade
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Aplicável a
            $table->json('applicable_categories')->nullable()->comment('IDs de categorias');
            $table->json('applicable_products')->nullable()->comment('IDs de produtos');
            $table->json('excluded_products')->nullable()->comment('IDs de produtos excluídos');

            // Controle
            $table->boolean('is_active')->default(true);
            $table->boolean('first_purchase_only')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index(['is_active', 'starts_at', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
