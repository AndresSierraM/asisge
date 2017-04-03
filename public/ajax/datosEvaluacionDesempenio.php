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


    $evaluaciondesempenio = DB::Select('
        SELECT 
            idEvaluacionDesempenio,
            te.nombreCompletoTercero as nombreEmpleado,
            tr.nombreCompletoTercero as nombreResponsable, 
            nombreCargo,
            fechaElaboracionEvaluacionDesempenio
        FROM
            evaluaciondesempenio ed
                LEFT JOIN
            cargo c ON ed.Cargo_idCargo = c.idCargo
                LEFT JOIN
            tercero te ON ed.Tercero_idEmpleado = te.idTercero
                LEFT JOIN
            tercero tr ON ed.Tercero_idResponsable = tr.idTercero');
           
         
        $row = array();

    foreach ($evaluaciondesempenio as $key => $value) 
    {  
        $evaluacion = get_object_vars($value);
        $row[$key][] = '<a href="evaluaciondesempenio/'.$evaluacion['idEvaluacionDesempenio'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="evaluaciondesempenio/'.$evaluacion['idEvaluacionDesempenio'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a onclick="imprimirEvaluacionDesempenio('.$evaluacion['idEvaluacionDesempenio'].')">'.
                            '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleI.'"></span>'.
                        '</a>&nbsp;';

        $row[$key][] = $evaluacion['idEvaluacionDesempenio'];
        $row[$key][] = $evaluacion['nombreEmpleado'];
        $row[$key][] = $evaluacion['nombreCargo'];
        $row[$key][] = $evaluacion['nombreResponsable'];
        $row[$key][] = $evaluacion['fechaElaboracionEvaluacionDesempenio'];
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>