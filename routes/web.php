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

//Ruta para index
Route::get('/',[DireccionesController::class,'index']);

//Login + Logout
Route::get('login',[UsuarioController::class,'login']);

Route::post('login',[UsuarioController::class,'loginPost']);

Route::post('registro',[UsuarioController::class,'registraUsuario']);

Route::get('logout', [UsuarioController::class, 'logout']);

//Mostrar
Route::post('direcciones',[DireccionesController::class,'mostrarDirecciones']);

Route::get('perfil',[UsuarioController::class, 'perfil']);

//Crear
Route::post('crearEtiquetas',[DireccionesController::class, 'crearEtiquetasPost']);

Route::post('crearDireccion',[DireccionesController::class, 'crearDireccionPost']);

//Modificar
Route::put('modificarDireccion',[DireccionesController::class, 'modificarDireccionPut']);

Route::put('modificarEtiqueta',[DireccionesController::class, 'modificarEtiquetaPut']);

//Eliminar
Route::delete('eliminarEtiquetas/{id}',[DireccionesController::class, 'eliminarEtiquetas']);

Route::delete('eliminarDireccion/{id}',[DireccionesController::class, 'eliminarDireccion']);

Route::deletee('eliminarUsuario/{id}',[UsuarioController::class, 'eliminarUsuario']);