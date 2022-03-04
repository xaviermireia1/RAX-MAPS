<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_registroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 5,
            'id_ubicacion' => 1
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 3,
            'id_ubicacion' => 2
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 3,
            'id_ubicacion' => 3
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 4,
            'id_ubicacion' => 4
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 4,
            'id_ubicacion' => 5
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 4,
            'id_ubicacion' => 6
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 2,
            'id_ubicacion' => 7
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 6,
            'id_ubicacion' => 8
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 6,
            'id_ubicacion' => 9
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 8,
            'id_ubicacion' => 10
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 9,
            'id_ubicacion' => 11
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 8,
            'id_ubicacion' => 12
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 8,
            'id_ubicacion' => 13
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 7,
            'id_ubicacion' => 14
        ]);
        DB::table('tbl_registro')->insert([
            'id_etiqueta' => 7,
            'id_ubicacion' => 15
        ]);
    }
}
