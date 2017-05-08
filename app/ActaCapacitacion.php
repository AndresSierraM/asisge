<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaCapacitacion extends Model
{
	protected $table = 'actacapacitacion';
    protected $primaryKey = 'idActaCapacitacion';

    protected $fillable = ['numeroActaCapacitacion', 'fechaElaboracionActaCapacitacion', 'PlanCapacitacion_idPlanCapacitacion', 'Compania_idCompania'];

    public $timestamps = false;

    function actaCapacitacionAsistentes()
    {
    	return $this->hasMany('App\ActaCapacitacionAsistente','ActaCapacitacion_idActaCapacitacion');
    }

    function actaCapacitacionTemas()
    {
    	return $this->hasMany('App\ActaCapacitacionTema','ActaCapacitacion_idActaCapacitacion');
    }

     public function ActaCapacitacionArchivo()
    {
        return $this->hasMany('App\ActaCapacitacionArchivo','ActaCapacitacion_idActaCapacitacion');
    }
}
