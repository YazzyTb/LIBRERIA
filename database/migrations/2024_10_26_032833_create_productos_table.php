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
        Schema::create('productos', function (Blueprint $table) {
            $table->string('codigo', 8)->primary(); // Código del producto

            $table->string('nombre', 80); // Nombre del producto

            $table->decimal('precio', 8, 2)->unsigned(); // Precio del producto

            $table->date('fecha_de_publicacion'); // Fecha de publicación del producto

            $table->unsignedSmallInteger('editoriale_id'); // ID de la editorial del producto
            
            $table->foreign('editoriale_id')->references('id')->on('editoriales'); // Llave foránea a la tabla editorial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
