<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DireccionesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Rutas controlador usuario
Route::get('/', function () {
    return view('welcome');
});
//Rutas controlador direcciones

//Login
Route::get('login',[DireccionesController::class,'login']);
Route::post('login/user',[DireccionesController::class,'loginPost']);
Route::post('register/user',[DireccionesController::class,'store']);

//Mostrar


//Crear
Route::post('crearEtiquetas',[DireccionesController::class, 'crearEtiquetasPost']);
//Modificar

//Eliminar
Route::delete('eliminarEtiquetas/{id}',[DireccionesController::class, 'eliminarEtiquetas']);