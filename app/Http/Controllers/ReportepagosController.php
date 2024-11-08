<?php

namespace App\Http\Controllers;

use App\Models\Reportep;
use Illuminate\Http\Request;


class ReportepagosController extends Controller
{
    public function index()
    {
        $ganancia_diaria = Reportep::all(); // Asume que tienes un modelo Bitacora
        return view('profile.pagos.reportePagos', compact('ganancia_diaria'));
        
    }
}
