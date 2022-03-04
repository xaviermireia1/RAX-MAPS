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
    return view('index');
});
//Rutas controlador direcciones

//Login + Logout
Route::get('login',[UsuarioController::class,'login']);

Route::post('login',[UsuarioController::class,'loginPost']);

Route::post('login',[UsuarioController::class,'registraUsuario']);

Route::get('logout', [UsuarioController::class, 'logout']);

//Mostrar
Route::post('direcciones',[DireccionesController::class,'mostrarDirecciones']);

//Crear
Route::post('crearEtiquetas',[DireccionesController::class, 'crearEtiquetasPost']);

Route::post('crearDireccion',[DireccionesController::class, 'crearDireccionPost']);

//Modificar
Route::put('modificarDireccion',[DireccionesController::class, 'modificarDireccionPut']);

Route::put('modificarEtiqueta',[DireccionesController::class, 'modificarEtiquetaPut']);
//Eliminar
Route::delete('eliminarEtiquetas/{id}',[DireccionesController::class, 'eliminarEtiquetas']);

Route::delete('eliminarDireccion/{id}',[DireccionesController::class, 'eliminarDireccion']);