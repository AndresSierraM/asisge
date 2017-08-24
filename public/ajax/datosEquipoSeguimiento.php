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

    $equiposeguimiento = DB::select('
       SELECT es.idEquipoSeguimiento,es.fechaEquipoSeguimiento,es.nombreEquipoSeguimiento,
        t.nombreCompletoTercero
        FROM equiposeguimiento es
        LEFT JOIN tercero t  
        ON es.Tercero_idResponsable = t.idTercero
        LEFT JOIN compania c
        ON es.Compania_idCompania = c.idCompania
        WHERE es.Compania_idCompania = '.\Session::get('idCompania'));

    $row = array();

    foreach ($equiposeguimiento as $key => $value) 
    {  
        $row[$key][] = '<a href="equiposeguimiento/'.$value->idEquipoSeguimiento.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="equiposeguimiento/'.$value->idEquipoSeguimiento.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idEquipoSeguimiento.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idEquipoSeguimiento;
        $row[$key][] = $value->fechaEquipoSeguimiento;
        $row[$key][] = $value->nombreEquipoSeguimiento;
        $row[$key][] = $value->nombreCompletoTercero;     
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>