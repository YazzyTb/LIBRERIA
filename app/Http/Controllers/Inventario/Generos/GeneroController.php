<?php

namespace App\Http\Controllers\Inventario\Generos;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Generos\GeneroRequest;
use App\Models\Genero;

use Illuminate\Support\Facades\Auth;

class GeneroController extends Controller
{
    public function index(){
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 2);
        if(Auth::check()){
            if($role_privilegio){
                $generos=Genero::all();
                return view('profile.Inventario.productos.producto',compact('generos'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function create(){
        $role_id = Auth::user()->role_id;
        $role = RoleController::hasPrivilegio($role_id,2);
        if($role){
            return view('profile.Inventario.productos.createProducto');
        }
        return view('dashboard');
    }
    public function store(GeneroRequest $request){
        $genero = Genero::create([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => $request->descripcion,
        ]);
        
        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Generos',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $genero->all(), // Convertir a JSON
            'ip_address' => $request->ip(),
        ]);

        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        return $this->index();
    }

    public function showAGenero($nombre){
        $id = self::getGeneroId($nombre);
        $role = Genero::findOrFail($id);
        $genero = $this->getGeneroId($nombre);
        if(!$genero){
         return redirect()->back()->with('error', 'revista no encontrada');
        }
        return view('genero.show', compact('Genero'));
    }

    public function edit($id){
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,9);
        if(Auth::check()){
            if($role_privilegio){
                $genero = Genero::findOrFail($id);
                return view('profile.Inventario.productos.editProducto',compact('genero'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
        
    }
    public function update(GeneroRequest $request, $id){
        $genero = Genero::findOrFail($id);
        $anterioresDatos = $genero->all();
        $genero->update([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => $request->descripcion,
        ]);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Generos',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $genero->all(),
            'ip_address' => $request->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);

        return $this->index();
    } 

    public function destroy($id)
    {
        $genero = Genero::findOrFail($id);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Generos',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $genero->all(),
            'datos_nuevos' =>null,
            'ip_address' => $id->ip(),
        ]);
        $bitacoraController = new BitacoraController();    
        $bitacoraController->storeDelete($bitacoraRequest);
        
        $genero->delete();
        return $this->index();
    }
    public function getGeneroId($nombre){
        $roleId = Genero::where('nombre', strtoupper($nombre))->first();
        return $roleId ? $roleId->id : null;
    }

    public static function allGeneros(){
        return Genero::all();
    }
}
