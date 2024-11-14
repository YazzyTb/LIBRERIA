<?php

namespace App\Http\Controllers\Transacciones\Pagos;

use App\Models\Reportep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Venta_Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 1);
        if(Auth::check()){
            if($role_privilegio){
                $productos = Producto::all('codigo', 'nombre');
                $ganancia = array();
                $inversion = array();
                foreach($productos as $producto){
                    $venta_gancia_de_un_producto = 0;
                    $compra_inversion_de_un_producto = 0;
                    $ventas = Venta_Producto::where('producto_codigo', $producto->codigo)->get();
                    if($ventas->isNotEmpty()){
                        foreach($ventas as $venta){
                            $venta_gancia_de_un_producto = $venta_gancia_de_un_producto + $venta->cantidad * $venta->precio_unitario;
                        }
                    }
                    $compras = DB::table('producto_compra')->where('producto_codigo', $producto->codigo)->get();
                    if($compras->isNotEmpty()){
                        foreach($compras as $compra){
                           $compra_inversion_de_un_producto = $compra_inversion_de_un_producto + $compra->cantidad * $compra->precio_unitario;
                        }
                    }
                    $ganancia[] = $venta_gancia_de_un_producto;
                    $inversion[] = $compra_inversion_de_un_producto;
                }
                return view('profile.Transacciones.Pagos.reportePagos', compact('productos', 'ganancia', 'inversion'));
            }
            return view('dashboard');
        }
        return view('auth.login');
    }
}
