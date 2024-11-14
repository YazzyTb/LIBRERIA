<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CrearTriggerActualizarMontoTotalAlInsertCompra extends Migration
{
    public function up()
    {
        DB::unprepared('       
        CREATE TRIGGER actualizar_montoTotal_al_Insert_compra
        AFTER INSERT ON producto_compra
       FOR EACH ROW
       BEGIN
        DECLARE total DECIMAL(10, 2);
                -- Calcular el monto total sumando los subtotales de cada producto en la compra
                SET total = (SELECT SUM(cantidad * precio_unitario) 
                             FROM producto_compra 
                             WHERE compra_nro = NEW.compra_nro);
                
                -- Actualizar el campo monto_total en la tabla compras
                UPDATE compras 
                SET monto_total = total 
                WHERE nro = NEW.compra_nro;
        END;
     ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     DB::unprepared('DROP TRIGGER actualizar_montoTotal_al_Insert_compra');
    }
};
