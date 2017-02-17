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

    $dependencia = \App\Dependencia::All();
    $row = array();

    foreach ($dependencia as $key => $value) 
    {  
        $row[$key][] = '<a href="dependencia/'.$value['idDependencia'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="dependencia/'.$value['idDependencia'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idDependencia'];
        $row[$key][] = $value['codigoDependencia'];
        $row[$key][] = $value['nombreDependencia'];
        $row[$key][] = $value['abreviaturaDependencia'];    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>