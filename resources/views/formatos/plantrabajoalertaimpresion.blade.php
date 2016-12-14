@extends('layouts.formato')

@section('contenido')
	{!!Form::model($plantrabajo)!!}
	<?php

	#REALIZO TODAS LAS CONSULTAS QUE VAN AL PLAN DE TRABAJO HABITUAL

function nombreMes($fecha)
{

    $mes = (int) date("m", strtotime($fecha));
     $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    return $meses[$mes];
}

	function consultarAccidente($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
	{
            // Segun el rango de fechas del filtro, creamos para cada Mes o cada Año una columna 
            // independiente
            // ------------------------------------------------
            // Enero    Febrero     Marzo   Abril......
            // ------------------------------------------------
            $inicio = $fechaInicial;
            $anioAnt = date("Y", strtotime($inicio));
            $columnas = '';
            while($inicio < $fechaFinal)
            {

                // adicionamos la columna del mes
               
                $columnas .= "SUM(IF((MONTH(fechaElaboracionAusentismo) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaElaboracionAusentismo) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).'T, ';

                $columnas .= "SUM(IF((MONTH(fechaElaboracionAusentismo) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaElaboracionAusentismo) =  '".date("Y", strtotime($inicio))."'), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as ". nombreMes($inicio).'C, ';
                

                //Avanzamos al siguiente mes
                $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
            }

            // Quitamos la ultima coma del concatenado de columnas
            $columnas = substr($columnas,0, strlen($columnas)-2);



		// -------------------------------------------
        // A C C I D E N T E S / I N C I D E N T E S
        // -------------------------------------------
        $accidente = DB::select(
            'SELECT nombreCompletoTercero as descripcionTarea,
                idAusentismo as idConcepto,
                '.$columnas.'
            FROM ausentismo Aus
            left join accidente Acc
            on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
            left join tercero T
            on Aus.Tercero_idTercero = T.idTercero
            Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
                Aus.Compania_idCompania = '.$idCompania .' 
            group by Aus.Tercero_idTercero;');

        imprimirTabla('Accidente', $accidente, 'accidente', $filtroEstado, $fechaInicial, $fechaFinal);
	}

	function consultarAuditoria($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        // P L A N   D E   A U D I T O R I A
        // -------------------------------------------
        $auditoria = DB::select(
            'SELECT nombreProceso as descripcionTarea,
                idPlanAuditoria as idConcepto,
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
            Where  PA.Compania_idCompania = '.$idCompania .' 
            group by idPlanAuditoriaAgenda;');

            imprimirTabla('Plan de Auditoría', $auditoria, 'auditoria', $filtroEstado);
	}

	function consultarCapacitacion($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  P L A N   D E   C A P A C I T A C I O N
        // -------------------------------------------
        
        $capacitacion = DB::select(
            'SELECT nombrePlanCapacitacion  as descripcionTarea,
                idPlanCapacitacion as idConcepto,
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
            left join 
            (
                SELECT * 
                FROM  actacapacitaciontema ACT
                left join actacapacitacion AC
                on ACT.ActaCapacitacion_idActaCapacitacion = AC.idActaCapacitacion
                where AC.Compania_idCompania = '.$idCompania .' and ACT.cumpleObjetivoActaCapacitacionTema
            )  ACT
            on PCT.idPlanCapacitacionTema = ACT.PlanCapacitacionTema_idPlanCapacitacionTema  
            Where  PC.Compania_idCompania = '.$idCompania .' 
            group by idPlanCapacitacion');
            imprimirTabla('Plan de Capacitación', $capacitacion, 'capacitacion', $filtroEstado);
	}

	function consultarPrograma($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  P R O G R A M A S   /   A C T I V I D A D E S
        // -------------------------------------------
        $programa = DB::select(
            'SELECT nombrePrograma  as descripcionTarea,
                idPrograma as idConcepto,
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
            Group by idPrograma');

            imprimirTabla('Programas', $programa, 'programa', $filtroEstado);   
	}

	function consultarExamen($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  E X A M E N E S   M E D I C O S
        // -------------------------------------------
        $examen = DB::select(
            'SELECT nombreTipoExamenMedico, descripcionTarea, 
                idFrecuenciaMedicion as idConcepto,
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
                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TET.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoTerceroExamenMedico as ING, retiroTerceroExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion 
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

                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion
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
            group by nombreTipoExamenMedico, idTercero
            order by nombreTipoExamenMedico');
            imprimirTablaExamenesMedicos('Examen Médico', $examen, 'examen', $filtroEstado);
	}

	function consultarInspeccion($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  I N S P E C C I O N E S   D E   S E G U R I D A D
        // -------------------------------------------
        $inspeccion = DB::select(
            'SELECT nombreTipoInspeccion as descripcionTarea, 
                idTipoInspeccion as idConcepto,
                SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 1, 1, 0 )) as EneroC,
                SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 2, 1, 0 )) as FebreroC,
                SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 3, 1, 0 )) as MarzoC,
                SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 4, 1, 0 )) as AbrilC,
                SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 5, 1, 0 )) as MayoC,
                SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 6, 1, 0 )) as JunioC,
                SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 7, 1, 0 )) as JulioC,
                SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 8, 1, 0 )) as AgostoC,
                SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 9, 1, 0 )) as SeptiembreC,
                SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 10, 1, 0 )) as OctubreC,
                SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 11, 1, 0 )) as NoviembreC,
                SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaElaboracionInspeccion) = 12, 1, 0 )) as DiciembreC
            FROM tipoinspeccion TI
            left join frecuenciamedicion FM
            on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            left join inspeccion I
            on TI.idTipoInspeccion = I.TipoInspeccion_idTipoInspeccion
            Where TI.Compania_idCompania = '.$idCompania .' 
            group by idTipoInspeccion');

            imprimirTabla('Inspección', $inspeccion, 'inspeccion', $filtroEstado);
	}

	function consultarMatriz($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  M A T R I Z   L E G A L
        // -------------------------------------------
        $matrizlegal = DB::select(
            '           SELECT concat("Matriz Legal: ",nombreMatrizLegal) as descripcionTarea, 
                        idMatrizLegal as idConcepto,
                SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 1, 1, 0 )) as EneroC,
                SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 2, 1, 0 )) as FebreroC,
                SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 3, 1, 0 )) as MarzoC,
                SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 4, 1, 0 )) as AbrilC,
                SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 5, 1, 0 )) as MayoC,
                SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 6, 1, 0 )) as JunioC,
                SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 7, 1, 0 )) as JulioC,
                SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 8, 1, 0 )) as AgostoC,
                SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 9, 1, 0 )) as SeptiembreC,
                SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 10, 1, 0 )) as OctubreC,
                SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 11, 1, 0 )) as NoviembreC,
                SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizLegal) = 12, 1, 0 )) as DiciembreC
            FROM matrizlegal ML
            left join frecuenciamedicion FM
            on ML.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            Where ML.Compania_idCompania = '.$idCompania .' 
            group by idMatrizLegal
            
            UNION
            
            SELECT concat("Matriz Riesgo: ",nombreMatrizRiesgo) as descripcionTarea, 
                idMatrizRiesgo as idConcepto,
                SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 1, 1, 0 )) as EneroC,
                SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 2, 1, 0 )) as FebreroC,
                SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 3, 1, 0 )) as MarzoC,
                SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 4, 1, 0 )) as AbrilC,
                SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 5, 1, 0 )) as MayoC,
                SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 6, 1, 0 )) as JunioC,
                SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 7, 1, 0 )) as JulioC,
                SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 8, 1, 0 )) as AgostoC,
                SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 9, 1, 0 )) as SeptiembreC,
                SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 10, 1, 0 )) as OctubreC,
                SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 11, 1, 0 )) as NoviembreC,
                SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaActualizacionMatrizRiesgo) = 12, 1, 0 )) as DiciembreC
            FROM matrizriesgo MR
            left join frecuenciamedicion FM
            on MR.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            Where MR.Compania_idCompania = '.$idCompania .' 
            group by idMatrizRiesgo');

            imprimirTabla('Revision de Información', $matrizlegal, 'matrizlegal', $filtroEstado);
	}

	function consultarGrupoApoyo($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  G R U P O S   D E   A P O Y O
        // -------------------------------------------
        $grupoapoyo = DB::select(
            'SELECT 
                nombreGrupoApoyo as descripcionTarea, 
                idGrupoApoyo as idConcepto,
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

            imprimirTabla('Acta Reunión', $grupoapoyo, 'grupoapoyo', $filtroEstado);
	}

	function consultarActividadGrupoApoyo($idCompania, $filtroEstado)
	{
		// -------------------------------------------
        //  A C T A S   D E   R E U N I O N 
        // -------------------------------------------
        $actividadesgrupoapoyo = DB::select(
            'SELECT CONCAT(nombreGrupoApoyo, " - ", actividadGrupoApoyoDetalle) as descripcionTarea,
                idActaGrupoApoyoDetalle as idConcepto,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 1, 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 1, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 2, 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 2, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 3, 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 3, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 4, 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 4, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 5, 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 5, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 6, 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 6, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 7, 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 7, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 8, 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 8, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 9, 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 9, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 10, 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 10, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 11, 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 11, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 12, 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaPlaneadaActaGrupoApoyoDetalle) = 12, IF(fechaEjecucionGrupoApoyoDetalle IS NULL OR fechaEjecucionGrupoApoyoDetalle  = "0000-00-00", 0, 1), 0)) as DiciembreC,
                SUM(recursoPlaneadoActaGrupoApoyoDetalle) as PresupuestoT,
                SUM(recursoEjecutadoActaGrupoApoyoDetalle) as PresupuestoC
            From actagrupoapoyodetalle agpd
            left join actagrupoapoyo agp
            on agpd.ActaGrupoApoyo_idActaGrupoApoyo = agp.idActaGrupoApoyo
            left join grupoapoyo ga
            on ga.idGrupoApoyo = agp.GrupoApoyo_idGrupoApoyo
            Where  agp.Compania_idCompania = '.$idCompania .'
            Group by ga.idGrupoApoyo, idActaGrupoApoyoDetalle');

			imprimirTabla('Acta Reunión - Actividades', $actividadesgrupoapoyo, 'actividadesgrupoapoyo', $filtroEstado);
	}


	#RECIBO LA CONSULTA QUE LLEGA DESDE EL CONTROLADOR Y CONVIERTO DE ARRAY A STRING
	$plan = array();
	$idCompania = \Session::get('idCompania');
  		// por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
       for ($i = 0, $c = count($plantrabajo); $i < $c; ++$i) 
       {
          $plan[$i] = (array) $plantrabajo[$i];
       }


    #OBTENGO EL NUMERO Y EL NOMBRE DEL MES PASADO
    $mes = '06';//date('m');
    $añoInicial = date('Y');
    $añoFinal = date('Y');
    $mesInicial = $mes - $plan[0]["filtroMesesPasadosPlanTrabajoAlerta"];
    $mesFinal = $mes + $plan[0]["filtroMesesFuturosPlanTrabajoAlerta"];
    if($mesInicial > 12)
    {
        $mesInicial -= 12;
        $añoInicial += 1;
    }

    if($mesFinal > 12)
    {
        $mesFinal -= 12;
        $añoFinal += 1;
    }

    $meses = array('', 'enero','febrero','marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $nombreMesPasado = $meses[$mesInicial];
    $nombreMesFuturo = $meses[$mesFinal];

    $fechaInicial = $añoInicial.'-'. str_repeat ( '0' , 2 - strlen($mesInicial)).$mesInicial.'-01';
    $fechaFinal  = date('Y-m-d', strtotime($añoFinal.'-'.$mesFinal.' last day')); 

    // echo $fechaInicial.'-'.$fechaFinal;
    // $fechaPasada = strtotime ('-'.$plan[0]["filtroMesesPasadosPlanTrabajoAlerta"].' month',strtotime($fecha));
    // $fechaPasada = date ('Y-m-j',$fechaPasada);
    // $mesFechaPasada = date("m", strtotime($fechaPasada));  
    // setlocale(LC_TIME, 'spanish');  
    // $nombreMesPasado = strftime("%B",mktime(0, 0, 0, $mesFechaPasada, 1, 2000)); 

    // #OBTENGO EL NUMERO Y EL NOMBRE DEL MES FUTURO
    // $fechaFuturo = strtotime ('+'.$plan[0]["filtroMesesFuturosPlanTrabajoAlerta"].' month',strtotime($fecha));
    // $fechaFuturo = date ( 'Y-m-j' , $fechaFuturo );
    // $mesFechaFuturo = date("m", strtotime($fechaFuturo));  
    // setlocale(LC_TIME, 'spanish');  
    // $nombreMesFuturo = strftime("%B",mktime(0, 0, 0, $mesFechaFuturo, 1, 2000)); 

    // echo $nombreMesPasado.'-'.$nombreMesFuturo;

    #DEPENDIENDO DEL MODULO GUARDADO EN ESTE REGISTRO, REALIZO LA CONSULTA Y DESDE LA MISMA IMPRIMO EL INFORME
    for ($i=0; $i < count($plan) ; $i++) 
    { 
        $filtroEstado = $plan[0]['filtroEstadosPlanTrabajoAlerta'];

   		if ($plan[$i]['Modulo_idModulo'] == 3) 
        {
            consultarAccidente($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 9) 
        {
       		consultarGrupoApoyo($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 43) 
        {
       		consultarActividadGrupoApoyo($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 22) 
        {
            consultarExamen($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 24) 
        {
            consultarInspeccion($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 32) 
        {
            consultarAuditoria($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 36) 
        {
            consultarCapacitacion($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 40) 
        {
            consultarPrograma($idCompania, $filtroEstado);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 30) 
        {
            consultarMatriz($idCompania, $filtroEstado);
        }
    }


   	#EJECUTO LA FUNCIÓN PARA VER DE QUE COLOR SE PINTARÁ EL SEMÁFORO Y QUE VALOR TENDRÁ 
   	function colorTarea($valorTarea, $valorCumplido, $filtroEstado)
	{

		$icono = '';	
		$tool = 'Tareas Pendientes : '.number_format($valorTarea,0,'.',',')."\n".
				'Tareas Realizadas : '.number_format($valorCumplido,0,'.',',');	
		$etiqueta = '';

		if($valorTarea != $valorCumplido and $valorCumplido != 0)
		{

            if (strpos($filtroEstado,'2') !== false) 
            {
    			$icono = 'Amarillo.png';
    			$etiqueta = '<label>'.number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',').'%</label>';
            }
            else
            {
                $icono = '';
            }
		}

		elseif($valorTarea == $valorCumplido and $valorTarea != 0)
		{
            if (strpos($filtroEstado,'3') !== false) 
			$icono = 'Verde.png';
            else
                $icono = '';
		}

		elseif($valorTarea > 0 and $valorCumplido == 0)
		{
            if (strpos($filtroEstado,'1') !== false) 
                $icono = 'Rojo.png';    
			else
                $icono = '';
		}

		if($valorTarea != 0 or $valorCumplido != 0)
		{
            if ($icono == '') 
            {
                $icono = '';
            }
            else
            {
                $icono =    '<a href="#" data-toggle="tooltip" data-placement="right" title="'.$tool.'">
                                <img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/'.$icono.'"  width="30">
                            </a>'.$etiqueta;        
            }
			
		}
		return $icono;
	}

   function imprimirTabla($titulo, $informacion, $idtabla, $filtroEstado, $fechaInicial, $fechaFinal)
   {
   		$tabla = '';

   		$tabla .= '
   		<div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
              </h4>
            </div>
            <div id="'.$idtabla.'" class="panel-collapse"> <div class="panel-body" style="overflow:auto;">
                <table  class="table table-striped table-bordered table-hover" style="width:100%;" >
					<thead class="thead-inverse">
						<tr class="table-info">
							<th scope="col" width="30%">&nbsp;</th>';
							   
							$inicio = $fechaInicial;
                            $anioAnt = date("Y", strtotime($inicio));
                            while($inicio < $fechaFinal)
                            {
                                // adicionamos la columna del mes
                                $tabla .= '<th >'. nombreMes($inicio).'</th>';
                                //Avanzamos al siguiente mes
                                $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                            }

                
						$tabla .= '</tr>
    					</thead>
    					<tbody>';

                    foreach($informacion as $dato)
                            {
                                $tabla .='<tr align="center">
                                    <th scope="row">'.$dato->descripcionTarea.'</th>';
                               
                                $inicio = $fechaInicial;
                                $anioAnt = date("Y", strtotime($inicio));
                                while($inicio < $fechaFinal)
                                {
                                    $resultado = '$tarea = '.'$dato->'.nombreMes($inicio).'T;';
                                    eval("$resultado");

                                    $resultado = '$cumplido = '.'$dato->'.nombreMes($inicio).'C;';
                                    eval("$resultado");

                                    // adicionamos la columna del mes
                                    $tabla .= '<td >'. colorTarea($tarea, $cumplido, $filtroEstado).'</td>';
                                    //Avanzamos al siguiente mes
                                    $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                }

                
                        $tabla .= '</tr>';
                            }


		$tabla.='	</tbody>
				</table>
	          </div> 
	        </div>
	      </div>';

	    echo $tabla;
   }

       

	?>
	{!!Form::close()!!}
@stop