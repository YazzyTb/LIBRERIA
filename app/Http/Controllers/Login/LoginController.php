<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /* 
    Te llava al formulario para logearte a la pagina
    */
    public function show(){
        return view('auth.login');
    }
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $ci =  Auth::user()->getAuthIdentifier();
        
        DB::update('update users set inicio_session = ? where id = ?', [Carbon::now(), $ci]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $ci =  Auth::user()->getAuthIdentifier();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Actualizar la columna 'last_login_at' con la fecha y hora actuales

        DB::update('update users set cierre_session = ? where id = ?', [Carbon::now(), $ci]);

        return redirect('/');
    }
}
