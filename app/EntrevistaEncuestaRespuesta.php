<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntrevistaEncuestaRespuesta extends Model
{
    
    protected $table ='entrevistaencuestarespuesta'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEntrevistaEncuestaRespuesta'; //camello
	
	protected $fillable = ['Entrevista_idEntrevista','EncuestaPregunta_idEncuestaPregunta','valorEntrevistaEncuestaRespuesta']; 


	public $timestamps = false;



public function entrevista()
	{
		return $this->hasOne('App\entrevista','idEntrevista');
    }




    
}



