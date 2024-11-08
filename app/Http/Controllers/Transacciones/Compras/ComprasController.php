<?php

namespace App\Http\Controllers\Transacciones\Compras;

use App\Models\Compra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComprasController extends Controller
{
    public function index()
    {
        $compra = Compra::all(); // Asume que tienes un modelo Compra
        return view('profile.Transacciones.compras.compras', compact('compra'));
    }
}
