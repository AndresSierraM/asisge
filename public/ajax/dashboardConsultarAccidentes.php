<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
// A C C I D E N T E S / I N C I D E N T E S
// -------------------------------------------
$datos = DB::select(
    'SELECT idAccidente as idTarea, nombreCompletoTercero as descripcionTarea,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 1 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 1 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 2 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 2 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 3 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 3 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 4 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 4 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 5 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 5 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 6 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 6 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 7 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 7 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 8 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 8 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 9 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 9 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 10 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 10 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 11 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 11 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 12 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 12 AND YEAR(fechaElaboracionAusentismo) =  date_format(NOW(), "%Y"), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as DiciembreC
    FROM ausentismo Aus
    left join accidente Acc
    on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
    left join tercero T
    on Aus.Tercero_idTercero = T.idTercero
    left join
    compania c ON Aus.Compania_idCompania = c.idCompania
    Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
        Aus.Compania_idCompania = '.$idCompania .' 
    and fechaElaboracionAusentismo >= fechaCreacionCompania 
    group by Aus.Tercero_idTercero;');

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>