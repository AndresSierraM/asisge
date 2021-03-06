<?php
// $reporteACPM = \App\ReporteACPM::where('Compania_idCompania','=',\Session::get("idCompania"))->last()->get();
function guardarReporteACPM($fechaAccion, $idModulo, $tipoAccion, $descripcionAccion)
{
    $reporteACPM = DB::select("Select MAX(idReporteACPM) as idReporteACPM
      From reporteacpm 
      where Compania_idCompania = ". \Session::get("idCompania"));

    $reporte = get_object_vars($reporteACPM[0])["idReporteACPM"];
    // Condicion si existe el id principal, solamente creara una linea de detalle en report ACPM -> R E P O R T E   A C C I O N E S  C O R R E C T I V A S,  P R E V E N T I V A S  Y   D E   M E J O R A 
    if ($reporte != "") 
    {
        // en el indice  se reciben la misma cantidad de los parametros
        $indice = array(
            'ReporteACPM_idReporteACPM' => $reporte,
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Modulo_idModulo' => $idModulo,
             'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion
        );

        $data = array(
            'ReporteACPM_idReporteACPM' => $reporte,
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
            'eficazReporteACPMDetalle' => 0);
    }
    else
    // Si no Existe, el sistema va a crear una linea con Encabezado y detalle del módulo reporte ACPM
    {
        DB::statement('INSERT into reporteacpm (idReporteACPM, numeroReporteACPM, fechaElaboracionReporteACPM, descripcionReporteACPM, Compania_idCompania) values (0, 1, "0000-00-00", "Acciones correctivas, preventivas y de mejora", '.\Session::get("idCompania").')');

        $reporteACPM = DB::select("Select MAX(idReporteACPM) as idReporteACPM
          From reporteacpm 
          where Compania_idCompania = ". \Session::get("idCompania"));

        $reporte = get_object_vars($reporteACPM[0])["idReporteACPM"];

        $indice = array(
            'ReporteACPM_idReporteACPM' => $reporte,
            'fechaReporteACPMDetalle' => $fechaAccion,
            'Modulo_idModulo' => $idModulo,
            'tipoReporteACPMDetalle' => $tipoAccion,
            'descripcionReporteACPMDetalle' => $descripcionAccion
        );

        $data = array(
            'ReporteACPM_idReporteACPM' => $reporte,
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
            'eficazReporteACPMDetalle' => 0);
    }

    $respuesta = \App\ReporteACPMDetalle::updateOrCreate($indice, $data);
}
?>