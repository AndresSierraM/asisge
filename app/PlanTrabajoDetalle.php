<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanTrabajoDetalle extends Model
{
    protected $table = 'plantrabajodetalle';
    protected $primaryKey = 'idPlanTrabajoDetalle';

    protected $fillable = ['PlanTrabajo_idPlanTrabajo','Modulo_idModulo', 'idConcepto', 'nombreConceptoPlanTrabajoDetalle', 'eneroPlanTrabajoDetalle', 'febreroPlanTrabajoDetalle', 'marzoPlanTrabajoDetalle', 'abrilPlanTrabajoDetalle', 'mayoPlanTrabajoDetalle', 'junioPlanTrabajoDetalle', 'julioPlanTrabajoDetalle', 'agostoPlanTrabajoDetalle', 'septiembrePlanTrabajoDetalle', 'octubrePlanTrabajoDetalle', 'noviembrePlanTrabajoDetalle', 'diciembrePlanTrabajoDetalle', 'presupuestoPlanTrabajoDetalle', 'costoRealPlanTrabajoDetalle', 'cumplimientoPlanTrabajoDetalle', 'metaPlanTrabajoDetalle','Tercero_idResponsable', 'observacionPlanTrabajoDetalle'];

    public $timestamps = false;

    public function plantrabajo()
    {
		return $this->hasOne('App\PlanTrabajo','idPlanTrabajo');
    }
}
