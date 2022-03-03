<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_gincanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_gincana')->insert([
            'nombre_gin' => 'Juego DAW',
            'descripcion_gin' =>'Gincana en la Barceloneta por diferentes puntos de la zona. ¡Sigue las pistas para llegar a la meta!'
        ]);
    }
}
