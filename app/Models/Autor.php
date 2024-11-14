<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    protected $table = 'autores';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre',
    ];

    public function libros()
    {
        return $this->belongsToMany(Libro::class, 'libro_autore', 'autore_id', 'producto_codigo');
    }
}
