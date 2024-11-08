<?php

namespace App\Http\Controllers\Acciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acciones\AccioneRequest;
use App\Models\Accione;
use Illuminate\Http\Request;

class AccioneController extends Controller
{
    public function store(AccioneRequest $request){
        Accione::create([
            'operacion' => $request->operacion,
            'descripcion' => $request->descripcion,
        ]);
    }
}
