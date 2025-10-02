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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Informações básicas
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->longText('full_description')->nullable();

            // Preços
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('compare_at_price', 10, 2)->nullable();

            // Dimensões e peso para frete
            $table->decimal('weight', 8, 3)->nullable()->comment('Peso em kg');
            $table->decimal('height', 8, 2)->nullable()->comment('Altura em cm');
            $table->decimal('width', 8, 2)->nullable()->comment('Largura em cm');
            $table->decimal('length', 8, 2)->nullable()->comment('Comprimento em cm');

            // Informações fiscais (Brasil)
            $table->string('ncm', 8)->nullable()->comment('Código NCM');
            $table->string('cfop', 4)->nullable()->comment('Código CFOP');
            $table->string('cest', 7)->nullable()->comment('Código CEST');
            $table->enum('origem', ['0', '1', '2', '3', '4', '5', '6', '7', '8'])->default('0')->comment('Origem do produto');

            // Alíquotas
            $table->decimal('icms_aliquota', 5, 2)->nullable()->comment('Alíquota ICMS %');
            $table->decimal('ipi_aliquota', 5, 2)->nullable()->comment('Alíquota IPI %');
            $table->decimal('pis_aliquota', 5, 2)->nullable()->comment('Alíquota PIS %');
            $table->decimal('cofins_aliquota', 5, 2)->nullable()->comment('Alíquota COFINS %');

            // Status e controle
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('track_inventory')->default(true);
            $table->boolean('allow_backorder')->default(false);
            $table->integer('min_purchase')->default(1);
            $table->integer('max_purchase')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

            // Extras
            $table->json('attributes')->nullable()->comment('Atributos customizados');
            $table->integer('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'is_active']);
            $table->index('slug');
            $table->index('sku');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
