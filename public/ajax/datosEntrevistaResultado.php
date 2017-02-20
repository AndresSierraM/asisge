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

    $informeEntrevista = DB::table('entrevistaresultado')

            ->leftJoin('cargo', 'Cargo_idCargo', '=', 'idcargo')

             ->leftJoin('users', 'Users_idCrea', '=', 'id')
            ->select(DB::raw('idEntrevistaResultado,nombreCargo,fechaInicialEntrevistaResultado,fechaFinalEntrevistaResultado,name,fechaElaboracionEntrevistaResultado'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($informeEntrevista as $key => $value) 
    {           
                                                                                    //Se adiciona una accion al editar y luego se llama en la dvista 
        $row[$key][] = '<a href="entrevistaresultado/'.$value->idEntrevistaResultado.'/edit?accion=editar&id='.$value->idEntrevistaResultado.'">'. 
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="entrevistaresultado/'.$value->idEntrevistaResultado.'/edit?accion=eliminar&id='.$value->idEntrevistaResultado.'">'.'<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;'.
                            '<a onclick="imprimirEntrevistaResultado('.$value->idEntrevistaResultado.')">'.
                            '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idEntrevistaResultado;
        $row[$key][] = $value->nombreCargo;
        $row[$key][] = $value->fechaInicialEntrevistaResultado;
        $row[$key][] = $value->fechaFinalEntrevistaResultado;
        $row[$key][] = $value->name;
        $row[$key][] = $value->fechaElaboracionEntrevistaResultado;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>