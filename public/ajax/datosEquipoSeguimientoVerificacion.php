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

    $equiposeguimientoverificacion = DB::select('
    SELECT esv.idEquipoSeguimientoVerificacion,esv.fechaEquipoSeguimientoVerificacion,es.nombreEquipoSeguimiento
    FROM equiposeguimientoverificacion esv
    LEFT JOIN equiposeguimiento es
    ON esv.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
    where es.Compania_idCompania = '.\Session::get('idCompania'));
  

    $row = array();

    foreach ($equiposeguimientoverificacion as $key => $value) 
    {  
        $row[$key][] = '<a href="equiposeguimientoverificacion/'.$value->idEquipoSeguimientoVerificacion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="equiposeguimientoverificacion/'.$value->idEquipoSeguimientoVerificacion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idEquipoSeguimientoVerificacion.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idEquipoSeguimientoVerificacion;
        $row[$key][] = $value->fechaEquipoSeguimientoVerificacion;
        $row[$key][] = $value->nombreEquipoSeguimiento; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>