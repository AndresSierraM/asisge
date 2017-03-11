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

    $categoriaagenda = \App\CategoriaAgenda::All();
    $row = array();

    foreach ($categoriaagenda as $key => $value) 
    {  
        $row[$key][] = '<a href="categoriaagenda/'.$value['idCategoriaAgenda'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="categoriaagenda/'.$value['idCategoriaAgenda'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idCategoriaAgenda'];
        $row[$key][] = $value['codigoCategoriaAgenda'];
        $row[$key][] = $value['nombreCategoriaAgenda'];
        $row[$key][] = '<div style="background-color:'.$value['colorCategoriaAgenda'].'">'.$value['colorCategoriaAgenda'].'</div>';  
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>