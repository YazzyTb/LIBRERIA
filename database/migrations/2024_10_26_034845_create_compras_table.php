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
        Schema::create('compras', function (Blueprint $table) {
            $table->unsignedMediumInteger('nro')->autoIncrement(); // Identificador de la compra
            
            $table->decimal('monto_total', 8, 2)->unsigned(); // Monto total de la compra
            
            $table->date('fecha'); // Fecha de la compra
            
            $table->unsignedInteger('user_id'); // CI del Usuario que realizó la compra.

            $table->unsignedSmallInteger('proveedore_id'); // Identificador del proveedor
            
            $table->foreign('proveedore_id')->references('id')->on('proveedores'); // Llave foránea

            $table->foreign('user_id')->references('id')->on('users'); // Llave foránea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
