<?php

namespace App\Http\Controllers\Transacciones\Proveedores;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProveedoresController extends Controller
{
    public function index()
    {
        $proveedor = Proveedor::all(); // Asume que tienes un modelo Bitacora
        return view('profile.Transacciones.proveedores.proveedores', compact('proveedor'));
        
    }
}
