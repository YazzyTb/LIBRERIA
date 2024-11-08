<?php

namespace App\Http\Controllers\Inventario\Productos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Inventario\Editoriales\EditorialeController;
use App\Http\Controllers\Inventario\Productos\StockController;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\ProductoRequest;
use App\Models\Producto;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function index(){
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 2);
        if(Auth::check()){
            if($role_privilegio){
                $productos=Producto::all();
                $stocks = Stock::all();
                return view('profile.Inventario.productos.producto',compact('productos', 'stocks'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function create(){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                return view("profile.Inventario.productos.createProducto");
            }
            return $this->index();
        }
        return view('auth.login');
    }

    public function edit(string $codigo){   
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                $producto=Producto::where('codigo', $codigo)->first();        
                return view('profile.Inventario.productos.editProducto',compact('producto'));
            }
            return $this->index();
        }
        return view('auth.login');
    }

    public function show(string $codigo){
        $codigo=Producto::where('Codigo', $codigo)->first();
        if(!$codigo){
            return redirect()->back()->with('error', 'Producto no encontrado');  
        }
        return view('profile.Inventario.productos.producto.show',compact('producto'));    
    }

    public function store(ProductoRequest $request){
       $editorial = new EditorialeController;
        $editorial_id = $editorial->createOrFindReturnId($request->editoriale_id);
       //dd($request);
       $producto = Producto::create([
            'codigo' => ($request->codigo),
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'fecha_de_publicacion' => $request->fecha_de_publicacion,
          // 'imagen' => $request->imagen,
            'editoriale_id' => $editorial_id,
        ]); 

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Productos',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $producto->all(), // Convertir a JSON
            'ip_address' => $request->ip(),
        ]);
        
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        $producto_codigo = $request->codigo;
       // dd($producto);
        return app(StockController::class)->create($producto_codigo);
    }


    public function update(ProductoRequest $request, string $codigo){

        $producto = Producto::find($codigo);

        $anterioresDatos = $producto->all(); 

        $producto->update($request->only([
            'nombre',
            'precio',
            'fecha_de_publicacion',
            'imagen',
        ]));
        $producto->codigo =  strtoupper($request->codigo);
        $editorial = new EditorialeController;
        $editorial_id = $editorial->createOrFindReturnId($request->editoriale_id);
        $producto->editoriale_id = $editorial_id;
        $producto->save();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Productos',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $producto->all(),
            'ip_address' => $request->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);
        
        return $this->index();
    }

    public function destroy(string $codigo){
        $producto = Producto::find($codigo);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'roles',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $producto->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);

        app(StockController::class)->destroy($codigo);  

        $producto->delete();
        return $this->index();
    }

    /*
    Forma de llamar este funcion
    ProductoController::assignGeneroToProducto(codigo, [])
    esta funcion une los producto con generos
    */
    public static function assignGeneroToProducto(string $codigo, array $generos_id){
        $producto = Producto::findOrFail(strtoupper($codigo));
        $producto->generos()->sync($generos_id);
    }
}
