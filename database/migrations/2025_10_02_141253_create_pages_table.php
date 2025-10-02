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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            // Informações básicas
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();

            // Tipo de página
            $table->enum('type', [
                'custom',           // Página customizada
                'terms',            // Termos de Uso
                'privacy',          // Política de Privacidade
                'about',            // Sobre Nós
                'faq',              // FAQ
                'contact',          // Contato
                'shipping',         // Política de Envio
                'returns',          // Política de Devolução
            ])->default('custom');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

            // Controle
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_footer')->default(false);
            $table->boolean('show_in_header')->default(false);
            $table->integer('order')->default(0);

            // Template
            $table->string('template')->default('default')->comment('Layout específico para a página');

            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index(['type', 'is_active']);
            $table->index(['show_in_footer', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
