<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblParticipacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_participacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_gincana');
            $table->unsignedBigInteger('id_equipo');
            $table->unsignedBigInteger('estado');

            $table->foreign('id_gincana')->references('id')->on('tbl_gincana');
            $table->foreign('id_equipo')->references('id')->on('tbl_equipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_participacion');
    }
}
