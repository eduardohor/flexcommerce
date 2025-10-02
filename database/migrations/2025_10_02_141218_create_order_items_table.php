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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('set null');

            // Snapshot dos dados do produto no momento da compra
            $table->string('product_name');
            $table->string('product_sku');
            $table->json('variant_attributes')->nullable()->comment('Ex: {"cor": "Azul", "tamanho": "M"}');

            // Preços
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Dados fiscais (snapshot)
            $table->string('ncm', 8)->nullable();
            $table->string('cfop', 4)->nullable();
            $table->decimal('tax_amount', 10, 2)->default(0);

            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
