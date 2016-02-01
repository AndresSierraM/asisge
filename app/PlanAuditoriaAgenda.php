<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAuditoriaAgenda extends Model
{
    protected $table = 'planauditoriaagenda';
    protected $primaryKey = 'idPlanAuditoriaAgenda';

    protected $fillable = ['PlanAuditoria_idPlanAuditoria', 'Proceso_idProceso', 'Tercero_Auditado', 'Tercero_Auditor', 'fechaPlanAuditoriaAgenda','horaInicioPlanAuditoriaAgenda','horaFinPlanAuditoriaAgenda','lugarPlanAuditoriaAgenda'];

    public $timestamps = false;

    function planAuditoria()
    {
		return $this->hasOne('App\PlanAuditoria','idPlanAuditoria');
    }
}
