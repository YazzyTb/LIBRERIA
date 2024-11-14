<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'nro';
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'nro',
        'monto_total',
        'factura_nro',
    ];
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
    public function venta_Producto()
    {
        return $this->hasOne(Venta_Producto::class);
    }
}
