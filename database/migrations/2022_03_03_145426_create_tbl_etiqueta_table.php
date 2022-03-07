<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblEtiquetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_etiqueta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_eti');
            $table->enum('icono_eti', ['bien', 'mal', 'lupa', 'globo', 'sys_hotel', 'sys_museo', 'sys_supermercado', 'sys_restaurante', 'sys_playa', 'sys_bar', 'sys_ocio', 'sys_hospital', 'sys_parque', 'sys_fav']);
            $table->unsignedBigInteger('id_usuario');

            $table->foreign('id_usuario')->references('id')->on('tbl_usuario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_etiqueta');
    }
}
