<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDesempenioEducacion extends Model

{
     protected $table ='evaluacioneducacion'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEvaluacionEducacion'; //camello
	
	protected $fillable = ['EvaluacionDesempenio_idEvaluacionDesempenio','PerfilCargo_idRequerido','PerfilCargo_idAspirante',
	'calificacionEvaluacionEducacion'];


	public $timestamps = false;


	public function EvaluacionDesempenio()
    {
        return $this->hasOne('App\EvaluacionDesempenio','idEvaluacionDesempenio');
    }

    public function PerfilCargo()
    {
        return $this->hasOne('App\PerfilCargo','idPerfilCargo');
    }

	
}
