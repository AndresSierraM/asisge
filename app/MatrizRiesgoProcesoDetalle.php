<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizRiesgoProcesoDetalle extends Model
{
    protected $table = 'matrizriesgoprocesodetalle';
    protected $primaryKey = 'idMatrizRiesgoProcesoDetalle';

    protected $fillable = ['MatrizRiesgoProceso_idMatrizRiesgoProceso', 'descripcionMatrizRiesgoProcesoDetalle', 'efectoMatrizRiesgoProcesoDetalle', 'frecuenciaMatrizRiesgoProcesoDetalle', 'impactoMatrizRiesgoProcesoDetalle', 'nivelValorMatrizRiesgoProcesoDetalle', 'interpretacionValorMatrizRiesgoProcesoDetalle', 'accionesMatrizRiesgoProcesoDetalle', 'descripcionAccionMatrizRiesgoProcesoDetalle', 'Tercero_idResponsableAccion', 'seguimientoMatrizRiesgoProcesoDetalle', 'fechaSeguimientoMatrizRiesgoProcesoDetalle', 'fechaCierreMatrizRiesgoProcesoDetalle', 'eficazMatrizRiesgoProcesoDetalle','MatrizDOFADetalle_idMatrizDOFADetalle'];

    public $timestamps = false;

    public function matrizRiesgoProceso()
    {
		return $this->hasOne('App\MatrizRiesgo','idMatrizRiesgoProceso');
    }
    
}
