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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            
            $table->string('name');
            
            $table->string('email')->unique();
            
            $table->timestamp('email_verified_at')->nullable();
            
            $table->string('password');
            
            $table->rememberToken();
            
            $table->unsignedTinyInteger('role_id')->nullable(); // id del rol
            
            $table->dateTime('inicio_session')->nullable(); // Fecha del último inicio de sesión del usuario 
            
            $table->dateTime('cierre_session')->nullable(); // Fecha del último cierre de sesión del usuario
            
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
