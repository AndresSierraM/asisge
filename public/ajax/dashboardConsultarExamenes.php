<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  E X A M E N E S   M E D I C O S
// -------------------------------------------
$datos = DB::select(
    'SELECT idExamenMedico as idTarea, descripcionTarea, 
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 1 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 1 AND RET = 1) OR (MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as EneroT,
        SUM(IF(MONTH(fechaExamenMedico) = 1, 1, 0 )) as EneroC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 2 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 2 AND RET = 1) OR (MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as FebreroT,
        SUM(IF(MONTH(fechaExamenMedico) = 2, 1, 0 )) as FebreroC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 3 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 3 AND RET = 1) OR (MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MarzoT,
        SUM(IF(MONTH(fechaExamenMedico) = 3, 1, 0 )) as MarzoC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 4 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 4 AND RET = 1) OR (MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AbrilT,
        SUM(IF(MONTH(fechaExamenMedico) = 4, 1, 0 )) as AbrilC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 5 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 5 AND RET = 1) OR (MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MayoT,
        SUM(IF(MONTH(fechaExamenMedico) = 5, 1, 0 )) as MayoC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 6 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 6 AND RET = 1) OR (MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JunioT,
        SUM(IF(MONTH(fechaExamenMedico) = 6, 1, 0 )) as JunioC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 7 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 7 AND RET = 1) OR (MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JulioT,
        SUM(IF(MONTH(fechaExamenMedico) = 7, 1, 0 )) as JulioC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 8 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 8 AND RET = 1) OR (MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AgostoT,
        SUM(IF(MONTH(fechaExamenMedico) = 8, 1, 0 )) as AgostoC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 9 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 9 AND RET = 1) OR (MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as SeptiembreT,
        SUM(IF(MONTH(fechaExamenMedico) = 9, 1, 0 )) as SeptiembreC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 10 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 10 AND RET = 1) OR (MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as OctubreT,
        SUM(IF(MONTH(fechaExamenMedico) = 10, 1, 0 )) as OctubreC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 11 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 11 AND RET = 1) OR (MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as NoviembreT,
        SUM(IF(MONTH(fechaExamenMedico) = 11, 1, 0 )) as NoviembreC,
        SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 12 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 12 AND RET = 1) OR (MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0) OR (unidadFrecuenciaMedicion IN ("Años"))) as DiciembreT,
        SUM(IF(MONTH(fechaExamenMedico) = 12, 1, 0 )) as DiciembreC
    FROM
    (
        SELECT idExamenMedico, valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TET.nombreTipoExamenMedico, 
            fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET,
            IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico 
        FROM tercero T
        left join terceroinformacion TI
        on T.idTercero = TI.Tercero_idTercero
        left join cargo C
        on T.Cargo_idCargo = C.idCargo
        left join terceroexamenmedico TEM
        on T.idTercero = TEM.Tercero_idTercero
        left join frecuenciamedicion FM
        on TEM.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
        left join tipoexamenmedico TET
        on TEM.TipoExamenMedico_idTipoExamenMedico = TET.idTipoExamenMedico
        left join examenmedico EM 
        on T.idTercero = EM.Tercero_idTercero
        left join examenmedicodetalle EMD
        on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = TEM.TipoExamenMedico_idTipoExamenMedico
        where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL and 
            T.Compania_idCompania = '.$idCompania .' 
        group by idTercero, idTipoExamenMedico
     
    UNION

        SELECT idExamenMedico, valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
            fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
            IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico
        FROM tercero T
        left join terceroinformacion TI
        on T.idTercero = TI.Tercero_idTercero
        left join cargo C
        on T.Cargo_idCargo = C.idCargo
        left join cargoexamenmedico CE
        on C.idCargo = CE.Cargo_idCargo
        left join frecuenciamedicion FM
        on CE.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
        left join tipoexamenmedico TEC
        on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
        left join examenmedico EM 
        on T.idTercero = EM.Tercero_idTercero
        left join examenmedicodetalle EMD
        on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = CE.TipoExamenMedico_idTipoExamenMedico
        where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL  and 
            T.Compania_idCompania = '.$idCompania .' 
        group by idTercero, idTipoExamenMedico
    ) Examen
    group by idTercero');

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>