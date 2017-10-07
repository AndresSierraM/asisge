<?php
    
    $tipo = (isset($_GET['tipo']) ? $_GET['tipo'] : 'P');

      
     $fichatecnica = DB::table('fichatecnica as F')
        ->leftjoin('lineaproducto as L','F.LineaProducto_idLineaProducto','=','L.idLineaProducto')
        ->leftjoin('sublineaproducto as S','F.SublineaProducto_idSublineaProducto','=','S.idSublineaProducto')
        ->leftjoin('tercero as T','F.Tercero_idTercero','=','T.idTercero')
        ->select(DB::raw('idFichaTecnica, referenciaFichaTecnica, nombreFichaTecnica, nombreLineaProducto, nombreSublineaProducto, nombreCompletoTercero, estadoFichaTecnica'))
        ->where('F.Compania_idCompania','=', \Session::get('idCompania'))
        ->where('tipoFichaTecnica', '=', $tipo)
        ->get();

    $row = array();

    foreach ($fichatecnica as $key => $value) 
    {  
        $row[$key][] = $value->idFichaTecnica;
        $row[$key][] = $value->referenciaFichaTecnica;
        $row[$key][] = $value->nombreFichaTecnica;   
        $row[$key][] = $value->nombreLineaProducto;   
        $row[$key][] = $value->nombreSublineaProducto;   
        $row[$key][] = $value->nombreCompletoTercero;   
        $row[$key][] = $value->estadoFichaTecnica;   
    }

    $output["aaData"] = $row;
    echo json_encode($output);
?>