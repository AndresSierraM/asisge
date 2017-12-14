<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaDefinicion1 extends Model
{
    protected $table = 'planemergenciadefinicion1';
    protected $primaryKey = 'idPlanEmergenciaDefinicion1';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','procedimientoEmergenciaPlanEmergenciaDefinicion1','sistemaAlertaPlanEmergenciaDefinicion1','notificacionInternaPlanEmergenciaDefinicion1','rutasEvacuacionPlanEmergenciaDefinicion1'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }

}
