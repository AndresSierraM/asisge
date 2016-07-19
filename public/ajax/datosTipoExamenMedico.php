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


    $tipoexamenmedico = \App\TipoExamenMedico::All();
    // print_r($tipoexamenmedico);
    // exit;
    $row = array();

    foreach ($tipoexamenmedico as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoexamenmedico/'.$value['idTipoExamenMedico'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoexamenmedico/'.$value['idTipoExamenMedico'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoExamenMedico'];
        $row[$key][] = $value['nombreTipoExamenMedico'];
        $row[$key][] = $value['limiteInferiorTipoExamenMedico'];   
        $row[$key][] = $value['limiteSuperiorTipoExamenMedico'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>