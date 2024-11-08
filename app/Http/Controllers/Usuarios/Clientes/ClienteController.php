<?php

namespace App\Http\Controllers\Usuarios\Clientes;


use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Http\Requests\Clientes\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /*
    Esta funcion es para entrar al listado de los Clientes existentes en la base de datos se.
    necesita del privilegio Nro 4 para ver la lista y esta autenticado para eso
    */
    public function index(){
        $role_id = Auth::user()->role_id;
        $role = RoleController::hasPrivilegio($role_id, 4);
        if(Auth::check()){
            if($role){
                $clientes = Cliente::all(); // Asume que tienes un modelo Bitacora
                return view('profile.Usuarios.clientes.cliente', compact('clientes'));
            }
            return redirect('dashboard');
        }
        return redirect('auth.login');
        
        
    }
    // Mostrar el formulario de registro de clientes
    public function create(){
        $role_id = Auth::user()->role_id;
        $role = roleController::hasPrivilegio($role_id, 5);
        if(Auth::check()){
            if($role){
                return view('profile.Usuarios.clientes.FormCliente');
                //resources\views\profile\clientes\FormCliente.blade.php
            }
            $this->index();
        }
        return redirect('auth.login');
    }

    /*
    Te lleva a un formulario donde puedes hacer update a un cliente ya existente en la bd
    */
    public function edit(int $cliente){
        $role_id = Auth::user()->role_id;
        $role = roleController::hasPrivilegio($role_id, 5);
        if(Auth::check()){
            if($role){
                $cliente=Cliente::find($cliente);    
                return view('profile.Usuarios.clientes.clienteEdit',compact('cliente'));// va a  una vista para editar
            }
            return $this->index();
        }
        return redirect('auth.login');
         
    }
 // Guardar el nuevo cliente en la base de datos
    public function store(Request $request){
     // Validar los datos
        $request->validate([
            'ci' => 'required|int', 
            'nombre' => 'required|string|max:50',
            'puntos' => 'required|int|max:100',
        ]);

     // Crear un nuevo cliente de forma masiva
    Cliente::create($request->all());

    $bitacoraRequest = new BitacoraRequest([
        'tabla_afectada' => 'Clientes',
        'user_id' => Auth::id(),
        'fecha_hora' => date('Y-m-d H:i:s'),
        'datos_anteriores' => null,
        'datos_nuevos' => $request->all(),
        'ip_address' => $request->ip(),
    ]);

    $bitacoraController = new BitacoraController();

    // Llama al método del BitacoraController
    $bitacoraController->storeInsert($bitacoraRequest);
     // Redirigir a la tabla de clientes
    return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
     //redirect('/clientes')->with('success', 'Cliente registrado correctamente.');
    }

    public function show(int $cliente){  // para devolver un usuario buscado por CI
        $cliente=Cliente::find($cliente);
        if(!$cliente){
            return redirect()->back()->with('error', 'Cliente no encontrado');  
        }
        return view('cliente.show',compact('cliente'));  
//esto redirecciona a una vista para ver el cliente correspondiente al 
// CI que recibio de parametro  
    }

    public function update(ClienteRequest $request,int $cliente){
        $clienteUpdate =Cliente::find($cliente); 
        $anterioresDatos = $clienteUpdate->all();  
        $clienteUpdate->update($request->all());
        $clienteUpdate->save();
        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Clientes',
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

    public function destroy(int $cliente){
        $cliente=Cliente::find($cliente);   
        $bitacoraRequest = new BitacoraRequest([
            'tabla_afectada' => 'Clientes',
            'user_id' => Auth::id(),
            'fecha_hora' => date('Y-m-d H:i:s'),
            'datos_anteriores' =>  $cliente->all(),
            'datos_nuevos' =>null,
            'ip_address' => request()->ip(),
        ]);

        $bitacoraController = new BitacoraController();
    
        // Llama al método del BitacoraController
        $bitacoraController->storeDelete($bitacoraRequest);
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');     
    }
}
