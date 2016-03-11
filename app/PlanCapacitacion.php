<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCapacitacion extends Model
{
	protected $table = 'plancapacitacion';
    protected $primaryKey = 'idPlanCapacitacion';

    protected $fillable = ['tipoPlanCapacitacion', 'nombrePlanCapacitacion', 'objetivoPlanCapacitacion', 'Tercero_idResponsable', 'personalInvolucradoPlanCapacitacion', 'fechaInicioPlanCapacitacion', 'fechaFinPlanCapacitacion', 'metodoEficaciaPlanCapacitacion','Compania_idCompania'];

    public $timestamps = false;

    function planCapacitacionTemas()
    {
		return $this->hasMany('App\PlanCapacitacionTema','PlanCapacitacion_idPlanCapacitacion');
    }
}
