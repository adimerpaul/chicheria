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
    Route::post('/activar',[\App\Http\Controllers\ClienteController::class,'activar']);
    Route::post('/activarprod',[\App\Http\Controllers\ProductoController::class,'activarprod']);
});
