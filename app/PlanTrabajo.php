<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanTrabajo extends Model
{
    protected $table = 'plantrabajo';
    protected $primaryKey = 'idPlanTrabajo';

    protected $fillable = ['numeroPlanTrabajo', 'asuntoPlanTrabajo', 'fechaPlanTrabajo', 'Tercero_idAuditor', 'firmaAuditorPlanTrabajo', 'Compania_idCompania'];

    public $timestamps = false;

    public function plantrabajodetalle()
    {
        return $this->hasMany('App\PlanTrabajoDetalle','PlanTrabajo_idPlanTrabajo');
    }
}
