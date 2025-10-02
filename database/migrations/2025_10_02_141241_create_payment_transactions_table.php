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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Identificação da transação
            $table->string('transaction_id')->unique()->comment('ID da transação no gateway');
            $table->string('gateway')->comment('mercadopago, stripe, asaas, etc');
            $table->string('payment_method')->comment('credit_card, pix, boleto, etc');

            // Valores
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->default(0)->comment('Taxa do gateway');
            $table->decimal('net_amount', 10, 2)->comment('Valor líquido');

            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'approved',
                'authorized',
                'in_process',
                'in_mediation',
                'rejected',
                'cancelled',
                'refunded',
                'charged_back',
            ])->default('pending');

            // Dados do pagamento
            $table->json('payment_data')->nullable()->comment('Dados específicos do gateway');

            // Datas importantes
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            // Mensagens e erros
            $table->text('status_message')->nullable();
            $table->text('error_message')->nullable();

            // Webhook
            $table->json('webhook_data')->nullable();
            $table->timestamp('webhook_received_at')->nullable();

            $table->timestamps();

            $table->index('transaction_id');
            $table->index(['order_id', 'status']);
            $table->index('gateway');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
