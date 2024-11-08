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
        Schema::create('facturas', function (Blueprint $table) {
            $table->unsignedInteger('nro')->autoIncrement(); // Número de la factura
            
            $table->binary('formato_pago'); // Forma de pago: efectivo (0) o transacción (1)
            
            $table->dateTime('fecha'); // Fecha de la venta
            
            $table->unsignedInteger('user_id'); // Trabajador que realizó la factura
            
            $table->unsignedInteger('cliente_ci')->nullable(); // Cliente que realizó la compra
    
            $table->foreign('user_id')->references('id')->on('users'); // Relación con USUARIO
            
            $table->foreign('cliente_ci')->references('cI')->on('clientes'); // Relación con CLIENTE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
