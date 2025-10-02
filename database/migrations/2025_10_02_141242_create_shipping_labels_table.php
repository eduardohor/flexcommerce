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
        Schema::create('shipping_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Provider (Melhor Envio, Correios, etc)
            $table->string('provider')->comment('melhorenvio, correios, jadlog, loggi, kangu');
            $table->string('provider_label_id')->nullable()->comment('ID da etiqueta no provider');

            // Serviço de envio
            $table->string('service_code')->comment('PAC, SEDEX, etc');
            $table->string('service_name');

            // Rastreamento
            $table->string('tracking_code')->nullable()->unique();
            $table->text('tracking_url')->nullable();

            // Status
            $table->enum('status', [
                'pending',          // Pendente de geração
                'generated',        // Etiqueta gerada
                'posted',           // Postado
                'in_transit',       // Em trânsito
                'delivered',        // Entregue
                'failed',           // Falha na entrega
                'returned',         // Devolvido
                'cancelled',        // Cancelado
            ])->default('pending');

            // Valores e dimensões
            $table->decimal('declared_value', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            $table->decimal('weight', 8, 3)->comment('Peso em kg');
            $table->decimal('height', 8, 2)->comment('cm');
            $table->decimal('width', 8, 2)->comment('cm');
            $table->decimal('length', 8, 2)->comment('cm');

            // Prazo
            $table->integer('estimated_delivery_days')->nullable();
            $table->date('estimated_delivery_date')->nullable();

            // Arquivos
            $table->text('label_url')->nullable()->comment('URL da etiqueta PDF');
            $table->text('invoice_url')->nullable()->comment('URL da declaração de conteúdo');

            // Datas
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // Dados do provider
            $table->json('provider_response')->nullable();
            $table->json('tracking_history')->nullable();

            // Mensagens
            $table->text('error_message')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('tracking_code');
            $table->index(['order_id', 'status']);
            $table->index('provider');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_labels');
    }
};
