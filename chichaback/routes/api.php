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
    Route::resource('/cliente',\App\Http\Controllers\ClienteController::class);
    Route::resource('/producto',\App\Http\Controllers\ProductoController::class);
    Route::resource('/venta',\App\Http\Controllers\VentaController::class);
    Route::resource('/garantia',\App\Http\Controllers\GarantiaController::class);
    Route::resource('/garantia',\App\Http\Controllers\GarantiaController::class);
    Route::resource('/inventario',\App\Http\Controllers\InventarioController::class);
    Route::resource('/loginventario',\App\Http\Controllers\LoginventarioController::class);
    Route::post('/misventas',[\App\Http\Controllers\VentaController::class,'misventas']);
    Route::post('/directa',[\App\Http\Controllers\VentaController::class,'directa']);
    Route::post('/listado',[\App\Http\Controllers\GarantiaController::class,'listado']);
    Route::post('/activar',[\App\Http\Controllers\ClienteController::class,'activar']);
    Route::post('/activarprod',[\App\Http\Controllers\ProductoController::class,'activarprod']);
    Route::post('/activarinv',[\App\Http\Controllers\InventarioController::class,'activarinv']);
    Route::post('/inventarioadd',[\App\Http\Controllers\ProductoController ::class,'productadd']);
    Route::post('/inventariosub',[\App\Http\Controllers\ProductoController ::class,'productsub']);
    Route::get('/cumple',[\App\Http\Controllers\ClienteController ::class,'ordercumple']);
    Route::get('/cumple2',[\App\Http\Controllers\ClienteController ::class,'ordercumple2']);
    Route::resource('/empleado',\App\Http\Controllers\EmpleadoController::class);
    Route::resource('/sueldo',\App\Http\Controllers\SueldoController::class);
});
