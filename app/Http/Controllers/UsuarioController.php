<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Requests\LoginValidacion;
use App\Http\Requests\LoginValidacion2;

class UsuarioController extends Controller
{
    //Login + Logout
    public function login(){
        return view('login_register');
    }

    public function loginPost(LoginValidacion2 $request){
        $datos= $request->except('_token','_method');
        $passMD5 = md5($datos['contra_usu']);
        $countUser=DB::table("tbl_rol")->join('tbl_usuario', 'tbl_rol.id', '=', 'tbl_usuario.id_rol')->where('correo_usu','=',$datos['correo_usu'])->where('contra_usu','=',$passMD5)->select('tbl_rol.nombre_rol', 'tbl_usuario.*')->count();
        $user=DB::table("tbl_rol")->join('tbl_usuario', 'tbl_rol.id', '=', 'tbl_usuario.id_rol')->where('correo_usu','=',$datos['correo_usu'])->where('contra_usu','=',$passMD5)->select('tbl_rol.nombre_rol', 'tbl_usuario.*')->first();
        if($countUser!=0){
            if($user->nombre_rol=='administrador'){
            $request->session()->put('nombre',$request->correo_usu);
            $request->session()->put('id_usuario',$user->id);
            $request->session()->put('rol','administrador');
            return redirect('');
            }if($user->nombre_rol=='cliente'){
                $request->session()->put('nombre',$request->correo_usu);
                $request->session()->put('id_usuario',$user->id);
                $request->session()->put('rol','cliente');
                return redirect('');
            }
        }else{
            return redirect('login');
        }
    }

    public function registraUsuario(LoginValidacion $request){
        $datos= $request->except('_token','_method');
        $passMD5 = md5($datos['contra_usu']);
        $rol = 2;
        $equipo = NULL;
        $nombreEtiqueta = "Favorito";
        $iconoEtiqueta = "sys_fav";
        try{
            DB::beginTransaction();
            $userID = DB::table('tbl_usuario')->insertGetId(['nick_usu'=>$datos['nick_usu'],'contra_usu'=>$passMD5,'correo_usu'=>$datos['correo_usu'],'id_rol'=>$rol,'id_equipo'=>$equipo]);
            DB::table('tbl_etiqueta')->insertGetId(['nombre_eti'=>$nombreEtiqueta, 'icono_eti'=>$iconoEtiqueta, 'id_usuario'=>$userID]);
            DB::commit();
            $request->session()->put('nombre',$request->correo_usu);
            $request->session()->put('id_usuario',$userID);
            $request->session()->put('rol','cliente');
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');
    }

    public function logout(Request $request){
        $request->session()->forget('nombre');
        $request->session()->forget('rol');
        $request->session()->flush();
        return redirect('/');
    }

    //Mi Perfil
    public function perfil(){
        if (!session()->has('rol')) {
            return view('login_register');
        }
        $id = session()->get('id_usuario');
        $perfil = DB::select("SELECT usu.*, equ.nombre_equ FROM tbl_usuario usu
        left join tbl_equipo equ ON usu.id_equipo = equ.id
        where usu.id = $id");
        return view('miPerfil',compact('perfil'));
    }


    //CRUD AJAX
    //MOSTRAR
    public function mostrarPerfil(){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        $datosUsu=DB::table('tbl_usuario')->where('id','=',$idUsuario)->first();
        return response()->json($datosUsu);
    }

    public function mostrarUsuario(){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        $datosuser = DB::select("SELECT * FROM tbl_usuario where id = $idUsuario");
        //return view('mostrar', compact('listaEtiquetas'));
        return response()->json($datosuser);
    }
    //Mostrar Equipo
    public function mostrarEquipos(){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        $memberOfGroup = DB::select("SELECT * FROM tbl_usuario where id=$idUsuario AND !isnull(id_equipo)");
        if (count($memberOfGroup) > 0) {
            $idgroup = DB::select("SELECT id_equipo FROM tbl_usuario where id=$idUsuario");
            $idgroup = $idgroup[0]->id_equipo;
            $groups = DB::select("SELECT equ.*, usu.nick_usu from tbl_usuario usu
            left join tbl_equipo equ ON equ.id = usu.id_equipo
            where equ.id = $idgroup");
        }else{
            $groups = DB::select("SELECT * FROM tbl_equipo");
        }
        return response()->json($groups);
    }

    public function unirseEquipo(Request $request,$id){
        $datos = $request->except('_token');

        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }

        $equipo = DB::table('tbl_equipo')->where('id','=',$id)->select('contra_equ')->first();

        if($equipo->contra_equ == "" or $equipo->contra_equ == null){
            try {
                DB::beginTransaction();
                //DB::table('tbl_usuario')->where('id','=',$idUsuario)->update(['id_equipo '=>$id]);
                DB::select("UPDATE tbl_usuario SET id_equipo=$id where id=$idUsuario;");
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
            }
        }else{
            $equipoContraseña = DB::table('tbl_equipo')->where('id','=',$id)->select('*')->first();
            if($datos['contra_equ'] == $equipoContraseña->contra_equ){

                try{
                    DB::beginTransaction();
                    DB::select("UPDATE tbl_usuario SET id_equipo=$id where id=$idUsuario;");
                    $admin = DB::select("SELECT * FROM tbl_usuario where id=$idUsuario");
                    if ($admin[0]->id_equipo == 1) {
                        DB::select("UPDATE tbl_usuario SET id_equipo=1,id_rol=1 where id=$idUsuario");
                        $request->session()->forget('rol');
                        $request->session()->put('rol','administrador');
                    }
                    DB::commit();
                    return response()->json(array('resultado'=> 'OK'));
                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
                }
            }else{
                return response()->json(array('resultado'=> 'NOK'));
            }
        }
    }

    //Eliminar
    //Darse de baja
    public function darseDeBaja(){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }

        $idEti = DB::select("SELECT id FROM tbl_etiqueta WHERE id_usuario = $idUsuario");
        $idEqui = DB::select("SELECT id_equipo FROM tbl_usuario WHERE id = $idUsuario");
        $idEtiqueta= $idEti[0]->id;
        $idEquipo = $idEqui[0]->id_equipo;

        try{
            DB::beginTransaction();
            //DB::table('tbl_registro')->where('id_etiqueta','=',$idEtiqueta[0])->delete();
            DB::delete("DELETE FROM tbl_registro WHERE id_etiqueta = $idEtiqueta");
            //DB::table('tbl_etiqueta')->where('id_usuario','=',$idUsuario)->delete();
            DB::delete("DELETE FROM tbl_etiqueta WHERE id_usuario = $idUsuario");
            //DB::table('tbl_usuario')->where('id','=',$idUsuario)->delete();
            DB::delete("DELETE FROM tbl_usuario WHERE id = $idUsuario");
            if($idEquipo != NULL){
                if ($idEquipo != 1) {
                    $quantityMembers = DB::select("SELECT COUNT(usu.nick_usu) as quantitymembers FROM tbl_usuario usu
                    left join tbl_equipo equ ON usu.id_equipo=equ.id where id_equipo = $idEquipo");
                    if ($quantityMembers[0]->quantitymembers == 0) {
                        //DB::table('tbl_equipo')->where('id','=',$idEquipo)->delete();
                        DB::delete("DELETE FROM tbl_equipo WHERE id = $idEquipo");
                    }
                }
            }
            DB::commit();
            session()->flush();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK'));
        }
    }


    public function abandonarEquipo(){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
            $idgrupo = DB::select("SELECT * FROM tbl_usuario where id =$idUsuario");
            $idgrupo = $idgrupo[0]->id_equipo;
            $rol = session()->get('rol');
        }
        try{
            DB::beginTransaction();
            //DB::table('tbl_usuario')->where('id',$idUsuario)->update(['id_equipo'=>NULL]);
            DB::select("UPDATE tbl_usuario SET id_equipo=NULL,id_rol=2 where id=$idUsuario;");
            if ($rol == "administrador") {
                session()->forget('rol');
                session()->put('rol','cliente');
            }
            //Eliminar equipo en caso que llegue a 0 (si es administrador no se borra el registro);
            if ($idgrupo != 1) {
                $quantityMembers = DB::select("SELECT COUNT(usu.nick_usu) as quantitymembers FROM tbl_usuario usu
                left join tbl_equipo equ ON usu.id_equipo=equ.id
                where id_equipo = $idgrupo");
                if ($quantityMembers[0]->quantitymembers == 0) {
                    DB::table('tbl_equipo')->where('id','=',$idgrupo)->delete();
                }
            }
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }

    //CREAR
    public function crearEquipoPost(Request $request){
        $datos = $request->except('_token');
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        try{
            DB::beginTransaction();
            $id=DB::table('tbl_equipo')->insertGetId(['nombre_equ'=>$datos['nombre_equ'],'contra_equ'=>$datos['contra_equ']]);
            DB::select("UPDATE tbl_usuario SET id_equipo=$id where id=$idUsuario;");
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }
    //Modificar
    public function modificarEquipoPut(Request $request){
        $datos = $request->except('_token','_method');
        try{
            DB::beginTransaction();
            DB::table('tbl_equipo')->where('id','=',$datos['id'])->update($datos);
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }

    public function modificarPerfil(Request $request){
        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }
        $datos = $request->except('_token','_method');
        $passMD5=md5($datos['contra_usu']);
        $nick=$datos['nick_usu'];
        $correu=$datos['correo_usu'];

        try{
            DB::beginTransaction();
            //DB::table('tbl_usuario')->where('id','=',$idUsuario)->update($datos);
            DB::select("UPDATE tbl_usuario set nick_usu='$nick', correo_usu='$correu',contra_usu='$passMD5' where id=$idUsuario;");
            DB::commit();
            return response()->json(array('resultado'=> 'OK'));
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
        }
    }
}