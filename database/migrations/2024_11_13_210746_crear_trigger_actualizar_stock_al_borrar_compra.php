<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CrearTriggerActualizarStockAlBorrarCompra extends Migration
{
    public function up()
    {
        DB::unprepared('       
        CREATE TRIGGER actualizar_stock_al_borrar_compra
       AFTER DELETE ON producto_compra
       FOR EACH ROW
       BEGIN
        UPDATE stocks
        SET cantidad=cantidad-OLD.cantidad
        WHERE producto_codigo=OLD.producto_codigo;
        END;
     ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     DB::unprepared('DROP TRIGGER actualizar_stock_al_borrar_compra');
    }
};
