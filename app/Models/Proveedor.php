<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $fillable = ['nombre','persona_de_contacto','telefono_de_contacto']; 
    public $timestamps = false;
    public function compras()
    {
     return $this->hasMany(Compra::class, 'proveedore_id');
    }
}
