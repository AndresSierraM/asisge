<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  P L A N   D E   C A P A C I T A C I O N
// -------------------------------------------
$datos = DB::select(
    'SELECT idPlanCapacitacion as idTarea, nombrePlanCapacitacion  as descripcionTarea,
        SUM(IF(MONTH(fechaPlanCapacitacionTema) = 1 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 1 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 2 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 2 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 3 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 3 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 4 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 4 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 5 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 5 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 6 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 6 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 7 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 7 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 8 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 8 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 9 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 9 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 10 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 10 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 11 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 11 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 12 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 12 AND YEAR(fechaPlanCapacitacionTema) =  date_format(NOW(), "%Y"), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as DiciembreC
    From plancapacitacion PC
    left join plancapacitaciontema PCT
    on PC.idPlanCapacitacion = PCT.PlanCapacitacion_idPlanCapacitacion
    left join 
    (
        SELECT * 
        FROM  actacapacitaciontema ACT
        left join actacapacitacion AC
        on ACT.ActaCapacitacion_idActaCapacitacion = AC.idActaCapacitacion
        where AC.Compania_idCompania = '.$idCompania .' and ACT.cumpleObjetivoActaCapacitacionTema
    )  ACT
    on PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
    left join compania c
    on PC.Compania_idCompania = c.idCompania
    Where  PC.Compania_idCompania = '.$idCompania .' and fechaPlanCapacitacionTema >= fechaCreacionCompania 
    group by idPlanCapacitacion');


$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>