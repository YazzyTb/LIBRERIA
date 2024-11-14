<?php

namespace App\Http\Controllers\Transacciones\Compras;

use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Models\Compra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuarios\Roles\RoleController;
use App\Http\Requests\Bitacoras\BitacoraRequest;
use App\Models\Proveedor;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    public function index(){
        $role_id = Auth::user()->role_id;
        $role = RoleController::hasPrivilegio($role_id, 6);
        if(Auth::check()){
            if($role){
                $compras = Compra::all(); // Asume que tienes un modelo Bitacora
                return view('profile.Transacciones.Compras.compras', compact('compras'));
            }
            return redirect('dashboard');
        }
        return redirect('auth.login'); 
    }

    public function create(){
        $role_id = Auth::user()->role_id;
        $role = RoleController::hasPrivilegio($role_id, 6);
        if(Auth::check()){
            if($role){
                $proveedores=Proveedor::all();
                $productosConStockBajo = Stock::whereColumn('cantidad', '<=', 'min_stock')
                    ->join('productos', 'stocks.producto_codigo', '=', 'productos.codigo')
                    ->pluck('productos.nombre', 'productos.codigo'); // Pluck para obtener ['codigo' => 'nombre']
                return view('profile.Transacciones.Compras.createCompras', compact('proveedores', 'productosConStockBajo'));
            }
            return redirect('dashboard');
        }
        return redirect('auth.login'); 

        
    }
    
    public function store(Request $request)
{
    // Creación de la compra
    $compra = Compra::create([
        'monto_total' => 0, // El monto total inicial es 0, el trigger lo actualizará
        'fecha' => $request->fecha,
        'user_id' => Auth::id(), // Obtiene el id del usuario que está haciendo la compra
        'proveedore_id' => $request->proveedore_id,
    ]);

    $bitacoraRequest = new BitacoraRequest([
        'tabla_afectada' => 'Compra',
        'user_id' => Auth::id(),
        'fecha_hora' => date('Y-m-d H:i:s'),
        'datos_anteriores' => null,
        'datos_nuevos' => $compra->all(),
        'ip_address' => $request->ip(),
      ]);
      $bitacoraController = new BitacoraController();
      $bitacoraController->storeInsert($bitacoraRequest);

    // Procesar cada producto seleccionado
    foreach ($request->productos as $codigo => $detalle) {
        if (!empty($detalle['selected'])) {
            $cantidad = $detalle['cantidad'];
            $precio = $detalle['precio'];
            
            // Verificar el stock del producto antes de insertarlo
            $stock = Stock::where('producto_codigo', $codigo)->first();
            if ($stock && ($cantidad + $stock->cantidad) > $stock->max_stock) {
                return redirect()->back()->withErrors([
                    "productos.{$codigo}.cantidad" => "La cantidad para el producto {$codigo} no puede exceder el stock máximo de {$stock->max_stock}."
                ])->withInput();
            }

            // Insertar el producto en la compra
            $compra->productos()->attach($codigo, [
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio'],
            ]);
        }
    }

    // Redirigir al índice de compras después de la operación
    return redirect()->route('compra.index');
}

    public function show(int $nro){
     $compra=Compra::find($nro);
    if(!$compra){
     return redirect()->back()->with('error', 'Compra no encontrada'); ;
    }
     return view('profile.compra.show',compact('compra'));
    }

    public function edit(int $nro){
     $compra=Compra::find($nro);
     $proveedores=Proveedor::all();
     $stocks =Stock::whereColumn('cantidad', '<=', 'min_stock')
     ->join('productos', 'stocks.producto_codigo', '=', 'productos.codigo')
     ->pluck('productos.nombre', 'productos.codigo'); // Pluck para obtener ['codigo' => 'nombre']
     $productosCompra = $compra->productos;  // Esto devolverá los productos asociados a esta compra

     return view('profile.Transacciones.Compras.editCompras',compact('compra','proveedores','stocks','productosCompra'));
    }

    public function update(Request $request,int $nro){
     $compra=Compra::find($nro);
         // Validar los datos
    $request->validate([
        'fecha' => 'required|date',
        'proveedore_id' => 'required|int',
        'productos' => 'required|array',
        'productos.*.selected' => 'required|boolean', // El campo selected es obligatorio y debe ser un booleano
        'productos.*.producto_codigo' => 'required_if:productos.*.selected,1|string|max:8',
        'productos.*.cantidad' => 'required_if:productos.*.selected,1|numeric|min:1|nullable',
        'productos.*.precio' => 'required_if:productos.*.selected,1|numeric|min:0|nullable',
    ]);

    // Actualizar los datos de la compra
    $compra->update([
        'fecha' => $request->fecha,
        'proveedore_id' => $request->proveedore_id,
        'user_id' => Auth::id(),  // Obtener el id del usuario que está haciendo la compra
    ]);

    // Primero, manejamos los productos eliminados o actualizados
    foreach ($compra->productos as $producto) {
        $productoCodigo = $producto->producto_codigo;

        // Si el producto ha sido desmarcado, lo eliminamos de la compra
        if (!isset($request->productos[$productoCodigo]['selected']) || !$request->productos[$productoCodigo]['selected']) {
            // Desvinculamos el producto de la compra
            $compra->productos()->detach($productoCodigo);
        }
    }

    // Ahora, agregamos o actualizamos los productos que permanecen seleccionados o los nuevos productos
    foreach ($request->productos as $codigo => $detalle) {
        if (!empty($detalle['selected'])) {
            $cantidad = $detalle['cantidad'];
            $precio = $detalle['precio'];

    // Si el producto ya está en la compra, solo actualizamos la cantidad y el precio
     if ($compra->productos->contains('producto_codigo', $codigo)) {
         $compra->productos()->updateExistingPivot($codigo, [
         'cantidad' => $cantidad,
          'precio' => $precio,
        ]);
     } else {
      // Si el producto es nuevo, lo agregamos a la compra
      $compra->productos()->attach($codigo, [
       'cantidad' => $cantidad,
       'precio' => $precio,
       ]);
      }
    }
  }
    return redirect()->route('compra.index')->with('success', 'Compra actualizada exitosamente');
  }

    public function destroy(int $nro){
     $compra=Compra::find($nro);
     $compra->productos()->detach();
     $compra->delete();
     return redirect()->route('compra.index')->with('success', 'compra eliminada exitosamente');   
    }

    //genera un pdf especifico
    /*public function pdf(int $nro){
      $compra=Compra::find($nro);
      $pdf = Pdf::loadView('profile.Compras.pdf',compact('compra'));
      return $pdf->stream();
    }

    //genera un pdf de todo
    public function PDFall(){
     $compra=Compra::all();
     $pdf = Pdf::loadView('profile.Compras.pdfCompleto',compact('compra'));
     return $pdf->stream();
    }
    */
}
