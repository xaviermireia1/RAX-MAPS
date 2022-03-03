<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Requests\LoginValidacion;

class DireccionesController extends Controller
{
    //Mostrar
    public function mostrarEtiqueta(){
        $listaEtiquetas = DB::table('tbl_etiqueta')->select('*')->get();
        return view('mostrar', compact('listaEtiquetas'));
    }

    //Crear
    public function crearEtiquetasPost(Request $request){
        $datos = $request->except('_token');
        try{
            DB::beginTransaction();
            DB::table('tbl_etiqueta')->insertGetId(['nombre_eti'=>$datos['nombre_eti'],'icono_eti'=>$datos['icono_eti'],'id_usuario'=>$datos['id_usuario']]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');
    }

    //Modificar
    public function modificarEtiquetaPut(Request $request){
        $datos = $request->except('_token','_method');
        try{
            DB::beginTransaction();
            DB::table('tbl_etiqueta')->where('id','=',$datos['id'])->update($datos);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');
    }

    //Eliminar
    public function eliminarEtiquetas($id){
        try{
            DB::beginTransaction();
            DB::table('tbl_etiqueta')->where('id','=',$id)->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
