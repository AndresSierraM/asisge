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

    $matrizdofa = DB::select('
        SELECT md.idMatrizDOFA,md.fechaElaboracionMatrizDOFA,t.nombreCompletoTercero,p.nombreProceso
        FROM matrizdofa md
          LEFT JOIN tercero t
          ON md.Tercero_idResponsable = t.idTercero
          LEFT JOIN proceso p
          ON md.Proceso_idProceso = p.idProceso
          LEFT JOIN compania c
          ON md.Compania_idCompania = c.idCompania
          WHERE md.Compania_idCompania = '.\Session::get('idCompania'));

    $row = array();

    foreach ($matrizdofa as $key => $value) 
    {  
        $row[$key][] = '<a href="matrizdofa/'.$value->idMatrizDOFA.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="matrizdofa/'.$value->idMatrizDOFA.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idMatrizDOFA.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idMatrizDOFA;
        $row[$key][] = $value->fechaElaboracionMatrizDOFA;
        $row[$key][] = $value->nombreCompletoTercero; 
        $row[$key][] = $value->nombreProceso;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>