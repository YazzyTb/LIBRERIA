<?php

namespace App\Http\Controllers\Usuarios\Roles;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Roles\RoleRequest;
use App\Models\Privilegio;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /*
    Esta funcion es para entrar al listado de los roles existentes en la base de datos se.
    necesita del privilegio Nro 9 que es roles y esta autenticado para eso
    */
    public function index(){
        $role_id = Auth::user()->role_id;
        $role_privilegio = $this::hasPrivilegio($role_id,privilegio_id: 9);
        if(Auth::check()){
            if($role_privilegio){
                $rol = Role::all();
                return view('profile..Usuarios.roles.roles', compact('rol'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }
    /*
    esta funcion te lleva a otra paginna que te deja ver el formulario para crear un nuevo rol
    se necesita estar autetificado y tener el privilegio nro 9 para eso
    

    public function create(){
        $role_id = Auth::user()->role_id;
        $role = $this::hasPrivilegio($role_id,9);
        if($role){
            return view('profile.roles.createRol');
        }
        return view('dashboard');
    }*/
    public function create() {
        $role_id = Auth::user()->role_id;
        $hasPrivilegio = $this::hasPrivilegio($role_id, 9);
    
        if ($hasPrivilegio) {
            // Obtiene todos los privilegios y los pasa a la vista
            $privilegios = Privilegio::all();
            return view('profile.Usuarios.roles.createRol', compact('privilegios'));
        }
    
        return redirect()->route('dashboard');
    }


    public function allroles(){
        $roles = Role::all();
        return compact('roles');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

     /* 
    Esta funcion crea un nuevo rol de los datos que se llenaron en el formulario 
    tiene los siguientes parametros el $request
    'nombre' -> str, max:50, unico, transforma de minuscula a mayuscula
    'descripcion' -> str max:500 
    'privilegios' -> array, debe tener los ids de los privilegios ya existentes en la bd
     */
    public function store(RoleRequest $request){
        $role = Role::create([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => $request->descripcion,
        ]);

        
        $privilegios = $request->input('privilegios', []);
        $this->assignPrivilegiosToRole($role->id, $privilegios);

        
        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'roles',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $request->all(), // Convertir a JSON
            'ip_address' => $request->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeInsert($bitacoraRequest);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }

    /*
       muestra un rol en especifico con el nombre de dicho rol
    */
    public function showARole($nombre){
        $id = self::getRoleId($nombre);
        $role = Role::findOrFail($id);
        return view('role.show', compact('role'));
    }
    /*
    te permite entrar a un formulario para hacer update a un rol ta existente
    
    public function edit($id){
        $role_id = Auth::user()->role_id;
        $role_privilegio = $this::hasPrivilegio($role_id,9);
        if(Auth::check()){
            if($role_privilegio){
                $role = Role::findOrFail($id);
                return view('profile.roles.rolEdit', compact('role'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
        
    }*/
    public function edit($id) {
        $role_id = Auth::user()->role_id;
        $role_privilegio = $this::hasPrivilegio($role_id, 9);
        
        if (Auth::check()) {
            if ($role_privilegio) {
                $role = Role::with('privilegios')->findOrFail($id); // Cargar el rol con sus privilegios
                $privilegios = Privilegio::all(); // Cargar todos los privilegios disponibles
                
                return view('profile.Usuarios.roles.rolEdit', compact('role', 'privilegios'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }
    
    /* 
    Actualiza los datos de un rol ya existentes se debe de mandar
    'nombre' -> str, max:50, unico, transforma de minuscula a mayuscula
    'descripcion' -> str max:500 
    'privilegios' -> array, debe tener los ids de los privilegios ya existentes en la bd
    */
    public function update(RoleRequest $request, $id){
        //$id = self::getRoleId($nombre);
        $role = Role::findOrFail($id);
        $anterioresDatos = $role->all();
        $role->update([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => $request->descripcion,
        ]);

        $privilegios = $request->input('privilegios', []);
        $this->assignPrivilegiosToRole($role->id, $privilegios);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'roles',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $request->all(),
            'ip_address' => $request->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeUpdate($bitacoraRequest);

        return $this->index();
    } 

    /*
    Elimina un rol ya existe en la bd se debe mandar el id del rol a elimiart
    */
    public function destroy($id)
    {
        //$id = self::getRoleId($nombre);
        $role = Role::findOrFail($id);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'roles',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $role->all(),
            'datos_nuevos' =>null,
           // 'ip_address' => $id->ip(),
           'ip_address' => request()->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeDelete($bitacoraRequest);
        
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }

    // Aigna los privilegios a un rol se guarda en la tabla role_privilegio
    public function assignPrivilegiosToRole($roleId, array $privilegiosId){
        $role = Role::findOrFail($roleId);
        $role->privilegios()->sync($privilegiosId);
    }

    public function getRoleId($nombre){
        $roleId = Role::where('nombre', strtoupper($nombre))->first();

        return $roleId ? $roleId->id : null;
    }

    /*
    Retorna solo los nombres de los privilegios asociados al rol
    devuelve un array
    */
    public function optionsrole($role_id)
    {
        $role = Role::find($role_id);
        return $role->privilegios->pluck('nombre')->toArray();
    }

    // vereficar si un rol tiene un privilegio
    public static function hasPrivilegio($role_id, $privilegio_id){
        $role = Role::find($role_id);

        return $role->privilegios->contains($privilegio_id);
    }
}
