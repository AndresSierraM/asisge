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

    $equiposeguimientocalibracion = DB::select('
    SELECT esc.idEquipoSeguimientoCalibracion,esc.fechaEquipoSeguimientoCalibracion,es.nombreEquipoSeguimiento,t.nombreCompletoTercero,tp.nombreCompletoTercero as NombreCompletoTerceroProveedor
    FROM equiposeguimientocalibracion esc
    LEFT JOIN equiposeguimiento es
    ON esc.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
    LEFT JOIN tercero t  
    ON es.Tercero_idResponsable = t.idTercero
    LEFT JOIN tercero tp
    ON esc.Tercero_idProveedor = tp.idTercero
    where es.Compania_idCompania = '.\Session::get('idCompania'));
  

    $row = array();

    foreach ($equiposeguimientocalibracion as $key => $value) 
    {  
        $row[$key][] = '<a href="equiposeguimientocalibracion/'.$value->idEquipoSeguimientoCalibracion.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="equiposeguimientocalibracion/'.$value->idEquipoSeguimientoCalibracion.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idEquipoSeguimientoCalibracion.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idEquipoSeguimientoCalibracion;
        $row[$key][] = $value->fechaEquipoSeguimientoCalibracion;
        $row[$key][] = $value->nombreEquipoSeguimiento;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->NombreCompletoTerceroProveedor; 
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>