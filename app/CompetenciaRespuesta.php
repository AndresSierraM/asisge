<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenciaRespuesta extends Model
{
    
    protected $table ='competenciarespuesta'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idCompetenciaRespuesta'; //camello
	
	protected $fillable =['respuestaCompetenciaRespuesta','porcentajeNormalCompetenciaRespuesta','porcentajeInversoCompetenciaRespuesta'];



	public $timestamps = false;

// public function Entrevista()
// 	{
// 		return $this->hasOne('App\Entrevista','idEntrevista');
//     }



public function EntrevistaCompetencia()
	{
 		return $this->hasMany('App\EntrevistaCompetencia','CompetenciaRespuesta_idCompetenciaRespuesta');
     }


    
}



