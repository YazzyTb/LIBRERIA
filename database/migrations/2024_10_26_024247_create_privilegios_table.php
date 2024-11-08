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
        Schema::create('privilegios', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned(); // Identificador del privilegio

            $table->string('nombre', 50); // Nombre del privilegio
            
            $table->string('descripcion', 500);// Descripcion del privilegio
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privilegios');
    }
};
