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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Informações da NFe
            $table->string('number')->nullable()->comment('Número da NFe');
            $table->string('series')->default('1')->comment('Série da NFe');
            $table->string('access_key')->nullable()->unique()->comment('Chave de acesso (44 dígitos)');
            $table->string('protocol')->nullable()->comment('Protocolo de autorização');

            // Provider (Focus NFe, eNotas, etc)
            $table->string('provider')->comment('focusnfe, enotas, nfeio, webmania');
            $table->string('provider_invoice_id')->nullable()->comment('ID da nota no provider');

            // Status
            $table->enum('status', [
                'draft',            // Rascunho
                'processing',       // Processando
                'authorized',       // Autorizada
                'cancelled',        // Cancelada
                'rejected',         // Rejeitada
                'error',            // Erro
            ])->default('draft');

            // Tipo
            $table->enum('type', ['nfe', 'nfce'])->default('nfe');
            $table->enum('operation', ['outgoing', 'incoming'])->default('outgoing');

            // Valores
            $table->decimal('total_value', 10, 2);
            $table->decimal('products_value', 10, 2);
            $table->decimal('shipping_value', 10, 2)->default(0);
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('tax_value', 10, 2)->default(0);

            // Arquivos
            $table->text('xml_url')->nullable();
            $table->text('pdf_url')->nullable();
            $table->text('danfe_url')->nullable();

            // Datas
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Mensagens e logs
            $table->text('status_message')->nullable();
            $table->json('error_log')->nullable();
            $table->json('provider_response')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('access_key');
            $table->index(['order_id', 'status']);
            $table->index('provider');
            $table->index('status');
            $table->index('number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
