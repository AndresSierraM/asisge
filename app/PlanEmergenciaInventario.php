<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaInventario extends Model
{
    protected $table = 'planemergenciainventario';
    protected $primaryKey = 'idPlanEmergenciaInventario';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','sedePlanEmergenciaInventario','recursoPlanEmergenciaInventario', 'cantidadPlanEmergenciaInventario','ubicacionPlanEmergenciaInventario','observacionPlanEmergenciaInventario'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }
}
