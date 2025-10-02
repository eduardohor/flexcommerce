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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            // Informações básicas
            $table->string('title');
            $table->text('description')->nullable();

            // Imagens
            $table->string('image_desktop')->nullable();
            $table->string('image_mobile')->nullable();

            // Link
            $table->string('link_url')->nullable();
            $table->boolean('link_new_tab')->default(false);
            $table->string('button_text')->nullable();

            // Posicionamento
            $table->enum('position', [
                'home_main',        // Banner principal da home
                'home_secondary',   // Banners secundários
                'category',         // Banner de categoria
                'product',          // Banner de produto
                'cart',             // Banner no carrinho
                'custom',           // Posição customizada
            ])->default('home_main');

            // Controle
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            // Agendamento
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Estatísticas
            $table->integer('clicks_count')->default(0);
            $table->integer('views_count')->default(0);

            // Segmentação
            $table->json('target_categories')->nullable()->comment('Mostrar apenas em categorias específicas');
            $table->json('target_products')->nullable()->comment('Mostrar apenas em produtos específicos');
            $table->boolean('show_desktop')->default(true);
            $table->boolean('show_mobile')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['position', 'is_active', 'order']);
            $table->index(['starts_at', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
