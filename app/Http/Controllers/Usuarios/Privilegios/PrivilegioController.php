<?php

namespace App\Http\Controllers\Usuarios\Privilegios;

use App\Http\Controllers\Controller;
use App\Http\Requests\Privilegios\PrivilegioRequest;
use App\Models\Privilegio;
use Illuminate\Http\Request;

class PrivilegioController extends Controller
{
    public function store(PrivilegioRequest $request)
    {
        Privilegio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
    }

    
}
