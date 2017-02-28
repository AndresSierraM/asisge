<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
      
class EvaluacionAccion extends Model

{                       
     protected $table ='evaluacionaccion'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idEvaluacionAccion'; //camello
	
	protected $fillable = ['EvaluacionDesempenio_idEvaluacionDesempenio','actividadEvaluacionAccion','Tercero_idResponsable','DocumentoSoporte_idDocumentoSoporte','fechaPlaneadaEvaluacionAccion','fechaEjecutadaEvaluacionAccion'];


	public $timestamps = false;


	public function EvaluacionDesempenio()
    {
        return $this->hasOne('App\EvaluacionDesempenio','idEvaluacionDesempenio');
    }


	
}
