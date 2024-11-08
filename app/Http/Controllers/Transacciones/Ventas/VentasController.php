<?php

namespace App\Http\Controllers\Transacciones\Ventas;

use App\Models\Venta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VentasController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla 'bitacora'
        $venta = Venta::all();

        // Retornar la vista 'bitacora.index' y pasarle los datos
        return view('profile.Transacciones.ventas.ventas', compact('venta'));
    }
}
