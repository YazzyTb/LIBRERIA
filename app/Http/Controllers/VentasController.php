<?php

namespace App\Http\Controllers;

use App\Models\Venta;

use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla 'bitacora'
        $venta = Venta::all();

        // Retornar la vista 'bitacora.index' y pasarle los datos
        return view('profile.ventas.ventas', compact('venta'));
    }
}
