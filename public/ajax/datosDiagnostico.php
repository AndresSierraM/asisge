<?php

    $diagnostico = DB::table('diagnostico')
            ->leftJoin('diagnosticodetalle', 'idDiagnostico', '=', 'Diagnostico_idDiagnostico')
            ->select(DB::raw('idDiagnostico, codigoDiagnostico, nombreDiagnostico, fechaElaboracionDiagnostico, AVG(resultadoDiagnosticoDetalle) as resultadoDiagnosticoDetalle'))
            ->groupby('idDiagnostico')
            ->get();

    $row = array();

    foreach ($diagnostico as $key => $value) 
    {  
        $row[$key][] = '<a href="diagnostico/'.$value->idDiagnostico.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="diagnostico/'.$value->idDiagnostico.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idDiagnostico.');">'.
                            '<span class="glyphicon glyphicon-print"></span>'.
                        '</a>';
        $row[$key][] = $value->idDiagnostico;
        $row[$key][] = $value->codigoDiagnostico;
        $row[$key][] = $value->nombreDiagnostico; 
        $row[$key][] = $value->fechaElaboracionDiagnostico;
        $row[$key][] = $value->resultadoDiagnosticoDetalle;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>