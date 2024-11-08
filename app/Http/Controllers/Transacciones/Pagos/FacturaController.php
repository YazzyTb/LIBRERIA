<?php

namespace App\Http\Controllers\Transacciones\Pagos;

use App\Models\Factura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacturaController extends Controller
{
    public function index()
    {
       // $factura = Factura::all(); // Asume que tienes un modelo Bitacora
        return view('profile.Transacciones.pagos.facturas');//, compact('factura'));
        
    }
}
