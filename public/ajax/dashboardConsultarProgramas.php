<?php 
$idCompania = (isset($_POST['idCompania']) ? $_POST['idCompania'] : 0);

// -------------------------------------------
//  P R O G R A M A S   /   A C T I V I D A D E S
// -------------------------------------------
$datos = DB::select(
    'SELECT idPrograma as idTarea, nombrePrograma  as descripcionTarea,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 1, 1 , 0)) as EneroT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 1, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as EneroC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 2, 1 , 0)) as FebreroT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 2, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as FebreroC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 3, 1 , 0)) as MarzoT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 3, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as MarzoC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 4, 1 , 0)) as AbrilT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 4, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as AbrilC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 5, 1 , 0)) as MayoT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 5, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as MayoC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 6, 1 , 0)) as JunioT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 6, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as JunioC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 7, 1 , 0)) as JulioT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 7, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as JulioC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 8, 1 , 0)) as AgostoT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 8, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as AgostoC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 9, 1 , 0)) as SeptiembreT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 9, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as SeptiembreC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 10, 1 , 0)) as OctubreT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 10, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as OctubreC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 11, 1 , 0)) as NoviembreT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 11, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as NoviembreC,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 12, 1 , 0)) as DiciembreT,
        SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 12, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as DiciembreC,
        SUM(recursoPlaneadoProgramaDetalle) as PresupuestoT,
        SUM(recursoEjecutadoProgramaDetalle) as PresupuestoC
    From programa P
    left join programadetalle PD
    on P.idPrograma = PD.Programa_idPrograma
    Where  P.Compania_idCompania = '.$idCompania .' 
    and fechaPlaneadaProgramaDetalle >= fechaCreacionCompania and fechaEjecucionProgramaDetalle >= fechaCreacionCompania
    Group by idPrograma');

$informe = array();
for($i = 0; $i < count($datos); $i++) 
{
    $informe[] = get_object_vars($datos[$i]);
}

echo json_encode($informe);

?>