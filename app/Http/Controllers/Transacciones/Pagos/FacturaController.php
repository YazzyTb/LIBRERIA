<?php

namespace App\Http\Controllers\Transacciones\Pagos;

use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Transaccion\FacturaRequest;
use App\Models\Factura;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    public function index()
    {
       // $factura = Factura::all(); // Asume que tienes un modelo Bitacora
       
        $role_id = Auth::user()->role_id;
        $role_privilegio = RoleController::hasPrivilegio($role_id,privilegio_id: 1);
        if(Auth::check()){
            if($role_privilegio){
                $facturas = Factura::all();
                return view('profile.Transacciones.pagos.facturas', compact('facturas'));
            }
            return $this->index();
        }
        return view('auth.login');
    }

    // Falta el show
    /*public function generatePDF($id)
    {
        $factura = Factura::with('user', 'cliente')->findOrFail($id); // Obtiene la factura con los datos relacionados
        $pdf = Pdf::loadView('facturas.pdf', compact('factura')); // Genera el PDF con la vista correspondiente

        return $pdf->download('factura_' . $factura->nro . '.pdf'); // Descarga el PDF
    }*/

    public static function store(FacturaRequest $request){
        $factura = Factura::create([
            'formato_pago' => $request->formato_pago,
            'fecha' => date('Y-m-d H:i:s'),
            'cliente_ci' => $request->cliente_ci,
            'user_id' => auth()->id()
        ]);
        return $factura->nro;
    }
}
