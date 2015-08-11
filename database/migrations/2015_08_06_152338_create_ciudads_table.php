<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciudad', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idCiudad');
            $table->string('codigoCiudad',20);
            $table->string('nombreCiudad',80);
            $table->integer('Departamento_idDepartamento')->unsigned();
            $table->index('codigoCiudad');
            $table->index('nombreCiudad');
            $table->foreign('Departamento_idDepartamento')->references('idDepartamento')->on('departamento')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ciudad');
    }
}
