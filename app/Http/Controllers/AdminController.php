<?php

namespace App\Http\Controllers;

use App\Http\Requests\adminRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function showReg(){
        if(Auth::check()){
           return view('auth.register');
        }
       return view('auth.login');
        
        //return view('auth.register');
    }
    public function storeReg(Request $request): RedirectResponse
    {
        session()->regenerate();
        $request->validate([
            'id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        User::create([
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        //event(new Registered($user));

        

        return redirect()->route('empleados')->with('status', 'Usuario creado exitosamente.');
    }

    public function storeLog(adminRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $ci =  Auth::user()->getAuthIdentifier();
        DB::update('update users set inicio_Sesion = ? where id = ?', [Carbon::now(), $ci]);


        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroyLog(Request $request): RedirectResponse
    {
        $ci =  Auth::user()->getAuthIdentifier();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Actualizar la columna 'last_login_at' con la fecha y hora actuales

        DB::update('update users set Cierre_Sesion = ? where id = ?', [Carbon::now(), $ci]);

        return redirect('/');
    }
    
}
