<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAuditoria extends Model
{
    protected $table = 'planauditoria';
    protected $primaryKey = 'idPlanAuditoria';

    protected $fillable = ['numeroPlanAuditoria', 'fechaInicioPlanAuditoria', 'fechaFinPlanAuditoria', 'organismoPlanAuditoria', 'Tercero_AuditorLider', 'objetivoPlanAuditoria', 'alcancePlanAuditoria', 'criterioPlanAuditoria','criterioPlanAuditoria','recursosPlanAuditoria','observacionesPlanAuditoria','aprobacionPlanAuditoria','fechaEntregaPlanAuditoria'];

    public $timestamps = false;

    function planAuditoriaAcompanantes()
    {
		return $this->hasMany('App\PlanAuditoriaAcompanante','PlanAuditoria_idPlanAuditoria');
    }

    function planAuditoriaNotificados()
    {
		return $this->hasMany('App\PlanAuditoriaNotificado','PlanAuditoria_idPlanAuditoria');
    }

    function planAuditoriaAgendas()
    {
		return $this->hasMany('App\PlanAuditoriaAgenda','PlanAuditoria_idPlanAuditoria');
    }
}
