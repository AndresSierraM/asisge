<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDesempenioFormacion extends Model

{
     protected $table ='evaluacionformacion'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEvaluacionFormacion'; //camello
	
	protected $fillable = ['EvaluacionDesempenio_idEvaluacionDesempenio','PerfilCargo_idRequerido','PerfilCargo_idAspirante','calificacionEvaluacionFormacion'];


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
