<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CrearTriggerActualizarMontoTotalAlUpdateCompra extends Migration
{
    public function up()
    {
        DB::unprepared('       
        CREATE TRIGGER actualizar_montoTotal_al_Update_compra
        AFTER UPDATE ON producto_compra
       FOR EACH ROW
       BEGIN
        DECLARE total DECIMAL(10, 2);
                -- Calcular el monto total sumando los subtotales de cada producto en la compra
                SET total = (SELECT SUM(cantidad * precio_unitario) 
                             FROM producto_compra 
                             WHERE compra_nro = OLD.compra_nro);
                
                -- Actualizar el campo monto_total en la tabla compras
                UPDATE compras 
                SET monto_total = total 
                WHERE nro = OLD.compra_nro;
        END;
     ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     DB::unprepared('DROP TRIGGER actualizar_montoTotal_al_Update_compra');
    }
};
