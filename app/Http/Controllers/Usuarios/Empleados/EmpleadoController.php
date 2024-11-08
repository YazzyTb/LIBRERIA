<?php

namespace App\Http\Controllers\Usuarios\Empleados;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Empleados\EmpleadoRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
/*
    NOTA: Se trabajara usuarios como si fuera empleados 
*/


class EmpleadoController extends Controller
{
    /*
    Te permite lleva a la pagina para visualizar los empleados(users) existentes en la bd
    para eso es necesario estar autetificado y tener el privilegio NRO 8
    */
    public function index(){
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 8);
        if(Auth::check()){
            if($role_privilegio){
                $empleados = User::all();
                return view('profile.Usuarios.empleados.empleado', compact('empleados'));
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    /*
    Funcion que te lleva a una pagina para crear un uevo empleado(user) debes ser usuario 
    autenticado y el privilegio de crear un empeleado(user)
    */
    public function create(){
        $role_id = Auth::user()->role_id;
        $role = roleController::hasPrivilegio($role_id,8);
        if(Auth::check()){
            if($role){
                $roles = Role::all();
                return view('profile.Usuarios.empleados.formEmpleado', compact('roles'));
            }
            return $this->index();
        }
        return view('auth.login');
    }

    /*
    Funcion que te lleva a un formulario para poder hacer un update de los datos existentes 
    a un empleado(user) se necesita el id del usuario o sea su CI
    */
    public function edit(int $users){
        $role_id = Auth::user()->role_id;
        $role = roleController::hasPrivilegio($role_id,8);
        if(Auth::check()){
            if($role){
                $empleado = User::findOrFail($users);   
                $roles = Role::all();
                return view('profile.Usuarios.empleados.empleadoEdit',compact('empleado','roles'));// va a  una vista para editar  
            }
            return $this->index();
        }
        return view('auth.login');
        
    }
    public function show(int $users){  // para devolver un usuario buscado por CI
        $users=User::find($users);
        if(!$users){
            return redirect()->back()->with('error', 'Usuario no encontrado');  
        }
        return view('usuarios.show',compact('cliente'));  
        //esto redirecciona a una vista para ver el cliente correspondiente al 
        // CI que recibio de parametro  
    }

    /*
    Crea un nuevo usuario estrae los datos colocado en el formulario que los campos son los siguientes
    id (int) -> es la CI del nuevo empleado debe ser unico en la bd
    name (str)-> nombre del nuevo empleado
    email (str)-> el Email del nuevo empleado debe ser unico en la bd
    password (str)-> la contraseñas del nuevo usuario que se esta creado va a estar encriptada en la bd
    role (str)-> role que desempeñara el nuevo empleado ese rol debe existir en la bd
    */

    public function store(Request $request): RedirectResponse
    {
        
        $request->validate([
            'id' => ['required', 'numeric', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\password::defaults()],
            'role_id' => ['required', 'string', 'exists:roles,nombre']
        ]);
        //dd($request);

        $role = new roleController();
        $role_id = $role->getRoleId($request->role_id);

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'users',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => null,
            'datos_nuevos' => $request->all(), // Convertir a JSON
            'ip_address' => $request->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeInsert($bitacoraRequest);
        

        /*hacer una funcion que dado un nombre de un rol me devuelva el id conectar rolecontroller*/
        
        User::create([
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role_id,
        ]);
        
        //event(new Registered($user));

        

        return redirect()->route('empleados.index')->with('status', 'Usuario creado exitosamente.');
    }
    /*
    Acutualiza los datos en un Empleado(user) existente exepto su id ysu contraseña se envia
    id_anterior -> el id del usuario que se quiere realizar los cambios
    name -> nombre que por el que se quiere actualizar
    email -> email por el que se quiere actualizar
    role_id-> es el nombre del rol por el que se quiere actualizar
    */
    public function update(EmpleadoRequest $request): RedirectResponse{
        $user_id = $request->input('id_anterior');
        $user = User::where('id', $user_id)->first();

        $anterioresDatos = $user->only(['id', 'name','email', 'role_id']);

        $role = new RoleController();
        $role_id = $role->getRoleId($request->role_id);

        $user->fill($request->only(['id','name','email']));
        $user->role_id = $role_id;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user->save();

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'users',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' => $anterioresDatos,
            'datos_nuevos' => $request->only(['id', 'name','email', 'role_id']),
            'ip_address' => $request->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeUpdate($bitacoraRequest);

        return redirect()->route('empleados')->with('status', 'Usuario creado exitosamente.');
    }
    /*
    Elmina al Empleado existente 
    */ 

    public function destroy($user_id){
        // Buscar el usuario a eliminar
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'users',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $user->all(),
            'datos_nuevos' =>null,
            'ip_address' => $user_id->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeDelete($bitacoraRequest); 
        
 
        // Eliminar al usuario
        $user->delete();

        return redirect()->route('empleados')->with('status', 'Usuario eliminado exitosamente.');
    }
}
