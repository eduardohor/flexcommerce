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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();

            // Polimórfico: pode ser produto ou variante
            $table->morphs('inventoriable');

            $table->integer('quantity')->default(0);
            $table->integer('reserved')->default(0)->comment('Quantidade reservada em pedidos pendentes');
            $table->integer('available')->virtualAs('quantity - reserved');
            $table->integer('low_stock_threshold')->default(5);

            $table->string('location')->nullable()->comment('Localização física no estoque');
            $table->string('batch_number')->nullable()->comment('Número do lote');
            $table->date('expiry_date')->nullable()->comment('Data de validade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
