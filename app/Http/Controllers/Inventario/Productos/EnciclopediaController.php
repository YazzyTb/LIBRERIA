<?php

namespace App\Http\Controllers\Inventario\Productos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\EnciclopediaRequest;
use App\Models\Enciclopedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnciclopediaController extends Controller
{
    public function create($producto_codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                return view("profile.Inventario.productos.createEnciclopedia",compact('producto_codigo'));
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
                    $enciclopedia = Enciclopedia::where('producto_codigo', $codigo)->first();        
                if ($enciclopedia) {
                    return view('profile.Inventario.productos.editEnciclopedia', compact('enciclopedia'));
                } else {
                    return redirect()->back()->with('error', 'Enciclopedia no encontrado.');
                }
            }
            return app(ProductoController::class)->index();
        }
        return view('auth.login');
    }

    public function store(EnciclopediaRequest $request){
        $enciclopedia = Enciclopedia::create([
            'producto_codigo' => strtoupper($request->producto_codigo),
            'volumen' => $request->volumen,
            'edicion' => $request->edicion,
        ]);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Enciclopedia',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $enciclopedia->all(), // Convertir a JSON
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        return app(StockController::class)->create($request->producto_codigo);
    }

    public function update(EnciclopediaRequest $request){
        $producto_enciclopedia = Enciclopedia::find($request->producto_codigo);

        $anterioresDatos = $producto_enciclopedia->all();     
        $producto_enciclopedia->update($request->only([
            'volumen',
            'edicion',
        ]));
        $producto_enciclopedia->save();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Enciclopedia',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $producto_enciclopedia->all(),
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);
        
        return app(StockController::class)->create($request->producto_codigo); 
    }

    public function destroy(string $producto_codigo){
        $producto_enciclopedia = Enciclopedia::find(strtoupper($producto_codigo));
        $producto_enciclopedia->delete();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Enciclopedia',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $producto_enciclopedia->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);

        return;       
    }
}
