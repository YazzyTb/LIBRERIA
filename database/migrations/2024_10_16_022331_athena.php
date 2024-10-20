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
        Schema::create('accion', function (Blueprint $table) {
            $table->unsignedTinyInteger('Id')->autoIncrement(); // Identificador de la acción
            $table->string('operacion', 10); // Nombre de la operación realizada
        });

        Schema::create('bitacora', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement(); // Identificador único de la bitácora.
            $table->string('tabla_Afectada', 20); // Nombre de la tabla afectada.
            $table->unsignedTinyInteger('Accion_realizad'); // Tipo de operación realizada (INSERT, UPDATE, DELETE).
            $table->unsignedInteger('Usuario'); // CI del Usuario que realizó la operación.
            $table->dateTime('Fecha_Hora'); // Fecha y hora de la operación.
            $table->text('Datos_Anteriores')->nullable(); // Datos antes de la operación.
            $table->text('Datos_Nuevos')->nullable(); // Datos después de la operación.
            
            $table->foreign('Usuario')->references('id')->on('users'); // Clave foránea
        });

        Schema::create('cliente', function (Blueprint $table) {
            $table->unsignedInteger('CI')->autoIncrement(); // Identificación del cliente
            $table->string('Nombre', 50); // Nombre del Cliente
            $table->unsignedSmallInteger('Puntos'); // Puntos que tiene el cliente
        });

        Schema::create('editorial', function (Blueprint $table) {
            $table->unsignedSmallInteger('Id')->autoIncrement(); // ID de la editorial
            $table->string('Nombre', 50); // Nombre de la editorial
        });

        Schema::create('producto', function (Blueprint $table) {
            $table->string('Codigo', 8)->primary(); // Código del producto
            $table->string('Nombre', 80); // Nombre del producto
            $table->decimal('Precio', 8, 2)->unsigned(); // Precio del producto
            $table->date('Fecha_De_Publicacion'); // Fecha de publicación del producto
            $table->unsignedSmallInteger('Editorial_Id'); // ID de la editorial del producto
            $table->foreign('Editorial_Id')->references('Id')->on('editorial'); // Llave foránea a la tabla editorial
        });

        Schema::create('libro', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8)->primary(); // Código del producto
            $table->binary('Tipo_De_tapa'); // Tapa dura (0) o tapa blanda (1)
            $table->unsignedTinyInteger('Edicion'); // Edición del libro publicado
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Llave foránea a la tabla producto
        });

        Schema::create('revista', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8)->primary(); // Código del producto
            $table->unsignedSmallInteger('Nro'); // Número de publicación de la revista
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Llave foránea a la tabla producto
        });

        Schema::create('enciclopedia', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8)->primary(); // Código del producto
            $table->unsignedTinyInteger('Volumen'); // Volumen de la enciclopedia
            $table->unsignedTinyInteger('Edicion'); // Edición de la enciclopedia
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Llave foránea a la tabla producto
        });

        Schema::create('stock', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8)->primary(); // Código del producto
            $table->unsignedSmallInteger('Cantidad'); // Cantidad disponible en inventario
            $table->unsignedSmallInteger('Max_Stock'); // Máxima cantidad permitida en stock
            $table->unsignedTinyInteger('Min_Stock'); // Mínima cantidad permitida en stock
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); // Llave foránea a la tabla producto
        });

        Schema::create('genero', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->autoIncrement(); // Identificador del género literario
            $table->string('Descripcion', 20); // Nombre del género literario
        });

        Schema::create('genero_producto', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8); // Código del producto
            $table->unsignedTinyInteger('id_Genero'); // Identificador del género
            $table->primary(['Codigo_Producto', 'id_Genero']); // Clave primaria compuesta
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_Genero')->references('id')->on('genero')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('autor', function (Blueprint $table) {
            $table->unsignedMediumInteger('Id')->autoIncrement(); // Identificador del autor
            $table->string('Nombre', 60); // Nombre del autor
        });

        Schema::create('escribio', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8); // Código del producto
            $table->unsignedMediumInteger('Id_Autor'); // Identificador del autor
            $table->primary(['Codigo_Producto', 'Id_Autor']); // Clave primaria compuesta
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                  ->onUpdate('cascade')->onDelete('cascade'); // Clave foránea para producto
            $table->foreign('Id_Autor')->references('Id')->on('autor')
                  ->onUpdate('cascade')->onDelete('cascade'); // Clave foránea para autor
        });

        Schema::create('proveedor', function (Blueprint $table) {
            $table->unsignedSmallInteger('ID')->autoIncrement(); // Identificador del proveedor
            $table->string('Nombre', 50); // Nombre de la empresa proveedora
            $table->string('Persona_De_Contacto', 50); // Nombre de la persona de contacto
            $table->unsignedInteger('Telefono_De_Contacto'); // Número de contacto del proveedor
        });

        Schema::create('compra', function (Blueprint $table) {
            $table->unsignedMediumInteger('Nro')->autoIncrement(); // Identificador de la compra
            $table->decimal('Monto_Total', 8, 2)->unsigned(); // Monto total de la compra
            $table->date('Fecha'); // Fecha de la compra
            $table->unsignedSmallInteger('Id_Proveedor'); // Identificador del proveedor
            $table->foreign('Id_Proveedor')->references('ID')->on('proveedor'); // Llave foránea
        });

        Schema::create('detalle_de_compra', function (Blueprint $table) {
            $table->unsignedMediumInteger('Nro_Compra'); // Identificador del detalle de la compra
            $table->string('Codigo_Producto', 8); // Código del producto
            $table->unsignedSmallInteger('Cantidad'); // Cantidad de producto
            $table->decimal('Precio_Unitario', 8, 2); // Precio del producto
            $table->primary(['Nro_Compra', 'Codigo_Producto']); // Llave primaria compuesta
            $table->foreign('Nro_Compra')->references('Nro')->on('compra'); // Llave foránea
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto'); // Llave foránea
        });

        Schema::create('ganancia_diaria', function (Blueprint $table) {
            $table->date('Fecha')->primary(); // Fecha del día
            $table->decimal('Ganancia_Neta', 8, 2)->unsigned(); // Ganancia neta del día
            $table->decimal('Ganancia_Total', 8, 2)->unsigned(); // Ganancia total del día
            $table->decimal('Efectivo', 8, 2)->unsigned(); // Dinero en efectivo
            $table->decimal('Transferencia', 8, 2)->unsigned(); // Transferencias bancarias
        });

        Schema::create('factura', function (Blueprint $table) {
            $table->unsignedInteger('Nro')->autoIncrement(); // Número de la factura
            $table->binary('Formato_Pago'); // Forma de pago: efectivo (0) o transacción (1)
            $table->dateTime('Fecha'); // Fecha de la venta
            $table->unsignedInteger('CI_Usuario'); // Trabajador que realizó la factura
            $table->unsignedInteger('CI_Cliente')->nullable(); // Cliente que realizó la compra
    
            $table->foreign('CI_Usuario')->references('id')->on('users'); // Relación con USUARIO
            $table->foreign('CI_Cliente')->references('CI')->on('cliente'); // Relación con CLIENTE
        });

        Schema::create('venta', function (Blueprint $table) {
            $table->unsignedInteger('Nro')->autoIncrement(); // Número de venta
            $table->decimal('Total_Pagado', 8, 2)->unsigned(); // Precio total de la venta realizada
            $table->unsignedInteger('Nro_Factura'); // Número de factura
        });

        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->string('Codigo_Producto', 8); // Código del producto
            $table->unsignedInteger('Nro_Venta'); // Número de venta
            $table->unsignedSmallInteger('Cantidad'); // Cantidad del producto vendido
            $table->decimal('Precio_Unidad', 8, 2)->unsigned(); // Precio unidad del producto
        
            $table->primary(['Codigo_Producto', 'Nro_Venta']);
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto');
            $table->foreign('Nro_Venta')->references('Nro')->on('venta');
        });

        Schema::create('promocion_tipo', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->autoIncrement(); // Identificador del tipo de descuento
            $table->string('Descripcion', 500); // Descripción del tipo de promoción
        });

        Schema::create('promocion_producto', function (Blueprint $table) {
            $table->unsignedSmallInteger('ID')->autoIncrement(); // Identificador de la promoción
            $table->string('nombre', 50); // Nombre de la promoción
            $table->string('Descripcion', 500); // Descripción de la promoción
            $table->date('Fecha_Inicio'); // Fecha de inicio de la promoción
            $table->date('Fecha_Final'); // Fecha de finalización de la promoción
            $table->unsignedTinyInteger('Id_Promocion_Tipo'); // Número de la promoción que se está haciendo
            $table->foreign('Id_Promocion_Tipo')->references('id')->on('promocion_tipo');
        });

        Schema::create('promocion_sin_descuento', function (Blueprint $table) {
            $table->unsignedSmallInteger('ID_Promocio_Producto'); // Identificador de la promoción
            $table->string('Codigo_Producto', 8); // Identificación del producto
            $table->primary(['ID_Promocio_Producto', 'Codigo_Producto']);
            $table->foreign('ID_Promocio_Producto')->references('ID')->on('promocion_producto');
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto');
        });

        Schema::create('promocion_descuento', function (Blueprint $table) {
            $table->unsignedSmallInteger('ID_Promocio_Producto'); // Identificador de la promoción
            $table->string('Codigo_Producto', 8); // Identificación del producto
            $table->decimal('Descuento', 8, 2)->unsigned(); // Descuento del producto
            $table->primary(['ID_Promocio_Producto', 'Codigo_Producto']);
            $table->foreign('ID_Promocio_Producto')->references('ID')->on('promocion_producto');
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto');
        });

        Schema::create('intercambio', function (Blueprint $table) {
            $table->unsignedSmallInteger('Nro')->autoIncrement(); // Número de Intercambio
            $table->dateTime('Fecha'); // Fecha de Intercambio
            $table->smallInteger('Cantidad'); // Cantidad de productos intercambiados
            $table->string('Motivo', 500); // Motivo del intercambio
            $table->unsignedInteger('CI_Usuario'); // Trabajador que realizó el intercambio
            $table->unsignedInteger('CI_Cliente')->nullable(); // Cliente que realizó el intercambio
            $table->foreign('CI_Usuario')->references('id')->on('users');
            $table->foreign('CI_Cliente')->references('CI')->on('cliente');
        });

        Schema::create('detalle_intercambio', function (Blueprint $table) {
            $table->unsignedSmallInteger('Nro_INTERCAMBIO'); // Número de Intercambio
            $table->string('Codigo_Producto', 8); // Código del producto de intercambio
            $table->primary(['Nro_INTERCAMBIO', 'Codigo_Producto']); // Clave primaria compuesta
            $table->foreign('Nro_INTERCAMBIO')->references('Nro')->on('intercambio')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('Codigo_Producto')->references('Codigo')->on('producto')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accion');
        Schema::dropIfExists('bitacora');
        Schema::dropIfExists('cliente');
        Schema::dropIfExists('editorial');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('libro');
        Schema::dropIfExists('revista');
        Schema::dropIfExists('enciclopedia');
        Schema::dropIfExists('stock');
        Schema::dropIfExists('genero');
        Schema::dropIfExists('genero_producto');
        Schema::dropIfExists('autor');
        Schema::dropIfExists('escribio');
        Schema::dropIfExists('proveedor');
        Schema::dropIfExists('compra');
        Schema::dropIfExists('detalle_de_compra');
        Schema::dropIfExists('ganancia_diaria');
        Schema::dropIfExists('factura');
        Schema::dropIfExists('venta');
        Schema::dropIfExists('detalle_venta');
        Schema::dropIfExists('promocion_tipo');
        Schema::dropIfExists('promocion_producto');
        Schema::dropIfExists('promocion_sin_descuento');
        Schema::dropIfExists('promocion_descuento');
        Schema::dropIfExists('intercambio');
        Schema::dropIfExists('detalle_intercambio');
    }
};
