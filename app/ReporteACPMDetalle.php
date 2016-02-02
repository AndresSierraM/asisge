<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteACPMDetalle extends Model
{
    protected $table = 'reporteacpmdetalle';
    protected $primaryKey = 'idReporteACPMDetalle';

    protected $fillable = ['ReporteACPM_idReporteACPM', 'ordenReporteACPMDetalle', 'fechaReporteReporteACPMDetalle', 'Proceso_idProceso', 'Modelo_idModelo', 'tipoReporteACPMDetalle', 'descripcionReporteACPMDetalle', 'analisisReporteACPMDetalle', 'correccionReporteACPMDetalle', 'Tercero_idResponsableCorrecion', 'planAccionReporteACPMDetalle', 'Tercero_idResponsablePlanAccion', 'fechaEstimadaCierreReporteACPMDetalle', 'estadoActualReporteACPMDetalle', 'fechaCierreReporteACPMDetalle', 'eficazReporteACPMDetalle'];

    public $timestamps = false;

    function reporteACPM()
    {
		return $this->hasOne('App\ReporteACPM','idReporteACPM');
    }
}
