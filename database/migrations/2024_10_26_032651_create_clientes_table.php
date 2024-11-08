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
        Schema::create('clientes', function (Blueprint $table) {
            $table->unsignedInteger('ci')->autoIncrement(); // Identificación del cliente
            
            $table->string('nombre', 50); // Nombre del Cliente

            $table->unsignedSmallInteger('puntos'); // Puntos que tiene el cliente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
