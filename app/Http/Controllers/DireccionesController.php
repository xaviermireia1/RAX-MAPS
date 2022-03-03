<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class DireccionesController extends Controller
{
    //Crear
    public function crearDireccionPost(Request $request){
        $datos=$request->except('_token');
        try{
            DB::beginTransaction();
            DB::table('tbl_ubicacion')->insertGetId(['nombre_ubi'=>$datos['nombre_ubi'],'descripcion_ubi'=>$datos['descripcion_ubi'],'latitud_ubi'=>$datos['latitud_ubi'],'longitud_ubi'=>$datos['longitud_ubi'],'direccion_ubi'=>$datos['direccion_ubi']]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');
    }

    //Modificar
    public function modificarDireccionPost(Request $request){
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

    //Mostrar

    //Eliminar
    public function eliminarDireccionPost($id){
        try{
            DB::beginTransaction();
            DB::table('tbl_ubicacion')->where('id','=',$id)->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
        return redirect('');

    }
}
