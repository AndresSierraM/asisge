<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoIdentificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoidentificacion', function (Blueprint $table) {
            $table->increments('idTipoIdentificacion');
            $table->string('codigoTipoIdentificacion',20);
            $table->string('nombreTipoIdentificacion',80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipoidentificacion');
    }
}
