<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPistaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pista', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_pista');
            $table->string('descripcion_pista');
            $table->unsignedBigInteger('id_objetivo');

            $table->foreign('id_objetivo')->references('id')->on('tbl_objetivo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pista');
    }
}
