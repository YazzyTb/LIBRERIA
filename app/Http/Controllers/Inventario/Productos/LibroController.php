<?php

namespace App\Http\Controllers\Inventario\Productos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Inventario\Autores\AutoreController;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\LibroRequest;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{
    public function create($producto_codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                return view("profile.Inventario.productos.createLibro",compact('producto_codigo'));
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
                    $libro = Libro::where('producto_codigo', $codigo)->first();        
                if ($libro) {
                    return view('profile.Inventario.productos.editLibro', compact('libro'));
                } else {
                    return redirect()->back()->with('error', 'Stock no encontrado.');
                }
            }
            return app(ProductoController::class)->index();
        }
        return view('auth.login');
    }

    public function store(LibroRequest $request){
        $libro = Libro::create([
            'producto_codigo' => strtoupper($request->producto_codigo),
            'edicion' => $request->edicion,
            'tipo_de_tapa' =>$request->tipo_de_tapa,
        ]);

        $this->assignAutoresToLibro(strtoupper($request->producto_codigo),$request->autores_nombre);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Libro',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $libro->all(), // Convertir a JSON
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        return app(StockController::class)->create($request->producto_codigo);
    }

    public function update(LibroRequest $request){
        $producto_libro = Libro::find($request->producto_codigo);

        $anterioresDatos = $producto_libro->all();     
        $producto_libro->update($request->only([
            'edicion',
            'tipo_de_tapa',
        ]));
        $this->assignAutoresToLibro(strtoupper($request->producto_codigo),$request->autores_nombre);
        $producto_libro->save();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Libro',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $producto_libro->all(),
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);
        
        return app(StockController::class)->create($request->producto_codigo); 
    }

    public function destroy(string $producto_codigo){
        $producto_Libro = Libro::find(strtoupper($producto_codigo));
        $producto_Libro->delete();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Libro',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $producto_Libro->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);

        return ;       
    }


    public static function assignAutoresToLibro(string $producto_codigo, array $autores_nombre){
        $libro = Libro::findOrFail(strtoupper($producto_codigo));
        $autores_ids = array();
        foreach($autores_nombre as $autor_nombre){
            $controller = new AutoreController();
            $autores_ids[] = $controller->createOrFindReturnId(strtoupper($autor_nombre));
        }
        $libro->Autores()->sync($autores_ids);
    }
}
