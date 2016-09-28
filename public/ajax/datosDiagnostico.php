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
        $visibleI = 'none;';
    
    $diagnostico = DB::table('diagnostico')
            ->leftJoin('diagnosticodetalle', 'idDiagnostico', '=', 'Diagnostico_idDiagnostico')
            ->select(DB::raw('idDiagnostico, codigoDiagnostico, nombreDiagnostico, fechaElaboracionDiagnostico, AVG(resultadoDiagnosticoDetalle) as resultadoDiagnosticoDetalle'))
            ->where('Compania_idCompania','=', \Session::get('idCompania'))
            ->groupby('idDiagnostico')
            ->get();

    $row = array();

    foreach ($diagnostico as $key => $value) 
    {  
        $row[$key][] = '<a href="diagnostico/'.$value->idDiagnostico.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="diagnostico/'.$value->idDiagnostico.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idDiagnostico.');">'.
                            '<span class="glyphicon glyphicon-print"  style = "display:'.$visibleI.'"></span>'.
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