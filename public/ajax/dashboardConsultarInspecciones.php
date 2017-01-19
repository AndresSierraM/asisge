<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  I N S P E C C I O N E S   D E   S E G U R I D A D
// -------------------------------------------
$datos = DB::select(
    "SELECT  idInspeccion as idTarea, nombreTipoInspeccion as descripcionTarea, 
                SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 1 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as EneroC,
                SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 2 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as FebreroC,
                SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 3 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as MarzoC,
                SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 4 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as AbrilC,
                SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 5 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as MayoC,
                SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 6 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as JunioC,
                SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 7 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as JulioC,
                SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 8 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as AgostoC,
                SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 9 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as SeptiembreC,
                SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 10 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as OctubreC,
                SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 11 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as NoviembreC,
                SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 12 AND YEAR(fechaElaboracionInspeccion) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as DiciembreC
            FROM tipoinspeccion TI
            left join frecuenciamedicion FM
            on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            left join inspeccion I
            on TI.idTipoInspeccion = I.TipoInspeccion_idTipoInspeccion
            LEFT JOIN compania c 
            ON TI.Compania_idCompania = c.idCompania
            Where TI.Compania_idCompania = $idCompania 
            group by idTipoInspeccion");

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>