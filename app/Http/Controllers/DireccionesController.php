<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Exception;
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

    public function mostrarEtiquetaSistema(){
        $listaEtiquetas = DB::select("SELECT * FROM tbl_etiqueta where id_usuario = 1");
        return response()->json($listaEtiquetas);
    }

    public function mostrarGincana(){
        $listaGincana = DB::select("SELECT * FROM tbl_gincana");
        return response()->json($listaGincana);
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
        if($request->hasFile('foto_ubi')){
            $datos['foto_ubi'] = $request->file('foto_ubi')->store('uploads','public');
        }else{
            $datos['foto_ubi'] = NULL;
        }
        try{
            DB::beginTransaction();
            $id = DB::table('tbl_ubicacion')->insertGetId(['nombre_ubi'=>$datos['nombre_ubi'],'descripcion_ubi'=>$datos['descripcion_ubi'],'latitud_ubi'=>$datos['latitud_ubi'],'longitud_ubi'=>$datos['longitud_ubi'],'direccion_ubi'=>$datos['direccion_ubi'],'foto_ubi'=>$datos['foto_ubi']]);
            DB::table('tbl_registro')->insert(['id_etiqueta'=>$datos['id_eti'],'id_ubicacion'=>$id]);
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
            $foto = DB::table('tbl_ubicacion')->select('foto_ubi')->where('id','=',$id)->first();   
            if ($foto->foto_ubi != null) {
                if (file_exists('storage/'.$foto->foto_ubi)) {
                    Storage::delete('public/'.$foto->foto_ubi);
                }
            }       
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
    public function modificarDireccionModal($id){
        $direccionModal = DB::select("SELECT * FROM tbl_ubicacion where id=$id");
        return response()->json($direccionModal);
    }


    public function modificarDireccionPut(Request $request){
        $datos = $request->except('_token','_method');
        $foto = DB::table('tbl_ubicacion')->select('foto_ubi')->where('id','=',$datos['id_ubicacion'])->first();  
        if($request->hasFile('foto_ubi')){ 
            if ($foto->foto_ubi != null) {
                if (file_exists('storage/'.$foto->foto_ubi)) {
                    Storage::delete('public/'.$foto->foto_ubi);
                }
            }
            $datos['foto_ubi'] = $request->file('foto_ubi')->store('uploads','public');
        }else{
            $datos['foto_ubi'] = $foto->foto_ubi;
        }
        $idEtiqueta = DB::select("SELECT regi.* FROM tbl_registro regi
        INNER JOIN tbl_etiqueta eti ON regi.id_etiqueta = eti.id
        WHERE regi.id_ubicacion = {$datos['id_ubicacion']} AND eti.id_usuario = 1");
        try {
            DB::beginTransaction();
            DB::select("UPDATE tbl_registro
            INNER JOIN tbl_etiqueta ON tbl_registro.id_etiqueta = tbl_etiqueta.id
            SET tbl_registro.id_etiqueta = {$datos['id_eti']}
            WHERE tbl_registro.id_ubicacion = {$datos['id_ubicacion']} AND tbl_etiqueta.id_usuario = 1");
            //$datos = $request->except('_token','_method',$datos['id_eti']);
            //DB::table('tbl_ubicacion')->where('id','=',$datos['id_ubicacion'])->update($datos);
            DB::select("UPDATE tbl_ubicacion 
            SET nombre_ubi='{$datos['nombre_ubi']}',descripcion_ubi='{$datos['descripcion_ubi']}',latitud_ubi='{$datos['latitud_ubi']}',longitud_ubi='{$datos['longitud_ubi']}',direccion_ubi='{$datos['direccion_ubi']}',foto_ubi='{$datos['foto_ubi']}'
            WHERE id = {$datos['id_ubicacion']}");
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
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
        where eti.icono_eti like 'sys_%' AND eti.icono_eti != 'sys_user'");
        return response()->json($listaDirecciones);
    }
    //Filtrar por etiquetas
    public function filtroEtiquetaMAP($id){
        if ($id == 0) {
            $etiquetas = DB::select("SELECT ubi.*,eti.nombre_eti,eti.icono_eti  FROM tbl_ubicacion ubi 
            inner join tbl_registro ON tbl_registro.id_ubicacion = ubi.id
            left join tbl_etiqueta eti ON tbl_registro.id_etiqueta = eti.id
            where eti.icono_eti like 'sys_%' AND eti.icono_eti != 'sys_user'");
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
        if (session()->has('id_usuario')) {
            $idUser = session()->get('id_usuario');
            $etiquetasDireccion = DB::select("SELECT eti.nombre_eti FROM tbl_etiqueta eti 
            INNER JOIN tbl_registro regi on regi.id_etiqueta = eti.id
            INNER JOIN tbl_usuario user on eti.id_usuario = user.id
            where regi.id_ubicacion = $idDireccion and (user.id = $idUser or user.id = 1)"); 
        }else{
            $etiquetasDireccion = DB::select("SELECT eti.nombre_eti FROM tbl_etiqueta eti 
            INNER JOIN tbl_registro regi on regi.id_etiqueta = eti.id
            INNER JOIN tbl_usuario user on eti.id_usuario = user.id
            where regi.id_ubicacion = $idDireccion and user.id = 1");
        }
        return response()->json($etiquetasDireccion);
    }
    public function tagUserSavedLocationMAP($idUbicacion, $idEtiqueta){
        $exists = DB::select("SELECT * FROM tbl_registro WHERE id_ubicacion=$idUbicacion AND id_etiqueta=$idEtiqueta");
        return response()->json($exists);
    }

    public function addEtiquetaDireccionMAP($idUbicacion, $idEtiqueta){
        try {
            DB::insert("INSERT INTO tbl_registro (id_etiqueta, id_ubicacion) values (?,?)",[$idEtiqueta,$idUbicacion]);
            return response()->json(array('resultado'=> 'OK'));
        } catch (\Exception $e) {
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }
    
    public function deleteEtiquetaDireccionMAP($idUbicacion, $idEtiqueta){
        try {
            DB::delete('DELETE FROM tbl_registro WHERE id_ubicacion=? and id_etiqueta=?',[$idUbicacion,$idEtiqueta]);
            return response()->json(array('resultado'=> 'OK'));
        } catch (\Exception $e) {
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }
    //Gincana
    public function comprobarEquipo(){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }

        $comprobacionEquipo=DB::table('tbl_usuario')->where('id','=',$idUsuario)->first();
        return response()->json($comprobacionEquipo);
    }

    public function GincanaEquipo($id){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }

        $comprobacionEquipo=DB::table('tbl_usuario')->where('id','=',$idUsuario)->first();

        $equipo = $comprobacionEquipo->id_equipo;
        $insGincanaEquipo = DB::table('tbl_participacion')->where('id_gincana','=',$id)->where('id_equipo','=', $equipo)->first();
        return response()->json($insGincanaEquipo);
    }

    public function insertGincana($idGincana, $idEquipo){
        $estado = 0;
        try{
            DB::beginTransaction();
            DB::table('tbl_participacion')->insertGetId(['id_gincana'=>$idGincana,'id_equipo'=>$idEquipo,'estado'=>$estado]);
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }

    public function cargarGincana($idGincana){
        //$cargarObjetivo = DB::table('tbl_ubicacion')->join('tbl_objetivo','tbl_ubicacion.id','=','tbl_objetivo.id_ubicacion')->where('tbl_objetivo.	id_gincana','=',$idGincana)->select('tbl_ubicacion.latitud_ubi','tbl_ubicacion.longitud_ubi','tbl_objetivo.*')->get();
        $cargarObjetivo = DB::select("SELECT tbl_ubicacion.longitud_ubi, tbl_ubicacion.latitud_ubi, tbl_objetivo.*
        FROM tbl_ubicacion INNER JOIN tbl_objetivo ON tbl_ubicacion.id = tbl_objetivo.id_ubicacion
        WHERE tbl_objetivo.id_gincana = $idGincana");
        return response()->json($cargarObjetivo);
    }

    public function contPlayers($idGincana, $idEquipo){
        $contPlayers = DB::select("SELECT tbl_participacion.id, tbl_participacion.estado, count(tbl_equipo.id) as 'ContadorEquipo' FROM tbl_equipo
        INNER JOIN tbl_participacion ON tbl_equipo.id = tbl_participacion.id_equipo
        INNER JOIN tbl_gincana ON tbl_gincana.id = tbl_participacion.id_gincana
        INNER JOIN tbl_usuario ON tbl_equipo.id = tbl_usuario.id_equipo
        WHERE tbl_equipo.id = $idEquipo AND tbl_participacion.id_gincana = $idGincana GROUP BY tbl_participacion.id, tbl_participacion.estado, 'ContadorEquipo'");
        return response()->json($contPlayers);
    }
    public function updateParticipantes($idParticipante){
        //Si no tiene estado actualizamos el registro
        if (!session()->has('estado')) {
            session()->put('estado',true); //Crear estado
            DB::select("UPDATE tbl_participacion SET estado = estado + 1 WHERE id = $idParticipante");
            //Si no comprobamos si el estado es igual a la cantidad de participantes, en caso de que sea así,
            //eliminamos la variable de session y cargamos el siguiente objetivo
        }
        try{
            $estadoIgualJugadores = DB::select("SELECT tbl_participacion.estado, count(tbl_usuario.id) as 'Contadorjugadores'
            FROM tbl_participacion INNER JOIN tbl_equipo ON tbl_equipo.id = tbl_participacion.id_equipo
            INNER JOIN tbl_usuario ON tbl_equipo.id = tbl_usuario.id_equipo WHERE tbl_participacion.id = $idParticipante
            GROUP BY tbl_participacion.estado, 'Contadorjugadores'");
            //Si es igual cargamos el siguiente objetivo
            if ($estadoIgualJugadores[0]->estado == $estadoIgualJugadores[0]->Contadorjugadores) {
                session()->forget('estado');
                DB::select("UPDATE tbl_participacion SET estado = 0 WHERE id = $idParticipante");
                return response()->json(array('resultado'=> 'OK'));
            }
            return response()->json(array('resultado'=> 'EQUIPO_INCOMPLETO'));
        }catch(\PDOException $e){
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }
    public function deleteSessionGincana(){
            session()->forget('estado');
            return response()->json(array('resultado'=> 'OK'));
    }
    public function eliminarParticipante($idParticipante){
        /*if (session()->has("estado")) {
            session()->forget('estado');
        }*/
        try{
            DB::select("DELETE FROM tbl_participacion WHERE id = $idParticipante");
            return response()->json(array('resultado'=> 'OK'));
        }catch(\PDOException $e){
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }
}