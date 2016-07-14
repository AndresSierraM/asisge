<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  G R U P O S   D E   A P O Y O
// -------------------------------------------
$datos = DB::select(
    'SELECT idActaGrupoApoyo as idTarea, nombreGrupoApoyo as descripcionTarea, 
        SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as EneroT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 1, 1, 0 )) as EneroC,
        SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as FebreroT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 2, 1, 0 )) as FebreroC,
        SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MarzoT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 3, 1, 0 )) as MarzoC,
        SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AbrilT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 4, 1, 0 )) as AbrilC,
        SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MayoT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 5, 1, 0 )) as MayoC,
        SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JunioT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 6, 1, 0 )) as JunioC,
        SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JulioT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 7, 1, 0 )) as JulioC,
        SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AgostoT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 8, 1, 0 )) as AgostoC,
        SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as SeptiembreT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 9, 1, 0 )) as SeptiembreC,
        SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as OctubreT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 10, 1, 0 )) as OctubreC,
        SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as NoviembreT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 11, 1, 0 )) as NoviembreC,
        SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as DiciembreT,
        SUM(IF(MONTH(fechaActaGrupoApoyo) = 12, 1, 0 )) as DiciembreC
    FROM grupoapoyo GA
    left join frecuenciamedicion FM
    on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
    left join actagrupoapoyo AGA
    on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo
    Where GA.Compania_idCompania = '.$idCompania .' 
    group by idGrupoApoyo');

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>