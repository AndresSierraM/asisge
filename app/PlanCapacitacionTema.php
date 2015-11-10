<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCapacitacionTema extends Model
{
	protected $table = 'plancapacitaciontema';
    protected $primaryKey = 'idPlanCapacitacionTema';

    protected $fillable = ['PlanCapacitacion_idPlanCapacitacion', 'nombrePlanCapacitacionTema', 'Tercero_idCapacitador', 'fechaPlanCapacitacionTema', 'horaPlanCapacitacionTema','dictadaPlanCapacitacionTema'];

    public $timestamps = false;

    function planCapacitacion()
    {
		return $this->hasOne('App\PlanCapacitacion','idPlanCapacitacion');
    }
}
