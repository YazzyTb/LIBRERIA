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
        Schema::create('producto_compra', function (Blueprint $table) {
            $table->string('producto_codigo', 8); // Código del producto
            
            $table->unsignedMediumInteger('compra_nro'); // Identificador del detalle de la compra
            
            $table->unsignedSmallInteger('cantidad'); // Cantidad de producto
            
            $table->decimal('precio_unitario', 8, 2); // Precio del producto
            
            $table->primary(['producto_codigo', 'compra_nro']); // Llave primaria compuesta
            
            $table->foreign('compra_nro')->references('nro')->on('compras'); // Llave foránea
            
            $table->foreign('producto_codigo')->references('codigo')->on('productos'); // Llave foránea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_compra');
    }
};
