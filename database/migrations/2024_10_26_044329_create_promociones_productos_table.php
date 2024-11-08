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
        Schema::create('promociones_productos', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement(); // Identificador de la promoción
            
            $table->string('nombre', 50); // Nombre de la promoción
            
            $table->string('descripcion', 500); // Descripción de la promoción
            
            $table->date('fecha_inicio'); // Fecha de inicio de la promoción
            
            $table->date('fecha_final'); // Fecha de finalización de la promoción
            
            $table->unsignedTinyInteger('promocione_id'); // Número de la promoción que se está haciendo
            
            $table->foreign('promocione_id')->references('id')->on('promociones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promociones_productos');
    }
};
