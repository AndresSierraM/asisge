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

    $ausentismo = DB::table('ausentismo')
            ->leftJoin('tercero', 'Tercero_idTercero', '=', 'idTercero')
            ->leftJoin('accidente', 'Ausentismo_idAusentismo', '=', 'idAusentismo')
            ->select(DB::raw('idAusentismo, nombreAusentismo, nombreCompletoTercero, fechaElaboracionAusentismo, tipoAusentismo, fechaInicioAusentismo, fechaFinAusentismo, nombreAccidente, diasAusentismo,archivoAusentismo'))
            ->where('ausentismo.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    $row = array();

    foreach ($ausentismo as $key => $value) 
    {  
        $row[$key][] = '<a href="ausentismo/'.$value->idAusentismo.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil" style = "display:'.$visibleM.'"></span>'.
                        '</a>&nbsp;'.
                        '<a href="ausentismo/'.$value->idAusentismo.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash" style = "display:'.$visibleE.'"></span>'.
                        '</a>&nbsp;&nbsp;'.
                        '<a target="_blank" href="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$value->archivoAusentismo.'">'.
                            '<span class="glyphicon glyphicon-paperclip " style = "display:'.$visibleI.'"></span>'.
                        '</a>';


                         // '<a onclick="ArchivoAdjunto('.$value['archivoAusentismo'].')">'.
                        // target="_blank es para que abra en una ventana nueva y no lo descargue"

        $row[$key][] = $value->idAusentismo;
        $row[$key][] = $value->nombreAusentismo;
        $row[$key][] = $value->nombreCompletoTercero;
        $row[$key][] = $value->fechaElaboracionAusentismo; 
        $row[$key][] = $value->fechaInicioAusentismo;
        $row[$key][] = $value->fechaFinAusentismo;    
        $row[$key][] = $value->diasAusentismo;    
        $row[$key][] = $value->tipoAusentismo;
        $row[$key][] = $value->nombreAccidente;
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>