<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'productos';
    protected $primaryKey = 'codigo';
    protected $keyType = 'string';
    protected $fillable = [
        'codigo',
        'nombre',
        'precio',
        'fecha_de_publicacion',
        //'imagen',
        'editoriale_id',
    ];
    public function editorial()
    {
        return $this->belongsTo(Editoriale::class, 'editoriale_id');
    }

    public function stocks()
    {
        return $this->hasOne(Stock::class, 'producto_codigo', 'codigo');
    }

    public function libros()
    {
        return $this->hasOne(Libro::class, 'producto_codigo', 'codigo');
    }
    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'producto_genero', 'producto_codigo', 'genero_id');
    }
}
