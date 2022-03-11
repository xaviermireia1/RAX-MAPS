<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_objetivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_objetivo')->insert([
            'nombre_obj' => 'Hace referencia a un elemento de un barco y a un edificio',
            'id_ubicacion' => 1,
            'id_gincana' => 1
        ]);
    }
}
