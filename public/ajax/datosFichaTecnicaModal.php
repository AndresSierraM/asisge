<?php 

$ficha = $_GET['ficha'];

if ($ficha == 'tercero') 
{
    $fichatecnica = DB::Select('
        SELECT 
            referenciaFichaTecnica,
            nombreFichaTecnica,
            idFichaTecnica
        FROM
            fichatecnica
        WHERE tipoFichaTecnica IN("m","s")
        AND Compania_idCompania = '.\Session::get('idCompania'));
}
else
{
    $idTercero = $_GET['idTercero'];

    if ($idTercero == '' or $idTercero == 'undefined') 
    {
        $fichatecnica = DB::Select('
            SELECT 
                referenciaFichaTecnica,
                nombreFichaTecnica,
                idFichaTecnica
            FROM
                fichatecnica
            WHERE tipoFichaTecnica IN("p")
            AND Compania_idCompania = '.\Session::get('idCompania'));
    }
    else
    {
     $fichatecnica = DB::Select('
         SELECT 
             referenciaFichaTecnica,
             nombreFichaTecnica,
             idFichaTecnica
         FROM
             terceroproducto tp
                LEFT JOIN
             fichatecnica ft ON tp.Fichatecnica_idFichaTecnica = ft.idFichaTecnica
               WHERE Compania_idCompania = '.\Session::get('idCompania').'
               AND tp.Tercero_idTercero = '.$idTercero);
    }
}


$row = array();

    foreach ($fichatecnica as $key => $value) 
    {  
    	$ficha = get_object_vars($value);
        $row[$key][] = $ficha['referenciaFichaTecnica'];
        $row[$key][] = $ficha['nombreFichaTecnica']; 
        $row[$key][] = $ficha['idFichaTecnica']; 
    }

    $output["aaData"] = $row;
    echo json_encode($output);

?>