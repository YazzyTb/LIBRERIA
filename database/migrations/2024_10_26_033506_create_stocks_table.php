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
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('producto_codigo', 8)->primary(); // Código del producto
            
            $table->unsignedSmallInteger('cantidad'); // Cantidad disponible en inventario
           
            $table->unsignedSmallInteger('max_stock'); // Máxima cantidad permitida en stock
           
            $table->unsignedTinyInteger('min_stock'); // Mínima cantidad permitida en stock
            
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
        Schema::dropIfExists('stocks');
    }
};
