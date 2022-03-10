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
        $user=DB::table("tbl_rol")->join('tbl_usuario', 'tbl_rol.id', '=', 'tbl_usuario.id_rol')->where('correo_usu','=',$datos['correo_usu'])->where('contra_usu','=',$passMD5)->select('tbl_rol.nombre_rol', 'tbl_usuario.*')->first();
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
        return redirect('');
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
        return view('miPerfil');       
    }


    //CRUD AJAX
    //MOSTRAR
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

    public function unirseEquipo(Request $request, $id){
        $datos = $request->except('_token');

        if (session()->has('id_usuario')) {
            $idUsuario = session()->get('id_usuario');
        }

        $equipo = DB::table('tbl_equipo')->where('id','=',$id)->select('contra_equ')->first();

        if(count($equipo) == 0){
            try {
                DB::beginTransaction();
                DB::table('tbl_usuario')->where('id','=',$idUsuario)->update(['id_equipo '=>$id]);
                DB::commit();
                return response()->json(array('resultado'=> 'OK'));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
            }
        }else{
            $equipoContraseña = DB::table('tbl_equipo')->where('id','=',$id)->select('*')->first();
            if($datos['nombre_equ'] == $equipoContraseña['nombre_equ'] && $datos['contra_equ'] == $equipoContraseña['contra_equ']){
                try{
                    DB::beginTransaction();
                    DB::table('tbl_usuario')->where('id','=',$idUsuario)->update(['id_equipo '=>$id]);
                    DB::commit();
                    return response()->json(array('resultado'=> 'OK'));
                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(array('resultado'=> 'NOK: '.$e->getMessage()));
                }
            }
        }
    }

    //Eliminar
    //Darse de baja
    public function eliminarUsuario($id){
        try{
            DB::beginTransaction();
            DB::table('tbl_usuario')->where('id','=',$id)->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }

    //CREAR
    public function crearEquipoPost(Request $request){
        $datos = $request->except('_token');
        try{
            DB::beginTransaction();
            DB::table('tbl_equipo')->insertGetId(['nombre_equ'=>$datos['nombre_equ'],'contra_equ'=>$datos['contra_equ']]);
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
}
