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

    $agendapermiso = DB::Select('SELECT idAgendaPermiso, name FROM agendapermiso ap LEFT JOIN users u ON ap.Users_idAutorizado = u.id');
    $row = array();

    foreach ($agendapermiso as $key => $value) 
    {  
        $agenda = get_object_vars($value);
        
        $row[$key][] = '<a href="agendapermiso/'.$agenda['idAgendaPermiso'].'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="agendapermiso/'.$agenda['idAgendaPermiso'].'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style="display: '.$visibleE.'"></span>'.
                        '</a>';
        $row[$key][] = $agenda['idAgendaPermiso'];
        $row[$key][] = $agenda['name'];   
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>