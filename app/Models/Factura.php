<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'nro';
    public $timestamps = false;
    protected $fillable=[
        'nro',
        //'formato_pago',
        'fecha',
        'cliente_ci',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_ci');
    }
    public function venta(){
        return $this->belongsTo(Venta::class);
    }
}
