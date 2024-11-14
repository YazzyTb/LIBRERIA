<?php

namespace App\Http\Controllers\Transacciones\Ventas;

use App\Http\Controllers\Inventario\Productos\ProductoController;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Transaccion\FacturaRequest;
use App\Http\Requests\Transaccion\VentaRequest;
use App\Models\Venta;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Transacciones\Pagos\FacturaController;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\Venta_Producto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    /*public function index()
    {
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 1);
        if(Auth::check()){
            if($role_privilegio){
                $venta = Venta::all();
                return view('profile.Transacciones.ventas.ventas', compact('venta'));
            }
            return $this->index();
        }
        return view('auth.login');
    }*/

    public function create(){
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 1);
        if(Auth::check()){
            if($role_privilegio){
                $productos = Producto::all();
                $stocks = Stock::all();
                return view("profile.Transacciones.ventas.ventas", compact('productos', 'stocks'));
            }
        }
        return view('auth.login');
    }
    public function store(VentaRequest $request){
        $productos = $request->productos_array;
        $cantidades = $request->cantidad_array;
        $precioUnitarioTotal = $this->PrecioUnitarioYTotal($productos, $cantidades);
        $totalPagado = array_pop($precioUnitarioTotal);
        $requestFactura = new FacturaRequest([
            'cliente_ci'=> $request->cliente_ci,
        ]);
        $factura_nro = FacturaController::store($requestFactura);
        
        $venta = Venta::create([
            'monto_total' => $totalPagado,
            'factura_nro' => $factura_nro,
        ]);
        
        $this->store_Venta_Producto($productos, $cantidades, $precioUnitarioTotal, $venta->nro);
        return redirect()->route('venta.create')->with('status', 'venta creada exitosamente.');
    }
    public function store_Venta_Producto(array $productos, array $cantidades, array $totalUnitario, $venta){
        
        foreach($productos as $index => $codigo){
            $cantidad = $cantidades[$index];
            $stock_producto = Stock::where('producto_codigo', $codigo)->first();
            $cantidad_actualizado = $stock_producto->cantidad - $cantidad;
            if($cantidad_actualizado >= 0){
                $total = $totalUnitario[$index];
                Venta_Producto::create([
                    'venta_nro'=> $venta,
                    'producto_codigo' => $codigo,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $total,
                ]);
            }
        }
        
        return ;
    }

    public function PrecioUnitarioYTotal(array $productos, array $cantidades){
        $precitoUnitarioTotal = array();
        $totalAPagar = 0;
        foreach($productos as $index => $producto){
            $cantidad = $cantidades[$index];
            $stock_producto = Stock::where('producto_codigo', $producto)->first();
            $cantidad_actualizado = $stock_producto->cantidad - $cantidad;
            if($cantidad_actualizado >= 0){
                $precio = ProductoController::precioDeUnProducto($producto);
                $precitoUnitarioTotal[] = $precio * $cantidad;
                $totalAPagar = $precio * $cantidad;

                $stock_producto->update([
                    'cantidad' => $cantidad_actualizado
                ]);
            }else{
                $precitoUnitarioTotal[] = 0;
            }
        }
        $precitoUnitarioTotal[] = $totalAPagar; 
        return $precitoUnitarioTotal;
    }
}
