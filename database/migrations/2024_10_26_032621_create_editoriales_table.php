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
        Schema::create('editoriales', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement(); // ID de la editorial
            
            $table->string('nombre', 50); // Nombre de la editorial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editoriales');
    }
};
