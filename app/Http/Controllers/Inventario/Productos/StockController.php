<?php

namespace App\Http\Controllers\Inventario\Productos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\StockRequest;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function create($producto_codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                // Aqui deberia llevarme a un formulario para rellenar
                return view("profile.Inventario.productos.createStock",compact('producto_codigo'));
            }
            return app(ProductoController::class)->index();
        }
        return view('auth.login');
    }
/*
    public function edit(string $codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                $producto=Stock::where('producto_codigo', $codigo)->first();        
                
                // Crear un editForm para realizar los update de Stock 
                
                return view('profile.productos.editStock',compact('producto'));
            }
            return $this->index();
        }
        return view('auth.login');
    }
*/
public function edit(string $codigo)
{   
    $role_id = Auth::user()->role_id;
    $role_privilegio = RoleController::hasPrivilegio($role_id, privilegio_id: 3);
    if(Auth::check()) {
        if($role_privilegio) {
            $stock = Stock::where('producto_codigo', $codigo)->first();        
            if ($stock) {
                return view('profile.Inventario.productos.editStock', compact('stock'));
            } else {
                return redirect()->back()->with('error', 'Stock no encontrado.');
            }
        }
        return app(ProductoController::class)->index();
    }
    return view('auth.login');
}



    public function store(StockRequest $request){
        $stock = Stock::create([
            'producto_codigo' => strtoupper($request->producto_codigo),
            'cantidad' => $request->cantidad,
            'max_stock' => $request->max_stock,
            'min_stock'=> $request->min_stock,
        ]);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Stocks',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $stock->all(), // Convertir a JSON
            'ip_address' => $request->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        return app(ProductoController::class)->index();
    }

    public function update(StockRequest $request){
        $producto_stock = Stock::find($request->producto_codigo);

        $anterioresDatos = $producto_stock->all();     
        $producto_stock->update($request->only([
            'cantidad',
            'max_stock',
            'min_stock',
        ]));
        $producto_stock->producto_codigo =  strtoupper($request->producto_codigo);
        $producto_stock->save();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Stocks',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $producto_stock->all(),
            'ip_address' => $request->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);
        
        return redirect()->route('producto.index')->with('success', 'producto creado exitosamente');    
    }

    public function destroy(string $producto_codigo){
        $producto_stock = Stock::find($producto_codigo);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Stocks',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $producto_stock->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);

        $producto_stock->delete();
        return app(ProductoController::class)->index();       
    }
}
