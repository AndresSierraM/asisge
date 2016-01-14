<?php


    $tipoexamenmedico = \App\TipoExaMenmedico::All();
    // print_r($tipoexamenmedico);
    // exit;
    $row = array();

    foreach ($tipoexamenmedico as $key => $value) 
    {  
        $row[$key][] = '<a href="tipoexamenmedico/'.$value['idTipoExamenMedico'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="tipoexamenmedico/'.$value['idTipoExamenMedico'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value['idTipoExamenMedico'];
        $row[$key][] = $value['nombreTipoExamenMedico'];
        $row[$key][] = $value['limiteInferiorTipoExamenMedico'];   
        $row[$key][] = $value['limiteSuperiorTipoExamenMedico'];
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>