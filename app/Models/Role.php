<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }

    public function privilegios(){
        return $this->belongsToMany(Privilegio::class, 'role_privilegio');
    }
}
