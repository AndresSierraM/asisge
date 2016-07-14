<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
// A C C I D E N T E S / I N C I D E N T E S
// -------------------------------------------
$datos = DB::select(
    'SELECT idAccidente as idTarea, nombreCompletoTercero as descripcionTarea,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 1, 1 , 0)) as EneroT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 1, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as EneroC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 2, 1 , 0)) as FebreroT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 2, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as FebreroC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 3, 1 , 0)) as MarzoT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 3, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as MarzoC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 4, 1 , 0)) as AbrilT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 4, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as AbrilC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 5, 1 , 0)) as MayoT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 5, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as MayoC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 6, 1 , 0)) as JunioT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 6, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as JunioC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 7, 1 , 0)) as JulioT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 7, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as JulioC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 8, 1 , 0)) as AgostoT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 8, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as AgostoC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 9, 1 , 0)) as SeptiembreT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 9, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as SeptiembreC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 10, 1 , 0)) as OctubreT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 10, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as OctubreC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 11, 1 , 0)) as NoviembreT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 11, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as NoviembreC,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 12, 1 , 0)) as DiciembreT,
        SUM(IF(MONTH(fechaElaboracionAusentismo) = 12, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as DiciembreC
    FROM ausentismo Aus
    left join accidente Acc
    on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
    left join tercero T
    on Aus.Tercero_idTercero = T.idTercero
    Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
        Aus.Compania_idCompania = '.$idCompania .' 
    group by Aus.Tercero_idTercero;');

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>