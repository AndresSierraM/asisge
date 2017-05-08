<?php

    $modificar = $_GET['modificar'];
    $eliminar = $_GET['eliminar'];

    $visibleM = '';
    $visibleE = '';
    if ($modificar == 1) 
        $visibleM = 'inline-block;';
    else
        $visibleM = 'inline-block;;';

    if ($eliminar == 1) 
        $visibleE = 'inline-block;';
    else
        $visibleE = 'none;';

    $query = DB::Select('
                SELECT 
                idAgenda,
                nombreCategoriaAgenda,
                asuntoAgenda,
                fechaHoraInicioAgenda,
                fechaHoraFinAgenda,
                nombreCompletoTercero                    
                FROM 
                agenda a
                    LEFT JOIN 
                categoriaagenda ca ON a.CategoriaAgenda_idCategoriaAgenda = ca.idCategoriaAgenda
                    LEFT JOIN 
                tercero t ON a.Tercero_idResponsable = t.idTercero
                WHERE a.Compania_idCompania = '.\Session::get('idCompania'));
    $row = array();

    foreach ($query as $key => $value) 
    {  
        $agenda = get_object_vars($value);

        $agenda['fechaHoraInicioAgenda'] = date("d-m-Y H:m:s",substr($agenda['fechaHoraInicioAgenda'], 0, -3));

        $agenda['fechaHoraFinAgenda'] = date("d-m-Y H:m:s",substr($agenda['fechaHoraFinAgenda'], 0, -3));

        $row[$key][] = '<a href="eventoagenda?id='.$agenda['idAgenda'].'">'.
                            '<span class="glyphicon glyphicon-pencil" style="display: '.$visibleM.'"></span>'.
                        '</a>';
        $row[$key][] = $agenda['nombreCategoriaAgenda'];
        $row[$key][] = $agenda['asuntoAgenda'];
        $row[$key][] = $agenda['fechaHoraInicioAgenda'];
        $row[$key][] = $agenda['fechaHoraFinAgenda']; 
        $row[$key][] = $agenda['nombreCompletoTercero'];    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>