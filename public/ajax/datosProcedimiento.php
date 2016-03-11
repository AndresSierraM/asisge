<?php

    $procedimiento = DB::table('procedimiento')
            ->leftJoin('proceso', 'Proceso_idProceso', '=', 'idProceso')
            ->select(DB::raw('idProcedimiento, nombreProcedimiento, nombreProceso, fechaElaboracionProcedimiento'))
            ->where('procedimiento.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($procedimiento as $key => $value) 
    {  
        $row[$key][] = '<a href="procedimiento/'.$value->idProcedimiento.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="procedimiento/'.$value->idProcedimiento.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->idProcedimiento;
        $row[$key][] = $value->nombreProcedimiento;
        $row[$key][] = $value->nombreProceso; 
        $row[$key][] = $value->fechaElaboracionProcedimiento;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>