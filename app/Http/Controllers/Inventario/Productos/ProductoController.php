<?php

namespace App\Http\Controllers\Inventario\Productos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Inventario\Editoriales\EditorialeController;
use App\Http\Controllers\Inventario\Productos\StockController;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\EnciclopediaRequest;
use App\Http\Requests\Productos\LibroRequest;
use App\Http\Requests\Productos\ProductoRequest;
use App\Http\Requests\Productos\RevistaRequest;
use App\Models\Autor;
use App\Models\Enciclopedia;
use App\Models\Genero;
use App\Models\Libro;
use App\Models\Producto;
use App\Models\Revista;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class ProductoController extends Controller
{
    public function index(){
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 2);
        if(Auth::check()){
            if($role_privilegio){
                $productos=Producto::all();
               //$productos = Producto::with('libro.autores')->get();
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
                $generos=Genero::all(); 
                return view("profile.Inventario.productos.createProducto",compact('generos'));
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
                $generos=Genero::all(); 
                switch($producto->producto_tipo){
                    case 'LIBRO':
                        $tipo = Libro::where('producto_codigo', $codigo)->first();
                        break;
                    case 'REVISTA':
                        $tipo = Revista::where('producto_codigo', $codigo)->first();
                        break;
                    default:
                        $tipo = Enciclopedia::where('producto_codigo', $codigo)->first();
                        break;
                }
                return view('profile.Inventario.productos.editProducto',compact('producto','generos', 'tipo'));
            }
            return $this->index();
        }
        return view('auth.login');
    }

    public function show(string $codigo){
        $producto=Producto::where('codigo', $codigo)->first();
        if(!$producto){
            return redirect()->back()->with('error', 'Producto no encontrado');  
        }
        switch($producto->producto_tipo){
            case 'LIBRO':
                $tipo = Libro::where('producto_codigo', $codigo)->first();
                break;
            case 'REVISTA':
                $tipo = Revista::where('producto_codigo', $codigo)->first();
                break;
            default:
                $tipo = Enciclopedia::where('producto_codigo', $codigo)->first();
                break;
        }
        $stock = Stock::where('producto_codigo', $codigo)->first();
        return view('profile.Inventario.productos.show',compact('producto', 'tipo', 'stock'));    
    }

    public function store(ProductoRequest $request){
        
        $editorial = new EditorialeController;
        $editorial_id = $editorial->createOrFindReturnId($request->editoriale_id);
       
        switch ($request->producto_tipo){
            case "1":
                $tipo = 'LIBRO';
                break;
            case "2":
                $tipo = 'REVISTA';
                break;
            default:
                $tipo = 'ENCICLOPEDIA';
                break;
        }
        $producto = Producto::create([
            'codigo' =>strtoupper($request->codigo),
            'nombre' =>strtoupper($request->nombre),
            'precio' =>$request->precio,
            'fecha_de_publicacion'=>$request->fecha_de_publicacion,
            'editoriale_id'=> $editorial_id,
            'producto_tipo'=>$tipo,
        ]); 

        $this->assignGeneroToProducto($request->codigo, $request->generos);

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
        switch ($producto->producto_tipo){
            case "LIBRO":
                $request_libro = new LibroRequest([
                    'producto_codigo' => $request->codigo,
                    'edicion' => $request->edicion_libro,
                    'tipo_de_tapa' => $request->tipo_de_tapa,
                    'autores_nombre' => array_map('trim', explode(',', $request->input('autores'))),
                ]);
                return app(LibroController::class)->store($request_libro);
            case "REVISTA":
                $request_revista = new RevistaRequest([
                    'producto_codigo' => $request->codigo,
                    'nro' => $request->nro,
                ]);
                return app(RevistaController::class)->store($request_revista);
            default:
                $request_enciclopedia = new EnciclopediaRequest([
                    'producto_codigo' => $request->codigo,
                    'volumen' => $request->volumen,
                    'edicion' => $request->edicion_enciclopedia,
                ]);
                return app(EnciclopediaController::class)->store($request_enciclopedia);
        }
    }

//Fala alterar esta parte
    public function update(ProductoRequest $request, string $codigo){
        $producto = Producto::find($codigo);

        switch ($request->producto_tipo){
            case "1":
                $tipo = 'LIBRO';
                break;
            case "2":
                $tipo = 'REVISTA';
                break;
            default:
                $tipo = 'ENCICLOPEDIA';
                break;
        }

        $anterioresDatos = $producto->all(); 
        //$producto=Producto::where('Codigo', $codigo)->first();
        $editorial = new EditorialeController;
        $editorial_id=$editorial->createOrFindReturnId(strtoupper($request->editoriale_id));
        $producto->update([
            'codigo' =>strtoupper($request->codigo),
            'nombre' =>strtoupper($request->nombre),
            'precio' =>$request->precio,
            'fecha_de_publicacion'=>$request->fecha_de_publicacion,
            'editoriale_id'=> $editorial_id,
            'producto_tipo'=>$tipo,
        ]);
        $this->assignGeneroToProducto($producto->codigo,$request->generos);

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

        switch ($producto->producto_tipo){
            case "LIBRO":
                $request_libro = new LibroRequest([
                    'producto_codigo' => $producto->codigo,
                    'edicion' => $request->edicion_libro,
                    'tipo_de_tapa' => $request->tipo_de_tapa,
                    'autores_nombre' => array_map('trim', explode(',', $request->input('autores'))),
                ]);
                return app(LibroController::class)->update($request_libro);
            case "REVISTA":
                $request_revista = new RevistaRequest([
                    'producto_codigo' => $producto->codigo,
                    'nro' => $request->nro,
                ]);
                return app(RevistaController::class)->update($request_revista);
            default:
                $request_enciclopedia = new EnciclopediaRequest([
                    'producto_codigo' => $producto->codigo,
                    'volumen' => $request->volumen,
                    'edicion' => $request->edicion_enciclopedia,
                ]);
                return app(EnciclopediaController::class)->update($request_enciclopedia);
        }
    }

    public function destroy(string $codigo){
        $producto=Producto::where('Codigo', $codigo)->first();           

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

        switch ($producto->producto_tipo){
            case "LIBRO":
                app(LibroController::class)->destroy($codigo);
                break;
            case "REVISTA":
                app(RevistaController::class)->destroy($codigo);
                break;
            default:
                app(EnciclopediaController::class)->destroy($codigo);
                break;
        }
        app(StockController::class)->destroy($codigo);  

        $producto->delete();
        return $this->index();
    }

    /*
    Forma de llamar este funcion
    ProductoController::assignGeneroToProducto(codigo, [])
    esta funcion une los producto con generos
    
    public static function assignGeneroToProducto(string $codigo, array $generos_id){
        $producto = Producto::findOrFail(strtoupper($codigo));
        $producto->generos()->sync($generos_id);
    }*/

    public static function assignGeneroToProducto(string $codigo, array $generos_id) {
        $producto = Producto::findOrFail($codigo);
        $producto->generos()->sync($generos_id); // Sincroniza la relación con los géneros seleccionados
    }
    public static function precioDeUnProducto(string $codigo){
        $producto = Producto::find($codigo);
        return $producto->precio;
    }
    
}
