<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergencia extends Model
{
    protected $table = 'planemergencia';
    protected $primaryKey = 'idPlanEmergencia';

    protected $fillable = ['fechaElaboracionPlanEmergencia','nombrePlanEmergencia','CentroCosto_idCentroCosto', 'justificacionPlanEmergencia','marcoLegalPlanEmergencia','definicionesPlanEmergencia','generalidadesPlanEmergencia','objetivosPlanEmergencia','alcancePlanEmergencia','nitPlanEmergencia','direccionPlanEmergencia','telefonoPlanEmergencia','ubicacionPlanEmergencia','personalOperativoPlanEmergencia','personalAdministrativoPlanEmergencia','turnoOperativoPlanEmergencia','turnoAdministrativoPlanEmergencia','visitasDiaPlanEmergencia','procedimientoEmergenciaPlanEmergencia','sistemaAlertaPlanEmergencia','notificacionInternaPlanEmergencia','rutasEvacuacionPlanEmergencia','sistemaComunicacionPlanEmergencia','coordinacionSocorroPlanEmergencia','cesePeligroPlanEmergencia','capacitacionSimulacroPlanEmergencia','analisisVulnerabilidadPlanEmergencia','listaAnexosPlanEmergencia','Tercero_idRepresentanteLegal','firmaRepresentantePlanEmergencia','Compania_idCompania'];

    public $timestamps = false;

    public function PlanEmergenciaLimite()
    {
		return $this->hasMany('App\PlanEmergenciaLimite','PlanEmergencia_idPlanEmergencia');
    }
 	public function PlanEmergenciaInventario()
    {
		return $this->hasMany('App\PlanEmergenciaInventario','PlanEmergencia_idPlanEmergencia');
    }
  	public function PlanEmergenciaComite()
    {
		return $this->hasMany('App\PlanEmergenciaComite','PlanEmergencia_idPlanEmergencia');
    }
    public function PlanEmergenciaNivel()
    {
		return $this->hasMany('App\PlanEmergenciaNivel','PlanEmergencia_idPlanEmergencia');
    }
  	public function PlanEmergenciaArchivo()
    {
		return $this->hasMany('App\PlanEmergenciaArchivo','PlanEmergencia_idPlanEmergencia');
    }
}
