<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAuditoriaAcompanante extends Model
{
    protected $table = 'planauditoriaacompanante';
    protected $primaryKey = 'idPlanAuditoriaAcompanante';

    protected $fillable = ['PlanAuditoria_idPlanAuditoria', 'Tercero_idAcompanante'];

    public $timestamps = false;

    function planAuditoria()
    {
		return $this->hasOne('App\PlanAuditoria','idPlanAuditoria');
    }
}
