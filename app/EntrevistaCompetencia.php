<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaCompetencia extends Model
{
    
    protected $table ='entrevistacompetencia'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaCompetencia'; //camello
	
	protected $fillable =['Entrevista_idEntrevista','CompetenciaPregunta_idCompetenciaPregunta','valorEntrevistaCompetencia'];

	public $timestamps = false;



public function CompetenciaRespuesta()
	{
		return $this->hasOne('App\CompetenciaRespuesta','idCompetenciaRespuesta');
    }



public function CompetenciaPregunta()
	{
		return $this->hasOne('App\CompetenciaPregunta','idCompetenciaPregunta');
    }


    
}



