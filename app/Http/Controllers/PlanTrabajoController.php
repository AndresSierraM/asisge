<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class PlanTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $idCompania = \Session::get("idCompania");

        // -------------------------------------------
        // A C C I D E N T E S / I N C I D E N T E S
        // -------------------------------------------
        $accidente = DB::select(
            'SELECT nombreCompletoTercero as descripcionTarea,
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
            group by Aus.Tercero_idTercero;');
        

        // -------------------------------------------
        // P L A N   D E   A U D I T O R I A
        // -------------------------------------------
        $auditoria = DB::select(
            'SELECT nombreProceso as descripcionTarea,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 1 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 1 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 2 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 2 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 3 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 3 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 4 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 4 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 5 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 5 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 6 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 6 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 7 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 7 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 8 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 8 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 9 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 9 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 10 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 10 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 11 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 11 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 12 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 12 AND YEAR(fechaPlanAuditoriaAgenda) =  date_format(NOW(), "%Y"), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as DiciembreC
            From planauditoria PA
            left join planauditoriaagenda PAA
            on PA.idPlanAuditoria = PAA.PlanAuditoria_idPlanAuditoria
            left join listachequeo LC
            on PA.idPlanAuditoria = LC.PlanAuditoria_idPlanAuditoria and PAA.Proceso_idProceso = LC.Proceso_idProceso
            left join proceso P
            on PAA.Proceso_idProceso = P.idProceso
            left join compania c 
            on PA.Compania_idCompania = c.idCompania
            Where  PA.Compania_idCompania = '.$idCompania .'
            group by idPlanAuditoriaAgenda;');

        // -------------------------------------------
        //  P L A N   D E   C A P A C I T A C I O N
        // -------------------------------------------
        
        $capacitacion = DB::select(
            'SELECT nombrePlanCapacitacion  as descripcionTarea,
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
            Where  PC.Compania_idCompania = '.$idCompania .'
            group by idPlanCapacitacion');


        // -------------------------------------------
        //  P R O G R A M A S   /   A C T I V I D A D E S
        // -------------------------------------------
        $programa = DB::select(
            'SELECT nombrePrograma  as descripcionTarea,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 1 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 1 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 2 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 2 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 3 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 3 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 4 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 4 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 5 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 5 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 6 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 6 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 7 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 7 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 8 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 8 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 9 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 9 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 10 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 10 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 11 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 11 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 12 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 12 AND YEAR(fechaPlaneadaProgramaDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as DiciembreC,
                SUM(recursoEjecutadoProgramaDetalle) as PresupuestoC
            From programa P
            left join programadetalle PD
            on P.idPrograma = PD.Programa_idPrograma
            left join compania c
            on P.Compania_idCompania = c.idCompania
            Where  P.Compania_idCompania = '.$idCompania .'
            Group by idPrograma');


        // -------------------------------------------
        //  E X A M E N E S   M E D I C O S
        // -------------------------------------------
        $examen = DB::select(
            "SELECT nombreTipoExamenMedico, descripcionTarea, 
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 1 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR
                (MONTH(fechaRetiroTerceroInformacion) = 1 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 1, 1 , 0) ) as EneroT,
                SUM(IF(MONTH(fechaExamenMedico) = 1 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as EneroC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 2 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR
                (MONTH(fechaRetiroTerceroInformacion) = 2 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 2, 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaExamenMedico) = 2 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as FebreroC,
                
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 3 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 3 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 3, 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaExamenMedico) = 3 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as MarzoC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 4 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 4 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 4, 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaExamenMedico) = 4 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as AbrilC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 5 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 5 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 5, 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaExamenMedico) = 5 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as MayoC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 6 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 6 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 6, 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaExamenMedico) = 6 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as JunioC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 7 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 7 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 7, 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaExamenMedico) = 7 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as JulioC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 8 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 8 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 8, 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaExamenMedico) = 8 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as AgostoC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 9 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 9 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 9, 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaExamenMedico) = 9 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as SeptiembreC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 10 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) OR 
                (MONTH(fechaRetiroTerceroInformacion) = 10 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 10, 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaExamenMedico) = 10 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as OctubreC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 11 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) 
                OR (MONTH(fechaRetiroTerceroInformacion) = 11 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 11, 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaExamenMedico) = 11 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as NoviembreC,
                
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 12 AND YEAR(fechaIngresoTerceroInformacion) >= date_format(NOW(), '%Y') AND ING =1) 
                OR (MONTH(fechaRetiroTerceroInformacion) = 12 AND YEAR(fechaRetiroTerceroInformacion) >= date_format(NOW(), '%Y') AND RET = 1) OR 
                (MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')) OR 
                (unidadFrecuenciaMedicion IN ('Años')) AND MONTH(fechaIngresoTerceroInformacion) = 12, 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaExamenMedico) = 12 AND YEAR(fechaExamenMedico) =  date_format(NOW(), '%Y'), 1, 0 )) as DiciembreC
            FROM
            (
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , ' (', nombreCargo, ')') as descripcionTarea,  TET.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , '0000-00-00', EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, idExamenMedico
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
                where tipoTercero like '%01%' and idTipoExamenMedico IS NOT NULL and 
                    T.Compania_idCompania = $idCompania 
                group by idTercero, idTipoExamenMedico
             
            UNION

                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , ' (', nombreCargo, ')') as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , '0000-00-00', EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, idExamenMedico
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
                where tipoTercero like '%01%' and idTipoExamenMedico IS NOT NULL  and 
                    T.Compania_idCompania = $idCompania
                group by idTercero, idTipoExamenMedico
            ) Examen
            group by nombreTipoExamenMedico, idTercero
            order by nombreTipoExamenMedico");


        // -------------------------------------------
        //  I N S P E C C I O N E S   D E   S E G U R I D A D
        // -------------------------------------------
        $inspeccion = DB::select(
            "SELECT nombreTipoInspeccion as descripcionTarea, 
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


        // -------------------------------------------
        //  M A T R I Z   L E G A L
        // -------------------------------------------
        $matrizlegal = DB::select(
            "SELECT concat('Matriz Legal: ',nombreMatrizLegal) as descripcionTarea, 
                SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 1 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as EneroC,
                SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 2 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as FebreroC,
                SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 3 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as MarzoC,
                SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 4 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as AbrilC,
                SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 5 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as MayoC,
                SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 6 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as JunioC,
                SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 7 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as JulioC,
                SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 8 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as AgostoC,
                SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 9 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as SeptiembreC,
                SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 10 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y')  AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as OctubreC,
                SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 11 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as NoviembreC,
                SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 12 AND YEAR(fechaActualizacionMatrizLegal) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as DiciembreC
            FROM matrizlegal ML
            left join frecuenciamedicion FM
            on ML.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            LEFT JOIN compania c 
            ON ML.Compania_idCompania = c.idCompania
            Where ML.Compania_idCompania = $idCompania 
            group by idMatrizLegal
            
            UNION
            
            SELECT concat('Matriz Riesgo: ',nombreMatrizRiesgo) as descripcionTarea, 
                SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 1 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '01') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as EneroC,
                SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 2 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '02') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as FebreroC,
                SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 3 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '03') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as MarzoC,
                SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 4 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '04') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as AbrilC,
                SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 5 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '05') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as MayoC,
                SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 6 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '06') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as JunioC,
                SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 7 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '07') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as JulioC,
                SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 8 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '08') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as AgostoC,
                SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 9 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '09') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as SeptiembreC,
                SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 10 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '10') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as OctubreC,
                SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 11 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '11') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as NoviembreC,
                SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 12 AND YEAR(fechaActualizacionMatrizRiesgo) =  date_format(NOW(), '%Y')AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '12') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0 )) as DiciembreC
            FROM matrizriesgo MR
            left join frecuenciamedicion FM
            on MR.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            LEFT JOIN compania c 
            ON MR.Compania_idCompania = c.idCompania
            Where MR.Compania_idCompania = $idCompania
            group by idMatrizRiesgo
            ");


        // -------------------------------------------
        //  G R U P O S   D E   A P O Y O
        // -------------------------------------------
        $grupoapoyo = DB::select(
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

        // -------------------------------------------
        //  A C T A S   D E   R E U N I O N 
        // -------------------------------------------
        $actividadesgrupoapoyo = DB::select(
            'SELECT CONCAT(nombreGrupoApoyo, " - ", actividadGrupoApoyoDetalle) as descripcionTarea,
                idActaGrupoApoyoDetalle as idConcepto,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 1 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 1 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 2 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 2 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 3 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 3 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 4 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 4 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 5 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 5 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 6 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 6 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 7 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 7 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 8 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 8 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 9 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 9 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 10 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 10 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 11 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 11 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 12 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 12 AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  date_format(NOW(), "%Y"), IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as DiciembreC,
                SUM(recursoPlaneadoActaGrupoApoyoDetalle) as PresupuestoT,
                SUM(recursoEjecutadoActaGrupoApoyoDetalle) as PresupuestoC
            From actagrupoapoyodetalle agpd
            left join actagrupoapoyo agp
            on agpd.ActaGrupoApoyo_idActaGrupoApoyo = agp.idActaGrupoApoyo
            left join grupoapoyo ga
            on ga.idGrupoApoyo = agp.GrupoApoyo_idGrupoApoyo
            left join compania c 
            on agp.Compania_idCompania = c.idCompania
            Where  agp.Compania_idCompania = '.$idCompania .' 
            Group by ga.idGrupoApoyo, idActaGrupoApoyoDetalle');

        // -------------------------------------------
        //  R E P O R T E     A C P M 
        // -------------------------------------------

        $acpm = DB::Select('
            SELECT concat(IFNULL(nombreModulo,""), " - (", tipoReporteACPMDetalle , ")  ",descripcionReporteACPMDetalle) as descripcionTarea,
                idReporteACPMDetalle as idConcepto,
                "" as Tercero_idTercero,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 1 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as EneroT, 
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 1 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 2 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 2 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 3 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 3 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 4 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 4 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 5 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 5 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 6 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 6 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 7 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 7 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 8 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 8 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 9 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 9 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 10 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 10 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 11 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 11 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 12 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaReporteACPMDetalle) = 12 AND YEAR(fechaReporteACPMDetalle) =  date_format(NOW(), "%Y"), IF(fechaCierreReporteACPMDetalle IS NULL OR fechaCierreReporteACPMDetalle  = "0000-00-00", 0, 1), 0)) as DiciembreC
            From reporteacpmdetalle acpmd
            left join reporteacpm acpm
            on acpmd.ReporteACPM_idReporteACPM = acpm.idReporteACPM
            left join modulo m
            on acpmd.Modulo_idModulo = m.idModulo
            Where  acpm.Compania_idCompania = '.$idCompania.'
            Group by idReporteACPMDetalle
            order by fechaReporteACPMDetalle, descripcionReporteACPMDetalle');

        return view('plantrabajo', compact('accidente','auditoria', 'capacitacion','programa', 'examen', 'inspeccion', 'matrizlegal','grupoapoyo','actividadesgrupoapoyo','acpm'));
    }


}
