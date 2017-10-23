<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaArchivo extends Model
{
    protected $table = 'planemergenciaarchivo';
    protected $primaryKey = 'idPlanEmergenciaArchivo';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','rutaPlanEmergenciaArchivo'];

    public $timestamps = false;

     public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }

    
}
