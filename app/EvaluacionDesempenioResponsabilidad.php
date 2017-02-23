<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDesempenioResponsabilidad extends Model
{
     protected $table ='evaluacionresponsabilidad'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEvaluacionResponsabilidad'; //camello
	
	protected $fillable = ['EvaluacionDesempenio_idEvaluacionDesempenio','CargoResponsabilidad_idCargoResponsabilidad','respuestaEvaluacionResponsabilidad'];


	public $timestamps = false;


	public function EvaluacionDesempenio()
    {
        return $this->hasOne('App\EvaluacionDesempenio','idEvaluacionDesempenio');
    }


public function CargoResponsabilidad()
	{
		return $this->hasMany('App\CargoResponsabilidad','idCargoResponsabilidad');
    }
	
}
