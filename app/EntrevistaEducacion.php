<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaEducacion extends Model
{
     protected $table ='entrevistaeducacion'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaEducacion'; //camello
	
	protected $fillable = ['PerfilCargo_idRequerido','PerfilCargo_idAspirante','calificacionEntrevistaEducacion','Entrevista_idEntrevista'];


	public $timestamps = false;



public function Entrevista()
	{
		return $this->hasOne('App\Entrevista','idEntrevista');
    }
	
}
