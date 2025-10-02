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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();

            // Identificação do tema
            $table->string('name')->unique()->comment('modern, classic, bold, minimal, elegant');
            $table->string('label')->comment('Nome amigável');
            $table->text('description')->nullable();

            // Preview
            $table->string('thumbnail')->nullable();
            $table->json('screenshots')->nullable();

            // Configurações de cores
            $table->json('colors')->nullable()->comment('Primary, secondary, accent, etc');

            // Configurações de tipografia
            $table->json('fonts')->nullable()->comment('Família de fontes');

            // Configurações de layout
            $table->json('layout')->nullable()->comment('Header style, footer style, etc');

            // Customizações CSS
            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();

            // Status
            $table->boolean('is_active')->default(false);
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index('name');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
