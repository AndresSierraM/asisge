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

    $matrizriesgoproceso = DB::select('
        SELECT mrp.idMatrizRiesgoProceso,mrp.fechaMatrizRiesgoProceso,t.nombreCompletoTercero,p.nombreProceso
        FROM matrizriesgoproceso mrp
          LEFT JOIN tercero t
          ON mrp.Tercero_idRespondable = t.idTercero
          LEFT JOIN proceso p
          ON mrp.Proceso_idProceso = p.idProceso
          LEFT JOIN compania c
          ON mrp.Compania_idCompania = c.idCompania
          WHERE mrp.Compania_idCompania = '.\Session::get('idCompania'));

    $row = array();

    foreach ($matrizriesgoproceso as $key => $value) 
    {  
        $row[$key][] = '<a href="matrizriesgoproceso/'.$value->idMatrizRiesgoProceso.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="matrizriesgoproceso/'.$value->idMatrizRiesgoProceso.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="#" onclick="imprimirFormato('.$value->idMatrizRiesgoProceso.');">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idMatrizRiesgoProceso;
        $row[$key][] = $value->fechaMatrizRiesgoProceso;
        $row[$key][] = $value->nombreCompletoTercero; 
        $row[$key][] = $value->nombreProceso;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>