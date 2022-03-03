<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            tbl_rolSeeder::class,
            tbl_equipoSeeder::class,
            tbl_gincanaSeeder::class,
            tbl_ubicacionSeeder::class,
            tbl_objetivoSeeder::class,
            tbl_pistaSeeder::class,
            tbl_usuarioSeeder::class,
            tbl_etiquetaSeeder::class,
            tbl_registroSeeder::class,
        ]);
    }
}
