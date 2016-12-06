<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    
    protected $table ='entrevista'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevista'; //camello
	
	protected $fillable = ['documentoAspiranteEntrevista', 'estadoEntrevista', 'nombreAspiranteEntrevista', 'fechaEntrevista', 'Tercero_idEntrevistador','Cargo_idCargo','experienciaAspiranteEntrevista','experienciaRequeridaEntrevista'];



	public $timestamps = false;
}
