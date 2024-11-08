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
        Schema::create('promocion_sin_descuento', function (Blueprint $table) {
            $table->string('producto_codigo', 8); // Identificación del producto

            $table->unsignedSmallInteger('promociones_producto_id'); // Identificador de la promoción
            
            $table->primary(['producto_codigo', 'promociones_producto_id']);
            
            $table->foreign('promociones_producto_id')->references('id')->on('promociones_productos');
            
            $table->foreign('producto_codigo')->references('codigo')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocion_sin_descuento');
    }
};
