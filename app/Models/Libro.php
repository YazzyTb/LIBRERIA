<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';
    protected $primaryKey = 'producto_codigo';
    protected $keyType = 'string';
    protected $fillable = [
        'producto_codigo',
        'edicion',
        'tipo_de_tapa',
    ];
    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_codigo','codigo');
    }
}
