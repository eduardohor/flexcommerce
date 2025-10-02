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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            $table->string('label')->nullable()->comment('Ex: Casa, Trabalho, etc');
            $table->enum('type', ['billing', 'shipping', 'both'])->default('both');

            // Endereço completo
            $table->string('zip_code', 8);
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state', 2);
            $table->string('country', 2)->default('BR');

            // Referência
            $table->string('reference')->nullable();

            // Destinatário (pode ser diferente do cliente)
            $table->string('recipient_name')->nullable();
            $table->string('recipient_phone')->nullable();

            // Controle
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'type']);
            $table->index(['customer_id', 'is_default']);
            $table->index('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
