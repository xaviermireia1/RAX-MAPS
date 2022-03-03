<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblObjetivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_objetivo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_obj');
            $table->unsignedBigInteger('id_ubicacion');
            $table->unsignedBigInteger('id_gincana');

            $table->foreign('id_ubicacion')->references('id')->on('tbl_ubicacion');
            $table->foreign('id_gincana')->references('id')->on('tbl_gincana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_objetivo');
    }
}
