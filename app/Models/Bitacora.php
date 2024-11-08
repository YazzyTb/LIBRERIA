<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacoras'; // Nombre de tu tabla
    //public $timestamps = false; // Si tu tabla no tiene created_at o updated_at
    public $timestamps = false;
    
    protected $fillable = [
        'tabla_afectada',
        'accione_id',
        'user_id',
        'fecha_hora',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
    ];

    public function accion(){
        return $this->belongsTo(Accione::class, 'accione_id');
    }

    // Relación con el modelo User
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
