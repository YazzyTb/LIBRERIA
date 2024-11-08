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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement(); // Identificador único de la bitácora.
            
            $table->string('tabla_afectada', 20); // Nombre de la tabla afectada.
            
            $table->unsignedTinyInteger('accione_id'); // Tipo de operación realizada (INSERT, UPDATE, DELETE).
            
            $table->unsignedInteger('user_id'); // CI del Usuario que realizó la operación.
            
            $table->dateTime('fecha_hora'); // Fecha y hora de la operación.
            
            $table->text('datos_anteriores')->nullable(); // Datos antes de la operación.
            
            $table->text('datos_nuevos')->nullable(); // Datos después de la operación.

            $table->text('ip_address');
            
            $table->foreign('user_id')->references('id')->on('users'); // Clave foránea

            $table->foreign('accione_id')->references('id')->on('acciones');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
