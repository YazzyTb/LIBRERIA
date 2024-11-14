<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CrearTriggerActualizarStockAlUpdateCompra extends Migration
{
    public function up()
    {
        DB::unprepared('       
        CREATE TRIGGER actualizar_stock_al_update_compra
       AFTER UPDATE ON producto_compra
       FOR EACH ROW
       BEGIN
        UPDATE stocks

        SET cantidad=(cantidad-OLD.cantidad)+NEW.cantidad
        WHERE producto_codigo=NEW.producto_codigo;
        END;
     ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     DB::unprepared('DROP TRIGGER actualizar_stock_al_update_compra');
    }
};
