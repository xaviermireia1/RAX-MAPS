<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_etiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_etiqueta')->insert([//1
            'nombre_eti' => 'Ocio',
            'icono_eti' =>'sys_ocio',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//2
            'nombre_eti' => 'Museo',
            'icono_eti' =>'sys_museo',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//3
            'nombre_eti' => 'Restaurante',
            'icono_eti' =>'sys_restaurante',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//4
            'nombre_eti' => 'Playa',
            'icono_eti' =>'sys_playa',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//5
            'nombre_eti' => 'Hotel',
            'icono_eti' =>'sys_hotel',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//6
            'nombre_eti' => 'Supermercado',
            'icono_eti' =>'sys_supermercado',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//7
            'nombre_eti' => 'Bar',
            'icono_eti' =>'sys_bar',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//8
            'nombre_eti' => 'Hospital',
            'icono_eti' =>'sys_hospital',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//9
            'nombre_eti' => 'Parque',
            'icono_eti' =>'sys_parque',
            'id_usuario' => 1
        ]);
        DB::table('tbl_etiqueta')->insert([//9
            'nombre_eti' => 'Favorito',
            'icono_eti' =>'sys_fav',
            'id_usuario' => 5
        ]);
        DB::table('tbl_etiqueta')->insert([//9
            'nombre_eti' => 'Favorito',
            'icono_eti' =>'sys_fav',
            'id_usuario' => 6
        ]);
        DB::table('tbl_etiqueta')->insert([//9
            'nombre_eti' => 'Favorito',
            'icono_eti' =>'sys_fav',
            'id_usuario' => 7
        ]);
        DB::table('tbl_etiqueta')->insert([//9
            'nombre_eti' => 'Favorito',
            'icono_eti' =>'sys_fav',
            'id_usuario' => 8
        ]);
    }
}
