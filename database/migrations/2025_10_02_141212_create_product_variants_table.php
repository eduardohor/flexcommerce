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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('sku')->unique();
            $table->string('name')->nullable()->comment('Ex: Vermelho / P');

            // Atributos (cor, tamanho, etc)
            $table->json('attributes')->comment('Ex: {"cor": "Vermelho", "tamanho": "P"}');

            // Preço específico (opcional, senão usa o do produto)
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('compare_at_price', 10, 2)->nullable();

            // Dimensões específicas (opcional)
            $table->decimal('weight', 8, 3)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();

            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_id', 'is_active']);
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
