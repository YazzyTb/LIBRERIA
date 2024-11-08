<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $factura = Factura::all(); // Asume que tienes un modelo Bitacora
        return view('profile.pagos.facturas', compact('factura'));
        
    }
}
