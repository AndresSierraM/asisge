<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  G R U P O S   D E   A P O Y O
// -------------------------------------------
$datos = DB::select(
    "SELECT 
                nombreGrupoApoyo as descripcionTarea, 
                IF((MOD(1, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas,0) AS EneroT,
                SUM(IF(AGA.mesActa = 1 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS EneroC,
                IF((MOD(2, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')),numeroTareas,0) AS FebreroT,
                SUM(IF(AGA.mesActa = 2 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas,0)) AS FebreroC,
                IF((MOD(3, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS MarzoT,
                SUM(IF(AGA.mesActa = 3 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS MarzoC,
                IF((MOD(4, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS AbrilT,
                SUM(IF(AGA.mesActa = 4 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS AbrilC,
                IF((MOD(5, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS MayoT,
                SUM(IF(AGA.mesActa = 5 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS MayoC,
                IF((MOD(6, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS JunioT,
                SUM(IF(AGA.mesActa = 6 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS JunioC,
                IF((MOD(7, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas,0) AS JulioT,
                SUM(IF(AGA.mesActa = 7 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS JulioC,
                IF((MOD(8, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')),numeroTareas, 0) AS AgostoT,
                SUM(IF(AGA.mesActa = 8 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS AgostoC,
                IF((MOD(9, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS SeptiembreT,
                SUM(IF(AGA.mesActa = 9 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS SeptiembreC,
                IF((MOD(10, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS OctubreT,
                SUM(IF(AGA.mesActa = 10 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS OctubreC,
                IF((MOD(11, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS NoviembreT,
                SUM(IF(AGA.mesActa = 11 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas, 0)) AS NoviembreC,
                IF((MOD(12, GA.multiploMes) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m')), numeroTareas, 0) AS DiciembreT,
                SUM(IF(AGA.mesActa = 12 AND añoActa =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), numeroCumplidas,0)) AS DiciembreC,
                SUM(recursoPlaneadoActaGrupoApoyoDetalle) as PresupuestoT,
                SUM(recursoEjecutadoActaGrupoApoyoDetalle) as PresupuestoC

            FROM 
            (
                SELECT 
                    idGrupoApoyo,
                    nombreGrupoApoyo,
                    IF(unidadFrecuenciaMedicion = 'Dias',
                        30 / valorFrecuenciaMedicion,
                        IF(unidadFrecuenciaMedicion = 'Semanas',
                            4 / valorFrecuenciaMedicion,
                            1)) AS numeroTareas,
                    IF(unidadFrecuenciaMedicion IN ('Dias' , 'Semanas'),
                        1,
                        valorFrecuenciaMedicion) AS multiploMes,
                    fechaCreacionCompania
                FROM
                    grupoapoyo GA
                        LEFT JOIN
                    frecuenciamedicion FM ON GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                        LEFT JOIN 
                    compania c ON GA.Compania_idCompania = c.idCompania
                WHERE
                    Compania_idCompania = $idCompania 
            ) GA
            Left join 
            (
                SELECT 
                    GrupoApoyo_idGrupoApoyo,
                    MONTH(fechaActaGrupoApoyo) AS mesActa,
                    YEAR(fechaActaGrupoApoyo) AS añoActa,
                    COUNT(idActaGrupoApoyo) as numeroCumplidas
                FROM
                    actagrupoapoyo AGA
                WHERE
                    AGA.Compania_idCompania = $idCompania
                GROUP BY GrupoApoyo_idGrupoApoyo , mesActa
            ) AGA
            on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo
            left join 
            (
                SELECT 
                    GrupoApoyo_idGrupoApoyo,
                    MONTH(fechaActaGrupoApoyo) AS mesActa,
                    SUM(recursoPlaneadoActaGrupoApoyoDetalle) AS recursoPlaneadoActaGrupoApoyoDetalle,
                    SUM(recursoEjecutadoActaGrupoApoyoDetalle) AS recursoEjecutadoActaGrupoApoyoDetalle
                FROM
                    grupoapoyo GA
                        LEFT JOIN
                    frecuenciamedicion FM ON GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                        LEFT JOIN
                    actagrupoapoyo AGA ON GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo
                        LEFT JOIN
                    actagrupoapoyodetalle AGAD ON AGAD.ActaGrupoApoyo_idActaGrupoApoyo = AGA.idActaGrupoApoyo
                WHERE
                    AGA.Compania_idCompania = $idCompania
                GROUP BY GrupoApoyo_idGrupoApoyo , mesActa
            ) AGAD
            on GA.idGrupoApoyo = AGAD.GrupoApoyo_idGrupoApoyo and AGA.mesActa = AGAD.mesActa
            group by idGrupoApoyo");

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>