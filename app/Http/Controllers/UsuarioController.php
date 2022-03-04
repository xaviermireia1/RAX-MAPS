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
    //Funciones propias
    public function login(){
        return view('login_register');
    }

    public function loginPost(Request $request){
        $datos= $request->except('_token','_method');
        $user=DB::table("tbl_rol")->join('tbl_user', 'tbl_rol.id', '=', 'tbl_user.id_rol')->where('correo_user','=',$datos['correo_user'])->where('pass_user','=',$datos['pass_user'])->first();
        if($user->nombre_rol=='administrador'){
           $request->session()->put('nombre_admin',$request->correo_usu);
           return redirect('');
        }if($user->nombre_rol=='cliente'){
            $request->session()->put('nombre_user',$request->correo_usu);
            return redirect('');
        }
        return redirect('');
    }

    public function registraUsuario(LoginValidacion $request){
        $datos= $request->except('_token','_method');
        $rol = "administrador";
        $equipo = 2;
        try{
            DB::beginTransaction();
            DB::table('tbl_usuario')->insertGetId(['nick_usu'=>$datos['nick_usu'],'contra_usu'=>$datos['contra_usu'],'correo_usu'=>$datos['correo_usu'],'id_rol'=>$rol,'id_equipo'=>$equipo]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        $request->session()->put('nombre_user',$request->correo_usu);
        return redirect('');
    }

    public function logout(Request $request){
        $request->session()->forget('nombre_admin');
        $request->session()->forget('nombre_user');
        $request->session()->flush();
        return redirect('');
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
