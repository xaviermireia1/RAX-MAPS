<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ubicacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_ubi');
            $table->string('descripcion_ubi');
            $table->string('latitud_ubi');
            $table->string('longitud_ubi');
            $table->string('direccion_ubi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ubicacion');
    }
}
