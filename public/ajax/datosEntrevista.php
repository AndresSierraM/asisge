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

    $entrevista = DB::table('entrevista')
            ->select(DB::raw('idEntrevista, fechaEntrevista,documentoAspiranteEntrevista,nombreAspiranteEntrevista,Cargo_idCargo,Tercero_idEntrevistador'))
            ->get();
            //->where('plantrabajoalerta.Compania_idCompania','=', \Session::get('idCompania'))

        $row = array();

    foreach ($entrevista as $key => $value) 
    {  
        $row[$key][] = '<a href="entrevista/'.$value->idEntrevista.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil " style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="entrevista/'.$value->idEntrevista.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;';
        $row[$key][] = $value->idEntrevista;
        $row[$key][] = $value->fechaEntrevista;
        $row[$key][] = $value->documentoAspiranteEntrevista;
        $row[$key][] = $value->nombreAspiranteEntrevista;
        $row[$key][] = $value->Cargo_idCargo;
        $row[$key][] = $value->Tercero_idEntrevistador;

        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>