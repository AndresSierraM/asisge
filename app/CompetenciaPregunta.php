<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenciaPregunta extends Model
{
     protected $table ='competenciapregunta'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idCompetenciaPregunta'; //camello
	
	protected $fillable = ['idCompetenciaPregunta ','ordenCompetenciaPregunta','preguntaCompetenciaPregunta','respuestaCompetenciaPregunta','estadoCompetenciaPregunta','Competencia_idCompetencia'];
									      //modelo para la multiregistro
	public $timestamps = false;

	public function competencia()
	{
		return $this->hasOne('App\Competencia','idCompetencia');
    }


}
