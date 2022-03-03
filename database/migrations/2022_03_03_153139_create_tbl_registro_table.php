<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_registro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_etiqueta');
            $table->unsignedBigInteger('id_ubicacion');
            
            $table->foreign('id_etiqueta')->references('id')->on('tbl_etiqueta');
            $table->foreign('id_ubicacion')->references('id')->on('tbl_ubicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_registro');
    }
}
