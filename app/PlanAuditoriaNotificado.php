<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAuditoriaNotificado extends Model
{
    protected $table = 'planauditorianotificado';
    protected $primaryKey = 'idPlanCapacitacionNotificado';

    protected $fillable = ['PlanAuditoria_idPlanAuditoria', 'Tercero_idNotificado'];

    public $timestamps = false;

    function planAuditoria()
    {
		return $this->hasOne('App\PlanAuditoria','idPlanAuditoria');
    }
}
