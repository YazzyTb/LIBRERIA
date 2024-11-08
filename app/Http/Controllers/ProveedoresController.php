<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;


class ProveedoresController extends Controller
{
    public function index()
    {
        $proveedor = Proveedor::all(); // Asume que tienes un modelo Bitacora
        return view('profile.proveedores.proveedores', compact('proveedor'));
        
    }
}
