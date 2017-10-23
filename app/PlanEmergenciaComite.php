<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaComite extends Model
{
    protected $table = 'planemergenciacomite';
    protected $primaryKey = 'idPlanEmergenciaComite';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','comitePlanEmergenciaComite','integrantesPlanEmergenciaComite', 'funcionesPlanEmergenciaComite','antesPlanEmergenciaComite','durantePlanEmergenciaComite','despuesPlanEmergenciaComite'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }
}
