<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_pistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_pista')->insert([
            'nombre_pista' => 'Pista 1',
            'descripcion_pista' => 'Contiene la letra W.',
            'id_objetivo' => 1
        ]);
    }
}
