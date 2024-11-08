<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    public function index()
    {
        $compra = Compra::all(); // Asume que tienes un modelo Bitacora
        return view('profile.compras.compras', compact('compra'));
        
    }
}
