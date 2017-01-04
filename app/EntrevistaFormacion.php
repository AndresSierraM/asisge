<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaFormacion extends Model
{
     protected $table ='entrevistaformacion'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaFormacion'; //camello
	
	protected $fillable = ['PerfilCargo_idRequerido','PerfilCargo_idAspirante','calificacionEntrevistaFormacion','Entrevista_idEntrevista'];


	public $timestamps = false;



public function Entrevista()
	{
		return $this->hasMany('App\Entrevista','idEntrevista');
    }

}



