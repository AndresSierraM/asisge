<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaLimite extends Model
{
    protected $table = 'planemergencialimite';
    protected $primaryKey = 'idPlanEmergenciaLimite';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','sedePlanEmergenciaLimite','nortePlanEmergenciaLimite', 'surPlanEmergenciaLimite','orientePlanEmergenciaLimite','occidentePlanEmergenciaLimite'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }
}
