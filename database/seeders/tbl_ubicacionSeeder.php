<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tbl_ubicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Hotel W',
            'descripcion_ubi' => 'Hotel a la última con bar y piscina',
            'latitud_ubi' => '41.36845043141273',
            'longitud_ubi' => '2.1901571862090816',
            'direccion_ubi' => 'Plaça Rosa Del Vents 1, Final, Passeig de Joan de Borbó, 08039 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Hotel W skybar',
            'descripcion_ubi' => 'Restaurante que se encuentra en el Hotel W',
            'latitud_ubi' => '41.36877798046046',
            'longitud_ubi' => '2.1899473512523056',
            'direccion_ubi' => 'W Barcelona, Plaça de la Rosa dels Vents, 1, 08039, Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Maná 75',
            'descripcion_ubi' => 'Restaurante espacioso y luminoso, especializado en paella y platos de la gastronomía catalana, con terraza.',
            'latitud_ubi' => '41.36886890000001',
            'longitud_ubi' => '2.1882268802683553',
            'direccion_ubi' => 'Passeig de Joan de Borbó, 101, 08039 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Playa de San Sebastián',
            'descripcion_ubi' => 'Playa más larga de Barcelona, con vistas panorámicas y la moderna estatua "Homenaje a la natación" de Alfredo Lanz.',
            'latitud_ubi' => '41.37027732574918',
            'longitud_ubi' => '2.1890902999413355',
            'direccion_ubi' => 'Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Playa de Sant Miquel',
            'descripcion_ubi' => 'Concurrida playa urbana ideal para bañarse y tomar el sol, con socorristas, instalaciones deportivas y restaurantes.',
            'latitud_ubi' => '41.37683880275199',
            'longitud_ubi' => '2.1912724055517034',
            'direccion_ubi' => 'Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Playa de la Barceloneta',
            'descripcion_ubi' => 'Playa popular para bañarse y tomar el sol, con numerosos servicios como socorristas, alquiler de tumbonas y Wi‑Fi.',
            'latitud_ubi' => '41.37837646560126',
            'longitud_ubi' => '2.192452577454986',
            'direccion_ubi' => 'Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Museo de historia de Cataluña',
            'descripcion_ubi' => 'Museo situado en un almacén del siglo XIX, junto al mar, que describe la historia catalana desde sus orígenes.',
            'latitud_ubi' => '41.380803267098116',
            'longitud_ubi' => '2.1858779891395375',
            'direccion_ubi' => 'Pl. de Pau Vila, 3, 08039 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Mercado de la Barceloneta',
            'descripcion_ubi' => 'Bares de tapas concurridos y animados puestos de pescado y de carne en una emblemática estructura del siglo XIX.',
            'latitud_ubi' => '41.380415701477425',
            'longitud_ubi' => '2.1891968853928603',
            'direccion_ubi' => 'Pl. del Poeta Boscà, 1, 08003 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Lidl la Barceloneta',
            'descripcion_ubi' => 'Supermercado de descuentos',
            'latitud_ubi' => '41.38097662643059',
            'longitud_ubi' => '2.1899535197047793',
            'direccion_ubi' => 'Carrer de la Maquinista, 46-48, 08003 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Hospital del mar',
            'descripcion_ubi' => 'Hospital general',
            'latitud_ubi' => '41.38449837858989',
            'longitud_ubi' => '2.1939330774228316',
            'direccion_ubi' => 'Passeig Marítim de la Barceloneta, 25, 29, 08003 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Parque de la Barceloneta',
            'descripcion_ubi' => 'Parque con un campo de fútbol, una cancha de baloncesto, senderos arbolados, un bar y vistas al mar.',
            'latitud_ubi' => '41.38276572112852',
            'longitud_ubi' => '2.1923881289495744',
            'direccion_ubi' => 'Passeig Marítim de la Barceloneta, 15, 08002 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Pacha Barcelona',
            'descripcion_ubi' => 'Discoteca a la última que sirve platos de cocina mediterránea y asiática con una terraza frente al mar.',
            'latitud_ubi' => '41.3857434045326',
            'longitud_ubi' => '2.1970624166823183',
            'direccion_ubi' => 'Carrer de Ramon Trias Fargas, 2, 08005 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Casino de Barcelona',
            'descripcion_ubi' => 'Casino de ambiente informal con ruleta americana, póquer, máquinas tragaperras, restaurantes y espectáculos.',
            'latitud_ubi' => '41.38668575053344',
            'longitud_ubi' => '2.197070828718148',
            'direccion_ubi' => 'Carrer de la Marina, 19, 21, 08005 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Bar Piñol',
            'descripcion_ubi' => 'Bar de tapas',
            'latitud_ubi' => '41.380511516070754',
            'longitud_ubi' => '2.191674224199741',
            'direccion_ubi' => 'Carrer de Andrea Dòria, 28, 08003 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Bar Leo',
            'descripcion_ubi' => 'Legendario bar de tapas de barrio de ambiente flamenco decorado con recuerdos del difunto cantaor Bambino.',
            'latitud_ubi' => '41.379477050359924',
            'longitud_ubi' => '2.190940171047179',
            'direccion_ubi' => 'Carrer de Sant Carles, 34, 08003 Barcelona'
        ]);
        DB::table('tbl_ubicacion')->insert([
            'nombre_ubi' => 'Opium Barcelona',
            'descripcion_ubi' => 'Restaurante a la última que ofrece datos eclécticos de cocina internacional y un bar de sushi con sofás y vistas al mar.',
            'latitud_ubi' => '41.38535296102044',
            'longitud_ubi' => '2.196781296252854',
            'direccion_ubi' => 'Passeig Marítim de la Barceloneta, 34, 08003 Barcelona'
        ]);
    }
}
