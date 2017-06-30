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
        $visibleI = 'none;';
   

    $diagnostico2 = DB::SELECT('
        SELECT diag2.idDiagnostico2,diag2.codigoDiagnostico2,diag2.nombreDiagnostico2,diag2.fechaElaboracionDiagnostico2
        FROM diagnostico2 diag2
        WHERE diag2.Compania_idCompania = '.\Session::get('idCompania'));



    $row = array();

    foreach ($diagnostico2 as $key => $value) 
    {  
        $row[$key][] = '<a href="diagnostico2/'.$value->idDiagnostico2.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="diagnostico2/'.$value->idDiagnostico2.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;';
                        // '<a onclick="imprimirDiagnostico2('.$value->idDiagnostico2.')">'.
                        //     '<span class="glyphicon glyphicon-print" style = "cursor:pointer; display:'.$visibleI.'"></span>'.
                        // '</a>';
        $row[$key][] = $value->idDiagnostico2;
        $row[$key][] = $value->codigoDiagnostico2;
        $row[$key][] = $value->nombreDiagnostico2; 
        $row[$key][] = $value->fechaElaboracionDiagnostico2;  

    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>