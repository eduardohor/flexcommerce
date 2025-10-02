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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null');

            // Status do pedido
            $table->enum('status', [
                'pending',          // Aguardando pagamento
                'processing',       // Processando
                'confirmed',        // Confirmado
                'shipped',          // Enviado
                'delivered',        // Entregue
                'cancelled',        // Cancelado
                'refunded',         // Reembolsado
            ])->default('pending');

            // Status do pagamento
            $table->enum('payment_status', [
                'pending',          // Aguardando
                'paid',             // Pago
                'failed',           // Falhou
                'refunded',         // Reembolsado
                'partially_refunded', // Parcialmente reembolsado
            ])->default('pending');

            // Valores
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Cupom
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('coupon_code')->nullable();

            // Frete
            $table->string('shipping_method')->nullable();
            $table->string('shipping_provider')->nullable();
            $table->string('tracking_code')->nullable();
            $table->integer('estimated_delivery_days')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // Pagamento
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Nota Fiscal
            $table->boolean('invoice_issued')->default(false);
            $table->timestamp('invoice_issued_at')->nullable();

            // Observações
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();

            // IP e User Agent para análise
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('order_number');
            $table->index(['customer_id', 'status']);
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
