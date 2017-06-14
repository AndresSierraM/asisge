<?php

    $consulta = DB::Select(
        'SELECT idFichaTecnica, referenciaFichaTecnica, nombreFichaTecnica, nombreLineaProducto, nombreSublineaProducto 
        FROM fichatecnica FT 
        LEFT JOIN lineaproducto LP 
        On FT.LineaProducto_idLineaProducto = LP.idLineaProducto
        LEFT JOIN sublineaproducto SP 
        On FT.SublineaProducto_idSublineaProducto = SP.idSublineaProducto
        WHERE tipoFichaTecnica = "m" and FT.Compania_idCompania = '.\Session::get('idCompania'));

    $row = array();

    foreach ($consulta as $key => $value) 
    {  
        foreach ($value as $datoscampo => $campo) 
        {
            $row[$key][] = $campo;
        }                        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>