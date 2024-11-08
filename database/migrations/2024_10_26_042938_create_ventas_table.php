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
        Schema::create('ventas', function (Blueprint $table) {
            $table->unsignedInteger('nro')->autoIncrement(); // Número de venta
            
            $table->decimal('monto_total', 8, 2)->unsigned(); // Precio total de la venta realizada
            
            $table->unsignedInteger('factura_nro'); // Número de factura

            $table->foreign('factura_nro')->references('nro')->on('facturas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
