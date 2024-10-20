<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bitacora; // Asegúrate de tener un modelo para la tabla bitacora

class BitacoraController extends Controller
{
    public function index()
    {
        $bitacora = Bitacora::all(); // Asume que tienes un modelo Bitacora
        return view('profile.bitacora.bitacora', compact('bitacora'));
    }
    
}
