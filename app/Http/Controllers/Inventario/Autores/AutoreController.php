<?php

namespace App\Http\Controllers\Inventario\Autores;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Inventario\Productos\StockController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Productos\AutoreRequest;
use App\Models\Autor;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoreController extends Controller
{
    public function edit(int $id){
        $role_id = Auth::user()->role_id;
        $role_privilegio = Role::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                $autor=Autor::find($id);
                return view('profile.editorial.AutorEdit',compact('autor'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }
    public function store(AutoreRequest $request){
        Autor::create([
            'nombre' => strtoupper($request->nombre)
        ]);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Autor',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $request->all(), // Convertir a JSON
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);
    }

    public function create($producto_codigo){
        return app(StockController::class)->create($producto_codigo);
    }

    public function createOrFindReturnId($nombre){
        $autor = Autor::where('nombre',$nombre)->first();
        if($autor == null){
            $autor = new AutoreRequest([
                'nombre' => $nombre,
            ]);
            $this->store($autor);
            return Autor::where('nombre', $nombre)->first()->id;
        }
        return $autor->id;
    }

    public function staticarrayNombresToIds(array $nombres){
        $ids = array();
        foreach($nombres as $nombre){
            $ids[] = Autor::where('nombre', $nombre)-> first()->id;
        }
        return $ids;
    }
}
