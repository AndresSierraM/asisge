<?php

    $reporteACPM = DB::table('reporteacpm')
            ->select(DB::raw('idReporteACPM, numeroReporteACPM, fechaElaboracionReporteACPM, descripcionReporteACPM'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach($reporteACPM as $key => $value)
    {
        $row[$key][] = '<a href="reporteacpm/'.$value->idReporteACPM.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="reporteacpm/'.$value->idReporteACPM.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>'.
                         '<a href="#" onclick="imprimirFormato('.$value->idReporteACPM.');s">'.
                            '<span class="glyphicon glyphicon-print"></span>'.
                        '</a>';

        $row[$key][] = $value->idReporteACPM;
        $row[$key][] = $value->numeroReporteACPM;
        $row[$key][] = $value->fechaElaboracionReporteACPM;
        $row[$key][] = $value->descripcionReporteACPM;
    }

    $output['aaData'] = $row;
    echo json_encode($output);