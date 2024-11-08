<?php

namespace App\Http\Controllers\Transacciones\Pagos;

use App\Models\Reportep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ReporteController extends Controller
{
    public function index()
    {
        //$ganancia_diaria = Reportep::all(); // Asume que tienes un modelo Bitacora
        return view('profile.Transacciones.pagos.reporte');//, compact('ganancia_diaria'));
        
    }
}
