<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaDefinicion2 extends Model
{
    protected $table = 'planemergenciadefinicion2';
    protected $primaryKey = 'idPlanEmergenciaDefinicion2';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','sistemaComunicacionPlanEmergenciaDefinicion2','coordinacionSocorroPlanEmergenciaDefinicion2','cesePeligroPlanEmergenciaDefinicion2'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }

}
