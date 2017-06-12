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

    $listaChequeo = DB::table('listachequeo as lc')
            ->leftJoin('proceso as p', 'lc.Proceso_idProceso', '=', 'p.idProceso')
            ->leftJoin('planauditoria as pa', 'lc.PlanAuditoria_idPlanAuditoria', '=', 'pa.idPlanAuditoria')
            ->select(DB::raw('idListaChequeo, numeroListaChequeo, fechaElaboracionListaChequeo, numeroPlanAuditoria, nombreProceso'))
            ->where('lc.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();
    $row = array();

    foreach($listaChequeo as $key => $value)
    {
        $row[$key][] = '<a href="listachequeo/'.$value->idListaChequeo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="listachequeo/'.$value->idListaChequeo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;&nbsp;'.
                         '<a href="#" onclick="imprimirFormato('.$value->idListaChequeo.');s">'.
                            '<span class="glyphicon glyphicon-print" style = "display:'.$visibleI.'"></span>'.
                        '</a>';
        $row[$key][] = $value->idListaChequeo;
        $row[$key][] = $value->numeroListaChequeo;
        $row[$key][] = $value->fechaElaboracionListaChequeo;
        $row[$key][] = $value->numeroPlanAuditoria;
        $row[$key][] = $value->nombreProceso;
    }

    $output['aaData'] = $row;
    echo json_encode($output);