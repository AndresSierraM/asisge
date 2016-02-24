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
        // -------------------------------------------
        // A C C I D E N T E S / I N C I D E N T E S
        // -------------------------------------------
        $accidente = DB::select(
            'SELECT nombreCompletoTercero as descripcionTarea,
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
            Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%") 
            group by Aus.Tercero_idTercero;');
        

        // -------------------------------------------
        // P L A N   D E   A U D I T O R I A
        // -------------------------------------------
        $auditoria = DB::select(
            'SELECT nombreProceso as descripcionTarea,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 1, 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 1, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 2, 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 2, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 3, 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 3, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 4, 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 4, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 5, 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 5, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 6, 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 6, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 7, 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 7, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 8, 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 8, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 9, 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 9, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 10, 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 10, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 11, 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 11, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 12, 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlanAuditoriaAgenda) = 12, IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as DiciembreC
            From planauditoria PA
            left join planauditoriaagenda PAA
            on PA.idPlanAuditoria = PAA.PlanAuditoria_idPlanAuditoria
            left join listachequeo LC
            on PA.idPlanAuditoria = LC.PlanAuditoria_idPlanAuditoria and PAA.Proceso_idProceso = LC.Proceso_idProceso
            left join proceso P
            on PAA.Proceso_idProceso = P.idProceso
            group by idPlanAuditoriaAgenda;');

        // -------------------------------------------
        //  P L A N   D E   C A P A C I T A C I O N
        // -------------------------------------------
        $capacitacion = DB::select(
            'SELECT nombrePlanCapacitacion  as descripcionTarea,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 1, 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 1, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 2, 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 2, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 3, 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 3, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 4, 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 4, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 5, 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 5, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 6, 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 6, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 7, 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 7, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 8, 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 8, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 9, 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 9, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 10, 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 10, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 11, 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 11, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 12, 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlanCapacitacionTema) = 12, IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as DiciembreC
            From plancapacitacion PC
            left join plancapacitaciontema PCT
            on PC.idPlanCapacitacion = PCT.PlanCapacitacion_idPlanCapacitacion
            left join actacapacitacion AC
            on PC.idPlanCapacitacion = AC.PlanCapacitacion_idPlanCapacitacion
            left join actacapacitaciontema ACT
            on AC.idActaCapacitacion = ACT.ActaCapacitacion_idActaCapacitacion and 
            PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
            group by idPlanCapacitacion');


        // -------------------------------------------
        //  P R O G R A M A S   /   A C T I V I D A D E S
        // -------------------------------------------
        $programa = DB::select(
            'SELECT nombrePrograma  as descripcionTarea,
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
                SUM(IF(MONTH(fechaPlaneadaProgramaDetalle) = 12, IF(fechaEjecucionProgramaDetalle IS NULL OR fechaEjecucionProgramaDetalle  = "0000-00-00", 0, 1), 0)) as DiciembreC
            From programa P
            left join programadetalle PD
            on P.idPrograma = PD.Programa_idPrograma
            Group by idPrograma');


        // -------------------------------------------
        //  E X A M E N E S   M E D I C O S
        // -------------------------------------------
        $examen = DB::select(
            'SELECT descripcionTarea,  COUNT(idTipoExamenMedico) as total, fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 1 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 1 AND RET = 1), 1 , 0)) as EneroT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 1 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 1 AND RET = 1), 0,  0)) as EneroC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 2 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 2 AND RET = 1), 1 , 0)) as FebreroT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 2 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 2 AND RET = 1), 1 , 0)) as FebreroC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 3 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 3 AND RET = 1), 1 , 0)) as MarzoT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 3 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 3 AND RET = 1), 1 , 0)) as MarzoC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 4 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 4 AND RET = 1), 1 , 0)) as AbrilT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 4 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 4 AND RET = 1), 1 , 0)) as AbrilC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 5 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 5 AND RET = 1), 1 , 0)) as MayoT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 5 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 5 AND RET = 1), 1 , 0)) as MayoC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 6 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 6 AND RET = 1), 1 , 0)) as JunioT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 6 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 6 AND RET = 1), 1 , 0)) as JunioC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 7 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 7 AND RET = 1), 1 , 0)) as JulioT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 7 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 7 AND RET = 1), 1 , 0)) as JulioC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 8 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 8 AND RET = 1), 1 , 0)) as AgostoT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 8 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 8 AND RET = 1), 1 , 0)) as AgostoC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 9 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 9 AND RET = 1), 1 , 0)) as SeptiembreT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 9 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 9 AND RET = 1), 1 , 0)) as SeptiembreC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 10 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 10 AND RET = 1), 1 , 0)) as OctubreT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 10 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 10 AND RET = 1), 1 , 0)) as OctubreC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 11 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 11 AND RET = 1), 1 , 0)) as NoviembreT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 11 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 11 AND RET = 1), 1 , 0)) as NoviembreC,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 12 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 12 AND RET = 1), 1 , 0)) as DiciembreT,
                SUM(IF((MONTH(fechaIngresoTerceroInformacion) = 12 AND ING =1) OR (MONTH(fechaRetiroTerceroInformacion) = 12 AND RET = 1), 1 , 0)) as DiciembreC
            FROM
            (
                SELECT idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TET.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join terceroexamenmedico TEM
                on T.idTercero = TEM.Tercero_idTercero
                left join tipoexamenmedico TET
                on TEM.TipoExamenMedico_idTipoExamenMedico = TET.idTipoExamenMedico
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL
                group by idTercero, idTipoExamenMedico
             
            UNION

                SELECT idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoexamenmedico CE
                on C.idCargo = CE.Cargo_idCargo
                left join tipoexamenmedico TEC
                on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL
                group by idTercero, idTipoExamenMedico
            ) Examen
            group by idTercero');


        return view('plantrabajo', compact('accidente','auditoria', 'capacitacion','programa', 'examen'));
    }


}