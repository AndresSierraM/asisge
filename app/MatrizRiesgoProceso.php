<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizRiesgoProceso extends Model
{
    protected $table = 'matrizriesgoproceso';
    protected $primaryKey = 'idMatrizRiesgoProceso';

    protected $fillable = ['fechaMatrizRiesgoProceso','Tercero_idRespondable','Proceso_idProceso', 'Compania_idCompania'];

    public $timestamps = false;

    public function MatrizRiesgoProcesoDetalle()
    {
		return $this->hasMany('App\MatrizRiesgoProcesoDetalle','MatrizRiesgoProceso_idMatrizRiesgoProceso');
    }
}
