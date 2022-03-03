<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_usuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'sistema',
            'correo_usu' => 'sistema@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => 1,
            'id_equipo' => 1
        ]);
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'arnau',
            'correo_usu' => 'arnau@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => 1,
            'id_equipo' => 1
        ]);
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'raul',
            'correo_usu' => 'raul@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => 1,
            'id_equipo' => 1
        ]);
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'xavi',
            'correo_usu' => 'xavi@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => 1,
            'id_equipo' => 1
        ]);
        DB::table('tbl_usuario')->insert([
            'nick_usu' => 'sergio',
            'correo_usu' => 'sergio@gmail.com',
            'contra_usu' => MD5('1234'),
            'id_rol' => 2,
            'id_equipo' => 2
        ]);
    }
}
