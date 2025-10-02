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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Pessoa Física ou Jurídica
            $table->enum('type', ['individual', 'business'])->default('individual');

            // Dados Pessoais (PF)
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('cpf', 11)->nullable()->unique();
            $table->date('birth_date')->nullable();

            // Dados Empresariais (PJ)
            $table->string('company_name')->nullable();
            $table->string('trading_name')->nullable();
            $table->string('cnpj', 14)->nullable()->unique();
            $table->string('state_registration')->nullable()->comment('Inscrição Estadual');
            $table->string('municipal_registration')->nullable()->comment('Inscrição Municipal');

            // Contato
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('accepts_marketing')->default(false);

            // Estatísticas
            $table->integer('total_orders')->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->timestamp('last_order_at')->nullable();

            // Observações
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->index('cpf');
            $table->index('cnpj');
            $table->index(['type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
