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
        Schema::create('revistas', function (Blueprint $table) {
            $table->string('producto_codigo', 8)->primary(); // Código del producto

            $table->unsignedSmallInteger('nro'); // Número de publicación de la revista
            
            $table->foreign('producto_codigo')->references('codigo')->on('productos')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Llave foránea a la tabla producto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revistas');
    }
};
