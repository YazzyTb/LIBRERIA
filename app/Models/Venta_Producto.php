<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta_Producto extends Model
{
    use HasFactory;

    protected $table = 'venta_producto';
    
    // Asegúrate de que las claves primarias compuestas se manejen manualmente
    public $incrementing = false;  // Desactivamos la auto-incrementalidad
    protected $primaryKey = ['venta_nro', 'producto_codigo'];

    public $timestamps = false;

    protected $fillable = [
        'venta_nro',
        'producto_codigo',
        'cantidad',
        'precio_unitario', // corregí el nombre de la columna
    ];

    // Cambiar las relaciones a belongsTo
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_nro');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_codigo');
    }

    // Sobrescribir el método getKeyName para las claves primarias compuestas
    public function getKeyName()
    {
        return ['venta_nro', 'producto_codigo'];
    }
}
