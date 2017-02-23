<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDesempenioHabilidad extends Model

{
     protected $table ='evaluacionhabilidad'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEvaluacionHabilidad'; //camello
	
	protected $fillable = ['EvaluacionDesempenio_idEvaluacionDesempenio','PerfilCargo_idRequerido','PerfilCargo_idAspirante','calificacionEvaluacionHabilidad'];


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
