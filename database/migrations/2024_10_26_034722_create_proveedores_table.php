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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement(); // Identificador del proveedor
            
            $table->string('nombre', 50); // Nombre de la empresa proveedora
            
            $table->string('persona_de_contacto', 50); // Nombre de la persona de contacto
            
            $table->unsignedInteger('telefono_de_contacto'); // Número de contacto del proveedor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
