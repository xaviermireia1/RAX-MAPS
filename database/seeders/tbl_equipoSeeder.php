<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_equipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_equipo')->insert([
            'nombre_equ' => 'administradores',
            'contra_equ' => 'qweQWE123'
        ]);
        DB::table('tbl_equipo')->insert([
            'nombre_equ' => 'Profesores',
            'contra_equ' => 'laravel'
        ]);
    }
}
