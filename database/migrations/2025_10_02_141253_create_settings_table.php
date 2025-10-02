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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Chave única para a configuração
            $table->string('key')->unique();
            $table->string('group')->default('general')->comment('general, store, payment, shipping, invoice, email, etc');

            // Valor (JSON para flexibilidade)
            $table->json('value')->nullable();

            // Tipo do valor (para validação)
            $table->enum('type', [
                'string',
                'text',
                'number',
                'boolean',
                'json',
                'array',
                'image',
                'color',
                'email',
                'url',
            ])->default('string');

            // Metadados
            $table->string('label')->nullable()->comment('Nome amigável');
            $table->text('description')->nullable()->comment('Descrição da configuração');
            $table->boolean('is_public')->default(false)->comment('Se pode ser acessado no frontend');

            $table->timestamps();

            $table->index('key');
            $table->index('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
