<?php

namespace App\Http\Controllers;

trait traitSisoft 
{
  

 public function guardarReporteACPM($fechaAccion, $idModulo, $tipoAccion, $descripcionAccion)
    {
        $reporteACPM = \App\ReporteACPM::All()->last();
        
        \App\ReporteACPMDetalle::create([
            'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
            'ordenReporteACPMDetalle' => 0,
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Proceso_idProceso' => NULL,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion,
            'analisisReporteACPMDetalle' => '',
            'correccionReporteACPMDetalle' => '',
            'Tercero_idResponsableCorrecion' => NULL,
            'planAccionReporteACPMDetalle' => '',
            'Tercero_idResponsablePlanAccion' => NULL,
            'fechaEstimadaCierreReporteACPMDetalle' => '0000-00-00',
            'estadoActualReporteACPMDetalle' => '',
            'fechaCierreReporteACPMDetalle' => '0000-00-00',
            'eficazReporteACPMDetalle' => 0
        ]);
    }

}