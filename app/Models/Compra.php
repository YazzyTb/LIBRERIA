<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';
    protected $p;
    public $timestamps = false;
    protected $primaryKey='nro';
    protected $fillable = [
        'nro',
        'monto_total',
        'fecha',
        'user_id',
        'proveedore_id',
    ];
    public function users(){
     return $this->belongsTo(User::class, 'user_id');
    }
    public function proveedore(){
     return $this->belongsTo(Proveedor::class, 'proveedore_id');
    }
    public function productos(){
     //relacion de muchos a muchos
     return $this->belongsToMany(Producto::class, 'producto_compra','compra_nro','producto_codigo')
     ->withPivot('cantidad', 'precio_unitario'); // Especifica los campos de la tabla pivote   
    } 
}
