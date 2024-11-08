<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'users'; // Nombre de tu tabla
    //public $timestamps = false; // Si tu tabla no tiene created_at o updated_at
}