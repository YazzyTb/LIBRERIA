<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accione extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
       'operacion',
       'descripcion'
    ];

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'accione_id');
    }
}
