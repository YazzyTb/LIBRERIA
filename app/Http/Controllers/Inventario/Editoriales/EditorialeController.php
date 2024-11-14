<?php

namespace App\Http\Controllers\Inventario\Editoriales;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Editoriales\EditorialeRequest;
use App\Models\Editoriale;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class EditorialeController extends Controller
{
    public function index(){

        $role_id = Auth::user()->role_id;
        $role_privilegio = Role::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                $editoriales=Editoriale::all();
                return view("profile.editorial.editorial",compact('editoriales'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');

        
    }

    /**
     * Show the form for creating a new resource.
     */
    /*public function create(){
        return view("profile.editorial.FormEditorial");
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id){
        $role_id = Auth::user()->role_id;
        $role_privilegio = Role::hasPrivilegio($role_id,privilegio_id: 3);
        if(Auth::check()){
            if($role_privilegio){
                $editorial=Editoriale::find($id);
                return view('profile.editorial.editorialEdit',compact('editorial'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EditorialeRequest $request){
        Editoriale::create($request->all());

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Editoriales',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $request->all(), // Convertir a JSON
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeInsert($bitacoraRequest);

        return ;
    }
    /**
     * Display the specified resource.
     */
    public function showWhitId(int $id){
        $id=Editoriale::find($id);
        if(!$id){
            return redirect()->back()->with('error', 'Editorial no encontrado');  
        }
        return view('editorial.show',compact('id'));   
    }

    public function showWhitName(string $nombre){
        $id=Editoriale::where('nombre', strtoupper($nombre))->first();
        if(!$id){
            return redirect()->back()->with('error', 'Editorial no encontrado');  
        }
        return view('editorial.show',compact('id'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditorialeRequest $request, int $id){
        
        $Editorial = Editoriale::where('id', $id)->first();
        $anterioresDatos = $Editorial->all();
        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Editoriales',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $request->all(),
            'ip_address' => $request->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeUpdate($bitacoraRequest);
        
        $id=Editoriale::find($id);
        $request->validate([
            'Nombre' => 'required|string|max:50'
        ]);
        $id->update($request->all());
        return redirect()->route('editorial.index')->with('success', 'Editorial modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id){
        $id=Editoriale::find($id);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'roles',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $id->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);

        $id->delete();
        return redirect()->route('editorial.index')->with('success', 'editorial eliminada correctamente.');;
    }

    public function createOrFindReturnId($nombre){
        $editorial = Editoriale::where('nombre', strtoupper($nombre))->first();
        if($editorial == null){
            $editorial = new EditorialeRequest([
                'nombre' => strtoupper($nombre),
            ]);
            $this->store($editorial);
            return Editoriale::where('nombre', strtoupper($nombre))->first()->id;
        }
        return $editorial->id;
    }
}
