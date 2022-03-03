<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'administrador'
        ]);
        DB::table('tbl_rol')->insert([
            'nombre_rol' => 'cliente'
        ]);
    }
}
