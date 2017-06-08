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
    $examenmedico = DB::table('examenmedico')
            ->leftJoin('tercero', 'Tercero_idTercero', '=', 'idTercero')
            ->select(DB::raw('idExamenMedico, nombreCompletoTercero, fechaExamenMedico, tipoExamenMedico'))
            ->where('examenmedico.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($examenmedico as $key => $value) 
    {  
        $row[$key][] = '<a href="examenmedico/'.$value->idExamenMedico.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="examenmedico/'.$value->idExamenMedico.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                        '<a onclick="imprimirExamenMedico('.$value->idExamenMedico.');">'.
                            '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idExamenMedico;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->fechaExamenMedico; 
        $row[$key][] = $value->tipoExamenMedico;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>