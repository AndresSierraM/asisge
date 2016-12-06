<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
     protected $table ='competencia'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idCompetencia'; //camello
	
	protected $fillable = ['nombreCompetencia', 'estadoCompetencia'];

	public $timestamps = false;

	public function competenciapregunta()
	{
		return $this->hasMany('App\CompetenciaPregunta','Competencia_idCompetencia');
    }
}
