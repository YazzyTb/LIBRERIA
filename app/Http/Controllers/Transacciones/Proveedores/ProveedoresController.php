<?php

namespace App\Http\Controllers\Transacciones\Proveedores;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
  public function index()
  {
    $role_id = Auth::user()->role_id;
    $role = RoleController::hasPrivilegio($role_id, 6);
    if(Auth::check()){
        if($role){
          $proveedores = Proveedor::all(); // Asume que tienes un modelo Bitacora
          return view('profile.Transacciones.Proveedores.proveedores', compact('proveedores'));
        }
        return redirect('dashboard');
    }
    return redirect('auth.login');
  }

  public function create(){
    $role_id = Auth::user()->role_id;
    $role = RoleController::hasPrivilegio($role_id, 7);
    if(Auth::check()){
        if($role){
          return view('profile.Transacciones.Proveedores.createProveedor'); 
        }
        return $this->index();
    }
    return redirect('auth.login'); 
  }

  public function store(Request $request){
    $request->validate([
      'nombre'=>'required|string|max:50',
      'persona_de_contacto'=>'required|string|max:50',
      'telefono_de_contacto'=>'required|int',
    ]);
    $proveedor = Proveedor::create($request->all());
    $bitacoraRequest = new BitacoraRequest([
      'tabla_afectada' => 'Proveedores',
      'user_id' => Auth::id(),
      'fecha_hora' => date('Y-m-d H:i:s'),
      'datos_anteriores' => null,
      'datos_nuevos' => $proveedor->all(),
      'ip_address' => $request->ip(),
    ]);
    $bitacoraController = new BitacoraController();
    $bitacoraController->storeInsert($bitacoraRequest);
    
    return redirect()->route('proveedor.index')->with('success', 'proveedor registrado correctamente.');  
  }
 
  public function show(int $id){
    $proveedor=Proveedor::find($id);
    if(!$proveedor){
       return redirect()->back()->with('error', 'proveedor no encontrado');  
    }
       return view('proveedor.show',compact('proveedor'));  
   }
   
   // Muestra el formulario para editar un autor específico.
   public function edit(int $id){
    $proveedor=Proveedor::find($id);    
   return view('profile.Transacciones.Proveedores.editProveedor',compact('proveedor'));  
   }
  
   // Actualiza un Actualiza existente con los nuevos datos del formulario.  
   public function update(Request $request,int $id){
    $proveedor =Proveedor::find($id);   
    $anterioresDatos = $proveedor;
    $request->validate([ 
      'nombre'=>'required|string|max:50',
      'persona_de_contacto'=>'required|string|max:50',
      'telefono_de_contacto'=>'required|int',
    ]);
    $proveedor->update($request->all());

    $bitacoraRequest = new BitacoraRequest([
      'tabla_afectada' => 'Proveedores',
      'user_id' => Auth::id(),
      'fecha_hora' => date('Y-m-d H:i:s'),
      'datos_anteriores' => $anterioresDatos,
      'datos_nuevos' => $proveedor->all(),
      'ip_address' => $request->ip(),
  ]);

  $bitacoraController = new BitacoraController();   
  // Llama al método del BitacoraController
  $bitacoraController->storeUpdate($bitacoraRequest);

    return redirect()->route('proveedor.index')->with('success', 'proveedor modificado correctamente.');     
  }

   // Elimina un autor específico de la base de datos. 
  public function destroy(int $id){
    $role_id = Auth::user()->role_id;
    $role = RoleController::hasPrivilegio($role_id, 7);
    if(Auth::check()){
      if($role){
        $proveedor=Proveedor::find($id);
        $bitacoraRequest = new BitacoraRequest([
          'tabla_afectada' => 'Clientes',
          'user_id' => Auth::id(),
          'fecha_hora' => date('Y-m-d H:i:s'),
          'datos_anteriores' =>  $proveedor->all(),
          'datos_nuevos' =>null,
          'ip_address' => request()->ip(),
        ]);
        $bitacoraController = new BitacoraController();
        $bitacoraController->storeDelete($bitacoraRequest);
        $proveedor->delete();
        return redirect()->route('proveedor.index')->with('success', 'proveedor eliminado exitosamente'); 
      }
      return $this->index();
    }
    return redirect('auth.login'); 
  } 
  
}
