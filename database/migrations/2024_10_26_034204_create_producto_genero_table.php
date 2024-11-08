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
        Schema::create('producto_genero', function (Blueprint $table) {
            $table->string('producto_codigo', 8); // Código del producto
            
            $table->unsignedTinyInteger('genero_id'); // Identificador del género
            
            $table->primary(['producto_codigo', 'genero_id']); // Clave primaria compuesta
            
            $table->foreign('producto_codigo')->references('codigo')->on('productos')
                  ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('genero_id')->references('id')->on('generos')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_genero');
    }
};