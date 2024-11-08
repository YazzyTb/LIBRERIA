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
        Schema::create('acciones', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->autoIncrement(); // Identificador de la acción
            
            $table->string('operacion', 10); // Nombre de la operación realizada
            
            $table->string('descripcion', 500); //descripcion de la operación realizada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones');
    }
};
