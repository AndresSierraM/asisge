<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEmergenciaNivel extends Model
{
    protected $table = 'planemergencianivel';
    protected $primaryKey = 'idPlanEmergenciaNivel';

    protected $fillable = ['PlanEmergencia_idPlanEmergencia','nivelPlanEmergenciaNivel','cargoPlanEmergenciaNivel', 'funcionPlanEmergenciaNivel','papelPlanEmergenciaNivel'];

    public $timestamps = false;

    public function PlanEmergencia()
    {
		return $this->hasOne('App\PlanEmergencia','idPlanEmergencia');
    }
}
