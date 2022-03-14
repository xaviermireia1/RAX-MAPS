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

Route::get('perfil',[UsuarioController::class, 'perfil']);

Route::post('login',[UsuarioController::class,'loginPost']);

Route::post('registro',[UsuarioController::class,'registraUsuario']);

Route::get('logout', [UsuarioController::class, 'logout']);

//Mostrar
//AJAX MAPA
///////////////////////////////////////////////////////////////////////////////////////////////////
Route::post('direcciones',[DireccionesController::class,'mostrarDireccionesMAP']);

Route::get('etiqueta/{id}',[DireccionesController::class,'filtroEtiquetaMAP']);

Route::post('etiquetas/usuarios',[DireccionesController::class,'cogerEtiquetaUsuarioMAP']);

Route::get('etiquetas/direcciones/{id}',[DireccionesController::class,'getEtiquetaDireccionMAP']);
///////////////////////////////////////////////////////////////////////////////////////////////////
Route::post('mostrarEtiqueta',[DireccionesController::class,'mostrarEtiqueta']);

Route::post('mostrarEquipo',[UsuarioController::class,'mostrarEquipos']);

Route::post('mostrarPerfil',[UsuarioController::class,'mostrarPerfil']);

Route::post('mostrarDirecciones',[DireccionesController::class,'mostrarDirecciones']);

Route::post('mostrarGincana',[DireccionesController::class,'mostrarGincana']);

Route::post('etiquetas/sistema',[DireccionesController::class,'mostrarEtiquetaSistema']);

//Crear
Route::post('crearEtiquetas',[DireccionesController::class, 'crearEtiquetasPost']);

Route::post('crearDireccion',[DireccionesController::class, 'crearDireccionPost']);

Route::post('crearEquipo',[UsuarioController::class, 'crearEquipoPost']);

//Modificar
Route::put('modificarDireccion',[DireccionesController::class, 'modificarDireccionPut']);
Route::get("modificarDireccion/{id}",[DireccionesController::class, 'modificarDireccionModal']);

Route::put('modificarEtiqueta',[DireccionesController::class, 'modificarEtiquetaPut']);

Route::put('modificarEquipo',[UsuarioController::class, 'modificarEquipoPut']);

Route::put('unirseEquipo/{id}',[UsuarioController::class, 'unirseEquipo']);

Route::put('modificarPerfil',[UsuarioController::class, 'modificarPerfil']);


//Eliminar
Route::delete('eliminarEtiquetas/{id}',[DireccionesController::class, 'eliminarEtiquetas']);

Route::delete('eliminarDireccion/{id}',[DireccionesController::class, 'eliminarDireccion']);

Route::delete('eliminarUsuario/{id}',[UsuarioController::class, 'eliminarUsuario']);

Route::put('abandonarEquipo',[UsuarioController::class, 'abandonarEquipo']);

//Gincana
Route::post('comprobarEquipo',[DireccionesController::class, 'comprobarEquipo']);