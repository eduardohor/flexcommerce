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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Avaliação
            $table->integer('rating')->comment('1 a 5 estrelas');
            $table->string('title')->nullable();
            $table->text('comment')->nullable();

            // Fotos da avaliação
            $table->json('photos')->nullable();

            // Moderação
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rejection_reason')->nullable();

            // Resposta da loja
            $table->text('store_response')->nullable();
            $table->timestamp('store_response_at')->nullable();

            // Utilidade
            $table->integer('helpful_count')->default(0);
            $table->integer('not_helpful_count')->default(0);

            // Verificação
            $table->boolean('is_verified_purchase')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_id', 'status']);
            $table->index(['customer_id', 'status']);
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
