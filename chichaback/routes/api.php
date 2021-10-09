<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::post('listuser',[\App\Http\Controllers\UserController::class,'listuser']);

    Route::resource('/cliente',\App\Http\Controllers\ClienteController::class);
    Route::resource('/user',\App\Http\Controllers\UserController::class);
    Route::put('/pass/{user}',[\App\Http\Controllers\UserController::class,'pass']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);
    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
    Route::resource('/producto',\App\Http\Controllers\ProductoController::class);
    Route::resource('/venta',\App\Http\Controllers\VentaController::class);
    Route::resource('/garantia',\App\Http\Controllers\GarantiaController::class);
    Route::resource('/inventario',\App\Http\Controllers\InventarioController::class);
    Route::resource('/loginventario',\App\Http\Controllers\LoginventarioController::class);
    Route::resource('/gasto',\App\Http\Controllers\GastoController::class);
    Route::resource('/prestamo',\App\Http\Controllers\PrestamoController::class);
    Route::post('/misgastos',[\App\Http\Controllers\GastoController::class,'misgastos']);

    Route::resource('/user',\App\Http\Controllers\UserController::class);
    Route::put('/pass/{user}',[\App\Http\Controllers\UserController::class,'pass']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);
    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
    Route::resource('/pago',\App\Http\Controllers\PagoController::class);

    Route::post('/listlog',[\App\Http\Controllers\LoginventarioController::class,'listlog']);
    Route::post('/misventas',[\App\Http\Controllers\VentaController::class,'misventas']);
    Route::post('/listventa',[\App\Http\Controllers\VentaController::class,'listventa']);
    Route::post('/directa',[\App\Http\Controllers\VentaController::class,'directa']);
    Route::post('/listado',[\App\Http\Controllers\GarantiaController::class,'listado']);
    Route::post('/activar',[\App\Http\Controllers\ClienteController::class,'activar']);
    Route::post('/activarprod',[\App\Http\Controllers\ProductoController::class,'activarprod']);
    Route::post('/activarinv',[\App\Http\Controllers\InventarioController::class,'activarinv']);
    Route::post('/inventarioadd',[\App\Http\Controllers\InventarioController ::class,'productadd']);
    Route::post('/inventariosub',[\App\Http\Controllers\InventarioController ::class,'productsub']);
    Route::get('/listacliente',[\App\Http\Controllers\ClienteController ::class,'listacliente']);
    Route::get('/listaproducto',[\App\Http\Controllers\ProductoController ::class,'listaproducto']);
    Route::get('/listainventario',[\App\Http\Controllers\InventarioController ::class,'listainventario']);
    Route::post('/listaprestamo',[\App\Http\Controllers\GarantiaController ::class,'listaprestamo']);
    Route::post('/listadoventa',[\App\Http\Controllers\VentaController ::class,'listadoventa']);
    Route::post('/listadodeudores',[\App\Http\Controllers\VentaController ::class,'listadodeudores']);
    Route::post('/devolver',[\App\Http\Controllers\GarantiaController ::class,'devolver']);
    Route::get('/cumple',[\App\Http\Controllers\ClienteController ::class,'ordercumple']);
    Route::get('/cumple2',[\App\Http\Controllers\ClienteController ::class,'ordercumple2']);
    Route::post('/impresiondetalle\{id}',[\App\Http\Controllers\VentaController ::class,'impresiondetalle']);
    Route::post('/anular/{id}',[\App\Http\Controllers\VentaController ::class,'anular']);
    Route::post('/ruta/{id}',[\App\Http\Controllers\VentaController ::class,'ruta']);
    
    Route::resource('/empleado',\App\Http\Controllers\EmpleadoController::class);
    Route::post('/missueldos',[\App\Http\Controllers\EmpleadoController::class,'missueldos']);
    Route::resource('/sueldo',\App\Http\Controllers\SueldoController::class);
});
