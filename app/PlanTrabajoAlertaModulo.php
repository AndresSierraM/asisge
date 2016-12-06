<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanTrabajoAlertaModulo extends Model
{
     protected $table ='plantrabajoalertamodulo'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idPlanTrabajoAlertaModulo'; //camello
	
	protected $fillable = [ 'PlanTrabajoAlerta_idPlanTrabajoAlerta', 'Modulo_idModulo'];


									      //modelo para la multiregistro
	public $timestamps = false;

}
