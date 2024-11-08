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
        Schema::create('role_privilegio', function (Blueprint $table) {
            $table->tinyInteger('role_id')->unsigned(); // Identificador del rol
            
            $table->tinyInteger('privilegio_id')->unsigned(); // Identificador del privilegio
            
            $table->primary(['role_id', 'privilegio_id']); // Clave primaria compuesta

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Clave foránea a ROL
            
            $table->foreign('privilegio_id')->references('id')->on('privilegios')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Clave foránea a PRIVILEGIO
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_privilegio');
    }
};
