<?php
    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];
    $imprimir = $_GET['imprimir'];

    $visibleM = '';
    $visibleE = '';
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

    $programa = DB::table('programa')
            ->leftJoin('clasificacionriesgo', 'ClasificacionRiesgo_idClasificacionRiesgo', '=', 'idClasificacionRiesgo')
            ->select(DB::raw('idPrograma, nombrePrograma, fechaElaboracionPrograma, nombreClasificacionRiesgo'))
            ->where('programa.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($programa as $key => $value) 
    {  
        $row[$key][] = '<a href="programa/'.$value->idPrograma.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="programa/'.$value->idPrograma.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp'.
                         '<a href="programa" onclick="imprimirFormato('.$value->idPrograma.');s">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idPrograma;
        $row[$key][] = $value->nombrePrograma;
        $row[$key][] = $value->fechaElaboracionPrograma; 
        $row[$key][] = $value->nombreClasificacionRiesgo;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>