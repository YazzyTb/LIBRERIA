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
        Schema::create('privilegio', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned(); // Identificador del privilegio
            $table->string('nombre', 50); // Nombre del privilegio
        });

        Schema::create('rol', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned(); // Identificador de los roles
            $table->string('nombre', 50); // Nombre del rol
            $table->string('descripcion', 500); // Descripción del nivel
        });

        Schema::create('rol_privilegio', function (Blueprint $table) {
            $table->tinyInteger('id_rol')->unsigned(); // Identificador del rol
            $table->tinyInteger('id_privilegio')->unsigned(); // Identificador del privilegio
            
            $table->primary(['id_rol', 'id_privilegio']); // Clave primaria compuesta
            $table->foreign('id_rol')->references('id')->on('rol')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Clave foránea a ROL
            
            $table->foreign('id_privilegio')->references('id')->on('privilegio')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // Clave foránea a PRIVILEGIO
        });
        
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedTinyInteger('rol')->nullable(); // id del rol
            $table->dateTime('inicio_Sesion')->nullable(); // Fecha del último inicio de sesión del usuario 
            $table->dateTime('Cierre_Sesion')->nullable(); // Fecha del último cierre de sesión del usuario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privilegio');
        Schema::dropIfExists('rol');
        Schema::dropIfExists('rol_privilegio');
        Schema::dropIfExists('users');
    }
};
