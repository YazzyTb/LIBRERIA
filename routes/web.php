<?php

use App\Http\Controllers\ComprasController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Usuarios\Privilegios\PrivilegioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ReportepagosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Bitacoras\BitacoraController;
use App\Http\Controllers\Inventario\Generos\GeneroController;
use App\Http\Controllers\Usuarios\Clientes\ClienteController;
use App\Http\Controllers\Usuarios\Empleados\EmpleadoController;
use App\Http\Controllers\Inventario\Productos\ProductoController;
use App\Http\Controllers\Inventario\Productos\StockController;
use App\Http\Controllers\Usuarios\Roles\RoleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

    


    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
   
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    Route::get('/privilegios', [PrivilegioController::class, 'index'])->name('privilegios.index');

    Route::get('/asignar', [PrivilegioController::class, 'asignar'])->name('asignar');

    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');

    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');

    Route::get('/Producto', [ProductoController::class, 'index'])->name('producto.index');

    Route::get('/categoria', [GeneroController::class, 'index'])->name('genero.index');

    Route::get('/promocion', [PromocionController::class, 'index'])->name('promocion_producto.index');

    Route::get('/proveedor', [ProveedoresController::class, 'index'])->name('proveedor.index');

    Route::get('/venta', [VentasController::class, 'index'])->name('venta.index');

    Route::get('/compra', [ComprasController::class, 'index'])->name('compra.index');

    Route::get('/factura', [FacturaController::class, 'index'])->name('factura.index');

    Route::get('/reporte', [ReportepagosController::class, 'index'])->name('ganancia_diaria.index');
});
//clientes

Route::get('/cliente/create',[ClienteController::class,'create'])
       ->name('cliente.create');

Route::post('/clientes/store',[ClienteController::class,'store'])
       ->name('cliente.store');
//Rutas para editar lleva aun formulario
Route::get('/clientes/{cliente}',[ClienteController::class,'edit'])
       ->name('cliente.edit');
// ruta para editar actualiza los datos 
Route::put('/clientes/{cliente}',[ClienteController::class,'update'])
       ->name('cliente.update',);

//Ruta para eliminar 
Route::delete('/clientes/{cliente}',[ClienteController::class,'destroy'])
       ->name('cliente.delete');

//Roles
Route::get('/roles/create',[RoleController::class,'create'])
       ->name('roles.create');

Route::post('/roles/store',[RoleController::class,'store'])
       ->name('roles.store');

//Rutas para editar lleva aun formulario
Route::get('/roles/{role}',[RoleController::class,'edit'])
       ->name('roles.edit');
// ruta para editar actualiza los datos 
Route::put('/roles/{role}', [RoleController::class, 'update'])
       ->name('roles.update');

//Ruta para eliminar 
Route::delete('/roles/{role}',[RoleController::class,'destroy'])
       ->name('roles.delete');


//empleados

Route::get('/empleados/create',[EmpleadoController::class,'create'])
       ->name('empleados.create');

Route::post('/empleados/store',[EmpleadoController::class,'store'])
       ->name('empleados.store');

//Rutas para editar lleva aun formulario
Route::get('/empleados/{empleado}',[EmpleadoController::class,'edit'])
       ->name('empleados.edit');
// ruta para editar actualiza los datos 
Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update'])
       ->name('empleados.update');

//Ruta para eliminar 
Route::delete('/empleados/{empleado}',[EmpleadoController::class,'destroy'])
       ->name('empleados.delete');



//Usuarios

//Rutas para editar lleva aun formulario
Route::get('/usuarios/create',[EmpleadoController::class,'create'])
       ->name('usuarios.create');

Route::get('/usuarios/{usuario}/edit', [UsuariosController::class, 'edit'])->name('usuarios.edit');

Route::put('/usuarios/{users}', [UsuariosController::class, 'update'])
       ->name('users.update');

//Ruta para eliminar 
Route::delete('/users/{users}',[UsuariosController::class,'destroy'])
       ->name('usuarios.delete');



//Produccto
Route::get('/productos/create',[ProductoController::class,'create'])
       ->name('producto.create');

Route::post('/produtos/store',[ProductoController::class,'store'])
       ->name('producto.store');

//Rutas para editar lleva aun formulario
Route::get('/productos/{producto}',[ProductoController::class,'edit'])
       ->name('producto.edit');
       
// ruta para editar actualiza los datos 
Route::put('/productos/{producto}', [ProductoController::class, 'update'])
       ->name('producto.update');

//Ruta para eliminar 
Route::delete('/productos/{producto}',[ProductoController::class,'destroy'])
       ->name('producto.delete');



//Stock
//Route::get('stock/create/{codigo?}', [StockController::class, 'create'])->name('stock.create');
Route::get('/stock/create',[StockController::class,'create'])
       ->name('stock.create');

Route::post('/stock/store',[StockController::class,'store'])
       ->name('stock.store');

//Rutas para editar lleva aun formulario
Route::get('/stock/{stock}',[StockController::class,'edit'])
       ->name('stock.edit');
// ruta para editar actualiza los datos 
Route::put('/stock/{stock}', [StockController::class, 'update'])
       ->name('stock.update');


//Ruta para eliminar 
Route::delete('/stock/{stock}',[StockController::class,'destroy'])
       ->name('stock.delete');



require __DIR__.'/auth.php';
