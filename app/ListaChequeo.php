<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaChequeo extends Model
{
	protected $table = 'listachequeo';
    protected $primaryKey = 'idListaChequeo';

    protected $fillable = ['numeroListaChequeo', 'fechaElaboracionListaChequeo', 'PlanAuditoria_idPlanAuditoria', 'Proceso_idProceso', 'observacionesListaChequeo'];

    public $timestamps = false;

    function planAuditoriaAcompanantes()
    {
		return $this->hasMany('App\ListaChequeoDetalle','ListaChequeo_idListaChequeo');
    }

}
