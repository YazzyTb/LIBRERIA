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
        Schema::create('ganancias', function (Blueprint $table) {
            $table->date('fecha')->primary(); // Fecha del día
                        
            $table->decimal('ganancia_total', 8, 2)->unsigned(); // Ganancia total del día
            
            $table->decimal('ganancia_neta', 8, 2)->unsigned(); // Ganancia neta del día
            
            $table->decimal('total_efectivo', 8, 2)->unsigned(); // Dinero en efectivo
            
            $table->decimal('total_transferencia', 8, 2)->unsigned(); // Transferencias bancarias
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganancias');
    }
};
