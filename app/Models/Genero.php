<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_genero', 'genero_id', 'producto_codigo');
    }
}
