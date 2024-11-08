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
        Schema::create('libro_autore', function (Blueprint $table) {
            $table->string('producto_codigo', 8); // Código del producto

            $table->unsignedMediumInteger('autore_id'); // Identificador del autor
            
            $table->primary(['producto_codigo', 'autore_id']); // Clave primaria compuesta
            
            $table->foreign('producto_codigo')->references('codigo')->on('productos')
                  ->onUpdate('cascade')->onDelete('cascade'); // Clave foránea para producto
            
            $table->foreign('autore_id')->references('id')->on('autores')
                  ->onUpdate('cascade')->onDelete('cascade'); // Clave foránea para autor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_autore');
    }
};
