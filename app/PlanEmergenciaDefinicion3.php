<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaDefinicion3 extends Model
{
    protected $table = 'planemergenciadefinicion3';
    protected $primaryKey = 'idPlanEmergenciaDefinicion3';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','capacitacionSimulacroPlanEmergenciaDefinicion3','analisisVulnerabilidadPlanEmergenciaDefinicion3','listaAnexosPlanEmergenciaDefinicion3'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }

}
