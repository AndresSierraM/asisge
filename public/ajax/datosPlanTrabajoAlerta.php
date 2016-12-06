<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];

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

    $plantrabajoalerta = DB::table('plantrabajoalerta')
            ->select(DB::raw('idPlanTrabajoAlerta, nombrePlanTrabajoAlerta, correoParaPlanTrabajoAlerta, 
                correoCopiaPlanTrabajoAlerta, correoAsuntoPlanTrabajoAlerta'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($plantrabajoalerta as $key => $value) 
    {  
        $row[$key][] = '<a href="plantrabajoalerta/'.$value->idPlanTrabajoAlerta.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="plantrabajoalerta/'.$value->idPlanTrabajoAlerta.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idPlanTrabajoAlerta;
        $row[$key][] = $value->nombrePlanTrabajoAlerta;
        $row[$key][] = $value->correoParaPlanTrabajoAlerta;
        $row[$key][] = $value->correoCopiaPlanTrabajoAlerta;   
        $row[$key][] = $value->correoAsuntoPlanTrabajoAlerta;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>