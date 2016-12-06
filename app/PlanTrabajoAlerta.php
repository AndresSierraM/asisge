<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanTrabajoAlerta extends Model

//modelo para la primera parte del formulario encabezado 
{
     protected $table ='plantrabajoalerta'; //la tabla siempre es en miniscula 
	protected $primaryKey = 'idPlanTrabajoAlerta'; //camello
	
	protected $fillable = ['nombrePlanTrabajoAlerta', 'correoParaPlanTrabajoAlerta','correoCopiaPlanTrabajoAlerta','correoCopiaOcultaPlanTrabajoAlerta','correoAsuntoPlanTrabajoAlerta','correoMensajePlanTrabajoAlerta','tareaFechaInicioPlanTrabajoAlerta','tareaHoraPlanTrabajoAlerta','tareaIntervaloPlanTrabajoAlerta','tareaDiasPlanTrabajoAlerta','tareaMesesPlanTrabajoAlerta','filtroMesesPasadosPlanTrabajoAlerta','filtroMesesFuturosPlanTrabajoAlerta','filtroEstadosPlanTrabajoAlerta'];


									      // hasta aca primer formulario correomensajeplantrabajoalerta
	public $timestamps = false;

}
	