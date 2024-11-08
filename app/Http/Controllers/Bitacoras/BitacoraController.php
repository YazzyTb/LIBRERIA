<?php

namespace App\Http\Controllers\Bitacoras;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index()
    {
        //restringir
        $bitacora = Bitacora::all(); // Asume que tienes un modelo Bitacora
        return view('profile.bitacora.bitacora', compact('bitacora'));
    }

    public function show(){
        $role_id = Auth::user()->role_id;
        $role = RoleController::hasPrivilegio($role_id, 10);
        if(Auth::check()){
            if($role){
                return redirect('profile.bitacora.bitacora');
            }
            return redirect('dashboard');
        }
        return redirect('auth.login');
    }

    public function storeInsert(BitacoraRequest $request){

        $datosNuevosArray = $request->datos_nuevos;

        $datosNuevos = '';
        foreach ($datosNuevosArray as $clave=>$valor) { 
            if($clave != '_token' && $clave != '_method'){
                if (is_array($valor)) {
                    // Convierte el array a una cadena separada por comas
                    $valor = implode(", ", $valor);
                }
                $datosNuevos .= "$clave: $valor\n";
            }
        }
        
        Bitacora::create([
            'tabla_afectada' => $request->tabla_afectada,
            'accione_id' => 1,
            'user_id' => $request->user_id,
            'fecha_hora' => $request->fecha_hora,
            'datos_anteriores' => null,
            'datos_nuevos' => $datosNuevos,
            'ip_address' => $request->ip_address,
        ]);
    }
    public function storeUpdate(BitacoraRequest $request){
        $datosNuevosArray = $request->datos_nuevos;
        $datosAnterioresArry = $request->datos_anteriores;
        $datosNuevos = '';
        $datosAnteriores = '';
        foreach ($datosNuevosArray as $clave=>$valor) { 
            if($clave != '_token' && $clave != '_method'){
                if (is_array($valor)) {
                    // Convierte el array a una cadena separada por comas
                    $valor = implode(", ", $valor);
                }
                $datosNuevos .= "$clave: $valor\n";
            }
        }
        foreach ($datosAnterioresArry as $clave=>$valor) { 
            if($clave != '_token' && $clave != '_method'){
                if (is_array($valor)) {
                    // Convierte el array a una cadena separada por comas
                    $valor = implode(", ", $valor);
                }
                $datosAnteriores .= "$clave: $valor\n";
            }
        }
        Bitacora::create([
            'tabla_afectada' => $request->tabla_afectada,
            'accione_id' => 2,
            'user_id' => $request->user_id,
            'fecha_hora' => $request->fecha_hora,
            'datos_anteriores'=> $datosAnteriores,
            'datos_nuevos' => $datosNuevos,
            'ip_address' => $request->ip_address,
        ]);
    }
    public function storeDelete(BitacoraRequest $request){
        $datosAnterioresArry = $request->datos_anteriores;
        $datosAnteriores = '';
        foreach ($datosAnterioresArry as $clave=>$valor) { 
            if($clave != '_token' && $clave != '_method'){
                if (is_array($valor)) {
                    // Convierte el array a una cadena separada por comas
                    $valor = implode(", ", $valor);
                }
                $datosAnteriores .= "$clave: $valor\n";
            }
        }
        Bitacora::create([
            'tabla_afectada' => $request->tabla_afectada,
            'accione_id' => 3,
            'user_id' => $request->user_id,
            'fecha_hora' => $request->fecha_hora,
            'datos_anteriores'=> $datosAnteriores,
            'datos_nuevos' => null,
            'ip_address' => $request->ip_address,
        ]);
    }
}
