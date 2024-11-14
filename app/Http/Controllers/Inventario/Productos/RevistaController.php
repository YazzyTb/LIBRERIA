<?php

namespace App\Http\Controllers\Inventario\Productos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\RevistaRequest;
use App\Models\Revista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevistaController extends Controller
{
    public function create($producto_codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                return view("profile.Inventario.productos.createRevista",compact('producto_codigo'));
            }
            return app(ProductoController::class)->index();
        }
        return view('auth.login');
    }

    public function edit(string $codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id, privilegio_id: 3);
        if(Auth::check()) {
            if($role_privilegio) {
                    $revista = Revista::where('producto_codigo', $codigo)->first();        
                if ($revista) {
                    return view('profile.Inventario.productos.editRevista', compact('revista'));
                } else {
                    return redirect()->back()->with('error', 'revista no encontrado.');
                }
            }
            return app(ProductoController::class)->index();
        }
        return view('auth.login');
    }

    public function store(RevistaRequest $request){
        $revista = Revista::create([
            'producto_codigo' => strtoupper($request->producto_codigo),
            'nro' => $request->nro,
        ]);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Revista',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $revista->all(), // Convertir a JSON
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        return app(StockController::class)->create($request->producto_codigo);
    }

    public function update(RevistaRequest $request){
        $producto_revista = Revista::find($request->producto_codigo);

        $anterioresDatos = $producto_revista->all();     
        $producto_revista->update($request->only([
            'edicion',
            'nro',
        ]));
        $producto_revista->save();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Revista',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $producto_revista->all(),
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);
        
        return app(StockController::class)->create($request->producto_codigo); 
    }

    public function destroy(string $producto_codigo){
        $producto_revista = Revista::find(strtoupper($producto_codigo));
        

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Revista',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $producto_revista->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);
        $producto_revista->delete();
        return ;     
    }

}
