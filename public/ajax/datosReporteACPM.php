<?php
    
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
    $visibleI = '';
    if ($modificar == 1) 
            $visibleM = 'inline-block;';
    else
            $visibleM = 'none;';

    if ($eliminar == 1) 
            $visibleE = 'inline-block;';
    else
            $visibleE = 'none;';
    if ($imprimir == 1) 
        $visibleI = 'inline-block;';
    else
        $visibleI = 'none';

    $reporteACPM = DB::table('reporteacpm')
            ->select(DB::raw('idReporteACPM, numeroReporteACPM, fechaElaboracionReporteACPM, descripcionReporteACPM'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach($reporteACPM as $key => $value)
    {
        $row[$key][] = '<a href="reporteacpm/'.$value->idReporteACPM.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="reporteacpm/'.$value->idReporteACPM.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>'.
                         '<a href="#" onclick="imprimirFormato('.$value->idReporteACPM.');s">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';

        $row[$key][] = $value->idReporteACPM;
        $row[$key][] = $value->numeroReporteACPM;
        $row[$key][] = $value->fechaElaboracionReporteACPM;
        $row[$key][] = $value->descripcionReporteACPM;
    }

    $output['aaData'] = $row;
    echo json_encode($output);