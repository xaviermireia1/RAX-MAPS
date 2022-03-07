<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Requests\LoginValidacion;

class UsuarioController extends Controller
{
    //Login + Logout
    public function login(){
        return view('login_register');
    }

    public function loginPost(Request $request){
        $datos= $request->except('_token','_method');
        $passMD5 = md5($datos['contra_usu']);
        $user=DB::table("tbl_rol")->join('tbl_usuario', 'tbl_rol.id', '=', 'tbl_usuario.id_rol')->where('correo_usu','=',$datos['correo_usu'])->where('contra_usu','=',$passMD5)->first();
        if($user->nombre_rol=='administrador'){
           $request->session()->put('nombre',$request->correo_usu);
           $request->session()->put('id_usuario',$request->id);
           $request->session()->put('rol','administrador');
           return redirect('');
        }if($user->nombre_rol=='cliente'){
            $request->session()->put('nombre',$request->correo_usu);
            $request->session()->put('id_usuario',$request->id);
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
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        $request->session()->put('nombre',$request->correo_usu);
        $request->session()->put('id_usuario',$request->id);
        $request->session()->put('rol','cliente');
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
        return view('miPerfil');
    }

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login_register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
