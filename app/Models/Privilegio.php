<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilegio extends Model
{
    use HasFactory;
    protected $table = 'privilegios';

    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_privilegio');
    }
}
