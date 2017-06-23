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

    $evaluacion = DB::Select(
        'SELECT idEvaluacionProveedor, nombreCompletoTercero, fechaElaboracionEvaluacionProveedor, fechaInicialEvaluacionProveedor, fechaFinalEvaluacionProveedor, name
        FROM evaluacionproveedor ep
        LEFT JOIN tercero t ON ep.Tercero_idProveedor = t.idTercero
        LEFT JOIN users u ON ep.Users_idCrea = u.id');
    $row = array();

    foreach ($evaluacion as $key => $value) 
    {  
        $ep = get_object_vars($value);
        $row[$key][] = '<a href="evaluacionproveedor/'.$ep['idEvaluacionProveedor'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="evaluacionproveedor/'.$ep['idEvaluacionProveedor'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$ep['idEvaluacionProveedor'].');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $ep['idEvaluacionProveedor'];
        $row[$key][] = $ep['nombreCompletoTercero'];
        $row[$key][] = $ep['fechaElaboracionEvaluacionProveedor'];
        $row[$key][] = $ep['fechaInicialEvaluacionProveedor'];    
        $row[$key][] = $ep['fechaFinalEvaluacionProveedor']; 
        $row[$key][] = $ep['name'];    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>