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
        Schema::create('venta_producto', function (Blueprint $table) {
            $table->unsignedInteger('venta_nro'); // Número de venta

            $table->string('producto_codigo', 8); // Código del producto
            
            $table->unsignedSmallInteger('cantidad'); // Cantidad del producto vendido
            
            $table->decimal('precio_unitario', 8, 2)->unsigned(); // Precio unidad del producto

            $table->primary(['venta_nro', 'producto_codigo']);

            $table->foreign('venta_nro')->references('nro')->on('ventas');
            
            $table->foreign('producto_codigo')->references('codigo')->on('productos');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_producto');
    }
};
