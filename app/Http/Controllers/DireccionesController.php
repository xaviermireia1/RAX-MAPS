<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;


class DireccionesController extends Controller
{
    //Mostrar vista principal que es el mapa
    public function index(){
        if (session()->has('id_usuario')) {
            $id = session()->get('id_usuario');
            $listaEtiquetas = DB::select("SELECT * FROM tbl_etiqueta where id_usuario IN (1,$id)");
        }else{
            $listaEtiquetas = DB::select("SELECT * FROM tbl_etiqueta where id_usuario=1");
        }
        return view('index',compact('listaEtiquetas'));
    }
    
    //AJAX CRUD
    //MOSTRAR
    public function mostrarEtiqueta(){
        $rol = session()->get('rol');
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        if ($rol == 'cliente') {
            $listaEtiquetas = DB::table('tbl_etiqueta')->select('*')->where('id_usuario','=',$idUsuario)->get();
        }else{
            $listaEtiquetas = DB::table('tbl_etiqueta')->select('*')->get();
        }
        //return view('mostrar', compact('listaEtiquetas'));
        return response()->json($listaEtiquetas);
    }

    public function mostrarDirecciones(){
        $listaDirecciones = DB::select("SELECT * FROM tbl_ubicacion");
        //return view('mostrar', compact('listaEtiquetas'));
        return response()->json($listaDirecciones);
    }
    //Crear
    public function crearEtiquetasPost(Request $request){
        $datos = $request->except('_token');

        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        $icono_eti = "sys_user";
        try{
            DB::beginTransaction();
            DB::table('tbl_etiqueta')->insertGetId(['nombre_eti'=>$datos['nombre_eti'],'icono_eti'=>$icono_eti,'id_usuario'=>$idUsuario]);
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
        //return redirect('');
    }

    public function crearDireccionPost(Request $request){
        $datos=$request->except('_token');
        try{
            DB::beginTransaction();
            DB::table('tbl_ubicacion')->insertGetId(['nombre_ubi'=>$datos['nombre_ubi'],'descripcion_ubi'=>$datos['descripcion_ubi'],'latitud_ubi'=>$datos['latitud_ubi'],'longitud_ubi'=>$datos['longitud_ubi'],'direccion_ubi'=>$datos['direccion_ubi']]);
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
        //return redirect('');
    }

    //Eliminar
    public function eliminarEtiquetas($id){
        try{
            DB::beginTransaction();
            DB::table('tbl_registro')->where('id_etiqueta','=',$id)->delete();
            DB::table('tbl_etiqueta')->where('id','=',$id)->delete();
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
        //return redirect('');
    }

    public function eliminarDireccion($id){
        try{
            DB::beginTransaction();
            DB::table('tbl_registro')->where('id_ubicacion','=',$id)->delete();
            DB::table('tbl_objetivo')->where('id_ubicacion','=',$id)->delete();
            DB::table('tbl_ubicacion')->where('id','=',$id)->delete();
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
        //return redirect('');
    }

    //Modificar
    public function modificarDireccionPut(Request $request){
        $datos=$request->except('_token');
        try {
            DB::beginTransaction();
            DB::table('tbl_ubicacion')->where('id','=',$datos['id'])->update($datos);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');
    }

    public function modificarEtiquetaPut(Request $request){
        $datos = $request->except('_token','_method');
        try{
            DB::beginTransaction();
            DB::table('tbl_etiqueta')->where('id','=',$datos['id'])->update($datos);
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
        //return redirect('');
    }




    //AJAX MAPAS
    //Mostrar direcciones
    public function mostrarDireccionesMAP(){
        $listaDirecciones = DB::select("SELECT ubi.*,eti.nombre_eti,eti.icono_eti  FROM tbl_ubicacion ubi 
        inner join tbl_registro ON tbl_registro.id_ubicacion = ubi.id
        left join tbl_etiqueta eti ON tbl_registro.id_etiqueta = eti.id
        where eti.icono_eti like 'sys_%'");
        return response()->json($listaDirecciones);
    }
    //Filtrar por etiquetas
    public function filtroEtiquetaMAP($id){
        if ($id == 0) {
            $etiquetas = DB::select("SELECT ubi.*,eti.nombre_eti,eti.icono_eti  FROM tbl_ubicacion ubi 
            inner join tbl_registro ON tbl_registro.id_ubicacion = ubi.id
            left join tbl_etiqueta eti ON tbl_registro.id_etiqueta = eti.id
            where eti.icono_eti like 'sys_%'");
        }else{
            $etiquetas = DB::select("SELECT ubi.*,eti.nombre_eti,eti.icono_eti FROM tbl_etiqueta eti
            inner join tbl_registro regi on regi.id_etiqueta = eti.id
            left join tbl_ubicacion ubi on ubi.id = regi.id_ubicacion
            where regi.id_etiqueta = $id AND eti.icono_eti like 'sys_%'");
        }
        return response()->json($etiquetas);
    }
    //Coger etiquetas del usuario del
    public function cogerEtiquetaUsuarioMAP(){
        $etiqueta = "";
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
            $rol= session()->get('rol');
            $etiqueta = DB::select("SELECT * FROM tbl_etiqueta where id_usuario = $idUsuario");
        }
        return response()->json($etiqueta);
    }
    public function getEtiquetaDireccionMAP($idDireccion){
        $etiquetasDireccion = DB::select("SELECT eti.nombre_eti FROM tbl_etiqueta eti 
        INNER JOIN tbl_registro regi on regi.id_etiqueta = eti.id
        where regi.id_ubicacion = $idDireccion");
        return response()->json($etiquetasDireccion);
    }
}