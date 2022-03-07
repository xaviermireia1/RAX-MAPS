<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nick_usu');
            $table->string('contra_usu');
            $table->string('correo_usu');
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_equipo');

            $table->foreign('id_rol')->references('id')->on('tbl_rol');
            $table->foreign('id_equipo')->references('id')->on('tbl_equipo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_usuario');
    }
}
