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
        Schema::create('intercambios', function (Blueprint $table) {
            $table->unsignedSmallInteger('nro')->autoIncrement(); // Número de Intercambio
            
            $table->smallInteger('cantidad'); // Cantidad de productos intercambiados
            
            $table->dateTime('fecha'); // Fecha de Intercambio
                        
            $table->string('motivo', 500); // Motivo del intercambio
            
            $table->unsignedInteger('user_id'); // Trabajador que realizó el intercambio
            
            $table->unsignedInteger('cliente_ci')->nullable(); // Cliente que realizó el intercambio
            
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->foreign('cliente_ci')->references('ci')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intercambios');
    }
};
