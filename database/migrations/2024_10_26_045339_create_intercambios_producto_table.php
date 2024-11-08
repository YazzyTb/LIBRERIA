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
        Schema::create('intercambios_producto', function (Blueprint $table) {
            $table->unsignedSmallInteger('intercambio_nro'); // Número de Intercambio
            
            $table->string('producto_codigo', 8); // Código del producto de intercambio
            
            $table->primary(['intercambio_nro', 'producto_codigo']); // Clave primaria compuesta
            
            $table->foreign('intercambio_nro')->references('nro')->on('intercambios')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
                $table->foreign('producto_codigo')->references('codigo')->on('productos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intercambios_producto');
    }
};
