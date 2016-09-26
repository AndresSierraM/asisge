<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  G R U P O S   D E   A P O Y O
// -------------------------------------------
$datos = DB::select(
    'SELECT 
                nombreGrupoApoyo as descripcionTarea, 
                IF(MOD(1,GA.multiploMes) = 0, numeroTareas, 0) as EneroT,
                SUM(IF(AGA.mesActa = 1, numeroCumplidas, 0)) as EneroC,
                IF(MOD(2,GA.multiploMes) = 0, numeroTareas, 0) as FebreroT,
                SUM(IF(AGA.mesActa = 2, numeroCumplidas, 0)) as FebreroC,
                IF(MOD(3,GA.multiploMes) = 0, numeroTareas, 0) as MarzoT,
                SUM(IF(AGA.mesActa = 3, numeroCumplidas, 0)) as MarzoC,
                IF(MOD(4,GA.multiploMes) = 0, numeroTareas, 0) as AbrilT,
                SUM(IF(AGA.mesActa = 4, numeroCumplidas, 0)) as AbrilC,
                IF(MOD(5,GA.multiploMes) = 0, numeroTareas, 0) as MayoT,
                SUM(IF(AGA.mesActa = 5, numeroCumplidas, 0)) as MayoC,
                IF(MOD(6,GA.multiploMes) = 0, numeroTareas, 0) as JunioT,
                SUM(IF(AGA.mesActa = 6, numeroCumplidas, 0)) as JunioC,
                IF(MOD(7,GA.multiploMes) = 0, numeroTareas, 0) as JulioT,
                SUM(IF(AGA.mesActa = 7, numeroCumplidas, 0)) as JulioC,
                IF(MOD(8,GA.multiploMes) = 0, numeroTareas, 0) as AgostoT,
                SUM(IF(AGA.mesActa = 8, numeroCumplidas, 0)) as AgostoC,
                IF(MOD(9,GA.multiploMes) = 0, numeroTareas, 0) as SeptiembreT,
                SUM(IF(AGA.mesActa = 9, numeroCumplidas, 0)) as SeptiembreC,
                IF(MOD(10,GA.multiploMes) = 0, numeroTareas, 0) as OctubreT,
                SUM(IF(AGA.mesActa = 10, numeroCumplidas, 0)) as OctubreC,
                IF(MOD(11,GA.multiploMes) = 0, numeroTareas, 0) as NoviembreT,
                SUM(IF(AGA.mesActa = 11, numeroCumplidas, 0)) as NoviembreC,
                IF(MOD(12,GA.multiploMes) = 0, numeroTareas, 0) as DiciembreT,
                SUM(IF(AGA.mesActa = 12, numeroCumplidas, 0)) as DiciembreC,
                SUM(recursoPlaneadoActaGrupoApoyoDetalle) as PresupuestoT,
                SUM(recursoEjecutadoActaGrupoApoyoDetalle) as PresupuestoC

            FROM 
            (
                SELECT 
                    idGrupoApoyo,
                    nombreGrupoApoyo,
                    IF(unidadFrecuenciaMedicion = \'Dias\',
                        30 / valorFrecuenciaMedicion,
                        IF(unidadFrecuenciaMedicion = \'Semanas\',
                            4 / valorFrecuenciaMedicion,
                            1)) AS numeroTareas,
                    IF(unidadFrecuenciaMedicion IN (\'Dias\' , \'Semanas\'),
                        1,
                        valorFrecuenciaMedicion) AS multiploMes
                FROM
                    grupoapoyo GA
                        LEFT JOIN
                    frecuenciamedicion FM ON GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                WHERE
                    Compania_idCompania = '.$idCompania .' 
            ) GA
            Left join 
            (
                SELECT 
                    GrupoApoyo_idGrupoApoyo,
                    MONTH(fechaActaGrupoApoyo) AS mesActa,
                    COUNT(idActaGrupoApoyo) as numeroCumplidas
                FROM
                    actagrupoapoyo AGA
                WHERE
                    AGA.Compania_idCompania = '.$idCompania .' 
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
                    AGA.Compania_idCompania = '.$idCompania .'
                GROUP BY GrupoApoyo_idGrupoApoyo , mesActa
            ) AGAD
            on GA.idGrupoApoyo = AGAD.GrupoApoyo_idGrupoApoyo and AGA.mesActa = AGAD.mesActa
            group by idGrupoApoyo');

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>