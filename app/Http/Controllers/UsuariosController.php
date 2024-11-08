<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UsuariosController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla 'bitacora'
        $users = User::all();

        // Retornar la vista 'bitacora.index' y pasarle los datos
        return view('profile.usuarios.usuarios', compact('users'));
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
        public function edit(int $users){
            $users=User::find($users);    
           return view('profile.usuaios.usuarioEdit',compact('cliente'));// va a  una vista para editar  
           }

           public function update(Request $request,int $users){
            $users =User::find($users);   
            $users->update($request->all());
            return redirect()->route('usuarios.index')->with('success', 'Usuario modificado correctamente.');    
           }
           
           public function destroy(int $users){
            $users=User::find($users);   
            $users->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');     
            }
           
}
