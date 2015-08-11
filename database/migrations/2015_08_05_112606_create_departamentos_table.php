<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idDepartamento');
            $table->string('codigoDepartamento',20);
            $table->string('nombreDepartamento',80);
            $table->integer('Pais_idPais')->unsigned();
            $table->index('codigoDepartamento');
            $table->index('nombreDepartamento');
            $table->foreign('Pais_idPais')->references('idPais')->on('pais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('departamento');
    }
}
