<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revista extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'revistas';
    protected $primaryKey = 'producto_codigo';
    protected $keyType = 'string';
    protected $fillable = [
        'producto_codigo',
        'nro',
    ];
    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_codigo','codigo');
    }  
}
