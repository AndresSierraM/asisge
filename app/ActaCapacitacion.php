<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaCapacitacion extends Model
{
	protected $table = 'actacapacitacion';
    protected $primaryKey = 'idActaCapacitacion';

    protected $fillable = ['numeroActaCapacitacion', 'fechaElaboracionActaCapacitacion', 'PlanCapacitacion_idPlanCapacitacion'];

    public $timestamps = false;

    function actaCapacitacionAsistentes()
    {
    	return $this->hasMany('App\ActaCapacitacionAsistente','ActaCapacitacion_idActaCapacitacion');
    }
}
