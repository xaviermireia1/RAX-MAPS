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
            'nombre_obj' => 'Pache, Pachi, Pacho, Pachu. ¿Cuál falta?',
            'id_ubicacion' => 12,
            'id_gincana' => 1
        ]);
        
        DB::table('tbl_objetivo')->insert([
            'nombre_obj' => 'No es la Ciutadella, pero lo intenta.',
            'id_ubicacion' => 11,
            'id_gincana' => 1
        ]);

        DB::table('tbl_objetivo')->insert([
            'nombre_obj' => 'Si eres independentista y quieres saber la historia de tu país, este es tu sitio.',
            'id_ubicacion' => 7,
            'id_gincana' => 1
        ]);

        DB::table('tbl_objetivo')->insert([
            'nombre_obj' => 'Me apetece una birra. MESSIrve este bar.',
            'id_ubicacion' => 15,
            'id_gincana' => 1
        ]);

        DB::table('tbl_objetivo')->insert([
            'nombre_obj' => 'La playa tiene el nombre de un compañero de clase',
            'id_ubicacion' => 5,
            'id_gincana' => 1
        ]);

        DB::table('tbl_objetivo')->insert([
            'nombre_obj' => 'Hace referencia a un elemento de un barco y a un edificio',
            'id_ubicacion' => 1,
            'id_gincana' => 1
        ]);

    }
}
