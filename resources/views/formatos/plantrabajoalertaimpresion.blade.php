@extends('layouts.formato')

@section('contenido')
	{!!Form::model($plantrabajo)!!}
	<?php

    function base64($archivo)
    {
      
        $logo = '&nbsp;';
        $fp = fopen($archivo,"r", 0);
        if($archivo != '' and $fp)
        {
           $imagen = fread($fp,filesize($archivo));
           fclose($fp);
           // devuelve datos cifrados en base64
           //  formatear $imagen usando la sem ntica del RFC 2045

           $base64 = chunk_split(base64_encode($imagen));
           $logo =  '<img src="data:image/png;base64,' . $base64 .'" alt="Texto alternativo" width="130px"/>';
        }
        return $logo;
    }

	#REALIZO TODAS LAS CONSULTAS QUE VAN AL PLAN DE TRABAJO HABITUAL

    function nombreMes($fecha)
    {
//http://181.143.108.226:8000/plantrabajoalerta/1?accion=imprimir
        $mes = (int) date("m", strtotime($fecha));
        $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        return $meses[$mes];
    }

    // -------------------------------------------
    // A C C I D E N T E S / I N C I D E N T E S
    // -------------------------------------------

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
           
            $columnas .= "SUM(IF((MONTH(fechaElaboracionAusentismo) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaElaboracionAusentismo) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaElaboracionAusentismo) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaElaboracionAusentismo) =  '".date("Y", strtotime($inicio))."'), IF(Acc.idAccidente IS NULL, 0, 1), 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);


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

        return imprimirTabla('Accidente', $accidente, 'accidente', $filtroEstado, $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    // P L A N   D E   A U D I T O R I A
    // -------------------------------------------

	function consultarAuditoria($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "SUM(IF((MONTH(fechaPlanAuditoriaAgenda) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlanAuditoriaAgenda) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaPlanAuditoriaAgenda) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlanAuditoriaAgenda) =  '".date("Y", strtotime($inicio))."'), IF(LC.idListaChequeo IS NULL, 0, 1), 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

		
        $auditoria = DB::select(
            'SELECT nombreProceso as descripcionTarea,
                idPlanAuditoria as idConcepto,
                '.$columnas.'
            From planauditoria PA
            left join planauditoriaagenda PAA
            on PA.idPlanAuditoria = PAA.PlanAuditoria_idPlanAuditoria
            left join listachequeo LC
            on PA.idPlanAuditoria = LC.PlanAuditoria_idPlanAuditoria and PAA.Proceso_idProceso = LC.Proceso_idProceso
            left join proceso P
            on PAA.Proceso_idProceso = P.idProceso
            Where  PA.Compania_idCompania = '.$idCompania .' 
            group by idPlanAuditoriaAgenda;');

            return imprimirTabla('Plan de Auditoría', $auditoria, 'auditoria', $filtroEstado, $fechaInicial, $fechaFinal);
	}


    // -------------------------------------------
    //  P L A N   D E   C A P A C I T A C I O N
    // -------------------------------------------

	function consultarCapacitacion($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "SUM(IF((MONTH(fechaPlanCapacitacionTema) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlanCapacitacionTema) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaPlanCapacitacionTema) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlanCapacitacionTema) =  '".date("Y", strtotime($inicio))."'), IF(ACT.ActaCapacitacion_idActaCapacitacion IS NULL, 0, 1), 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);
        
        $capacitacion = DB::select(
            'SELECT nombrePlanCapacitacion  as descripcionTarea,
                idPlanCapacitacion as idConcepto,
                '.$columnas.'
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

            return imprimirTabla('Plan de Capacitación', $capacitacion, 'capacitacion', $filtroEstado, $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  P R O G R A M A S   /   A C T I V I D A D E S
    // -------------------------------------------
	function consultarPrograma($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "SUM(IF((MONTH(fechaPlaneadaProgramaDetalle) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlaneadaProgramaDetalle) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaPlaneadaProgramaDetalle) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlaneadaProgramaDetalle) =  '".date("Y", strtotime($inicio))."'), IF(fechaEjecucionProgramaDetalle IS NULL, 0, 1), 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

        $programa = DB::select(
            'SELECT nombrePrograma  as descripcionTarea,
                idPrograma as idConcepto,
                '.$columnas.'
            From programa P
            left join programadetalle PD
            on P.idPrograma = PD.Programa_idPrograma
            Where  P.Compania_idCompania = '.$idCompania .' 
            Group by idPrograma');

            return imprimirTabla('Programas', $programa, 'programa', $filtroEstado, $fechaInicial, $fechaFinal);   
	}

    // -------------------------------------------
    //  E X A M E N E S   M E D I C O S
    // -------------------------------------------

	function consultarExamen($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
            if (date("m", strtotime($inicio)) == '12')
            {
                $columnas .= "SUM(IF((MONTH(fechaIngresoTerceroInformacion) = '".date("m", strtotime($inicio))."' AND 
                        YEAR(fechaIngresoTerceroInformacion) = '".date("Y", strtotime($inicio))."' AND ING =1) OR 
                        (MONTH(fechaRetiroTerceroInformacion) = '".date("m", strtotime($inicio))."' AND 
                        YEAR(fechaIngresoTerceroInformacion) = '".date("Y", strtotime($inicio))."' AND RET = 1) OR 
                        (MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')
                      ), 1 , 0) OR (unidadFrecuenciaMedicion IN ('Años'))) as " . nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';
                
            }
            else
            {
                $columnas .= "SUM(IF((MONTH(fechaIngresoTerceroInformacion) = '".date("m", strtotime($inicio))."' AND 
                        YEAR(fechaIngresoTerceroInformacion) = '".date("Y", strtotime($inicio))."' AND ING =1) OR 
                        (MONTH(fechaRetiroTerceroInformacion) = '".date("m", strtotime($inicio))."' AND 
                        YEAR(fechaIngresoTerceroInformacion) = '".date("Y", strtotime($inicio))."' AND RET = 1) OR 
                        (MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')
                      ), 1 , 0)) as " . nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';
            }

            $columnas .= "SUM(IF(MONTH(fechaExamenMedico) = '".date("m", strtotime($inicio))."' and  YEAR(fechaExamenMedico) =  '".date("Y", strtotime($inicio))."', 1, 0 )) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

        $examen = DB::Select(
            'SELECT nombreTipoExamenMedico, descripcionTarea, 
                idFrecuenciaMedicion as idConcepto,
                '.$columnas.'
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

            return imprimirTablaExamenesMedicos('Examen Médico', $examen, 'examen', $filtroEstado, $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  I N S P E C C I O N E S   D E   S E G U R I D A D
    // -------------------------------------------

	function consultarInspeccion($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
             $columnas .= "SUM(IF((MOD('".date("m", strtotime($inicio))."',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaElaboracionInspeccion) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaElaboracionInspeccion) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);


        $inspeccion = DB::select(
            'SELECT nombreTipoInspeccion as descripcionTarea, 
                idTipoInspeccion as idConcepto,
                '.$columnas.'
            FROM tipoinspeccion TI
            left join frecuenciamedicion FM
            on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            left join inspeccion I
            on TI.idTipoInspeccion = I.TipoInspeccion_idTipoInspeccion
            Where TI.Compania_idCompania = '.$idCompania .' 
            group by idTipoInspeccion');

            return imprimirTabla('Inspección', $inspeccion, 'inspeccion', $filtroEstado, $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  M A T R I Z   L E G A L
    // -------------------------------------------

	function consultarMatriz($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
    {
        // Segun el rango de fechas del filtro, creamos para cada Mes o cada Año una columna 
        // independiente
        // ------------------------------------------------
        // Enero    Febrero     Marzo   Abril......
        // ------------------------------------------------
        $inicio = $fechaInicial;
        $anioAnt = date("Y", strtotime($inicio));
        $columnasLegal = '';
        $columnasRiesgo = '';

        while($inicio < $fechaFinal)
        {
            // adicionamos la columna del mes
             $columnasLegal .= "SUM(IF((MOD('".date("m", strtotime($inicio))."',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';
                
            $columnasLegal .= "SUM(IF((MONTH(fechaActualizacionMatrizLegal) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaActualizacionMatrizLegal) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';

            $columnasRiesgo .= "SUM(IF((MOD('".date("m", strtotime($inicio))."',valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnasRiesgo .= "SUM(IF((MONTH(fechaActualizacionMatrizRiesgo) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaActualizacionMatrizRiesgo) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';      

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnasLegal = substr($columnasLegal,0, strlen($columnasLegal)-2);
        $columnasRiesgo = substr($columnasRiesgo,0, strlen($columnasRiesgo)-2);


        $matrizlegal = DB::select(
            'SELECT concat("Matriz Legal: ",nombreMatrizLegal) as descripcionTarea, 
                        idMatrizLegal as idConcepto,
                '.$columnasLegal.'
            FROM matrizlegal ML
            left join frecuenciamedicion FM
            on ML.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            Where ML.Compania_idCompania = '.$idCompania .' 
            group by idMatrizLegal
            
            UNION
            
            SELECT concat("Matriz Riesgo: ",nombreMatrizRiesgo) as descripcionTarea, 
                idMatrizRiesgo as idConcepto,
                '.$columnasRiesgo.'
            FROM matrizriesgo MR
            left join frecuenciamedicion FM
            on MR.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            Where MR.Compania_idCompania = '.$idCompania .' 
            group by idMatrizRiesgo');

            return imprimirTabla('Revision de Información', $matrizlegal, 'matrizlegal', $filtroEstado, $fechaInicial, $fechaFinal);
    }

    // -------------------------------------------
    //  G R U P O S   D E   A P O Y O
    // -------------------------------------------

	function consultarGrupoApoyo($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "IF(MOD('".date("m", strtotime($inicio))."' AND (AGA.añoActa) =  '".date("Y", strtotime($inicio))."',GA.multiploMes) = 0, numeroTareas, 0) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF(AGA.mesActa = '".date("m", strtotime($inicio))."' AND (AGA.añoActa) =  '".date("Y", strtotime($inicio))."', numeroCumplidas, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));

        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

        $grupoapoyo = DB::Select(
            'SELECT 
                nombreGrupoApoyo as descripcionTarea, 
                idGrupoApoyo as idConcepto,
                '.$columnas.'

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
                    YEAR(fechaActaGrupoApoyo) AS añoActa,
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
                    YEAR(fechaActaGrupoApoyo) AS añoActa,
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
                GROUP BY GrupoApoyo_idGrupoApoyo , mesActa, añoActa
            ) AGAD
            on GA.idGrupoApoyo = AGAD.GrupoApoyo_idGrupoApoyo and AGA.mesActa = AGAD.mesActa
            group by idGrupoApoyo');

            return imprimirTabla('Acta Reunión', $grupoapoyo, 'grupoapoyo', $filtroEstado, $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  A C T A S   D E   R E U N I O N 
    // -------------------------------------------

	function consultarActividadGrupoApoyo($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "SUM(IF((MONTH(fechaPlaneadaActaGrupoApoyoDetalle) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaPlaneadaActaGrupoApoyoDetalle) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaPlaneadaActaGrupoApoyoDetalle) =  '".date("Y", strtotime($inicio))."'), IF(fechaEjecucionGrupoApoyoDetalle IS NULL, 0, 1), 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

		
        $actividadesgrupoapoyo = DB::select(
            'SELECT CONCAT(nombreGrupoApoyo, " - ", actividadGrupoApoyoDetalle) as descripcionTarea,
                idActaGrupoApoyoDetalle as idConcepto,
                '.$columnas.'
            From actagrupoapoyodetalle agpd
            left join actagrupoapoyo agp
            on agpd.ActaGrupoApoyo_idActaGrupoApoyo = agp.idActaGrupoApoyo
            left join grupoapoyo ga
            on ga.idGrupoApoyo = agp.GrupoApoyo_idGrupoApoyo
            Where  agp.Compania_idCompania = '.$idCompania .'
            Group by ga.idGrupoApoyo, idActaGrupoApoyoDetalle');

			return imprimirTabla('Acta Reunión - Actividades', $actividadesgrupoapoyo, 'actividadesgrupoapoyo', $filtroEstado, $fechaInicial, $fechaFinal);
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
    $mes = date('m');
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

    $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $nombreMesPasado = $meses[$mesInicial];
    $nombreMesFuturo = $meses[$mesFinal];

    $fechaInicial = $añoInicial.'-'. str_repeat ( '0' , 2 - strlen($mesInicial)).$mesInicial.'-01';
    $fechaFinal  = date("Y-m-d", mktime(0,0,0, $mesFinal+1, 0, $añoFinal));

    // $fechaFinal  = date('Y-m-d', strtotime($añoFinal.'-'.$mesFinal.' last day')); 

    // echo $fechaInicial.'-----------'.$fechaFinal;
    // return;
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
    $informe = '';
    for ($i=0; $i < count($plan) ; $i++) 
    { 
        $filtroEstado = $plan[0]['filtroEstadosPlanTrabajoAlerta'];

   		if ($plan[$i]['Modulo_idModulo'] == 3) 
        {
            $informe .= consultarAccidente($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 9) 
        {
       		$informe .= consultarGrupoApoyo($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 43) 
        {
       		$informe .= consultarActividadGrupoApoyo($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 22) 
        {
            $informe .= consultarExamen($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 24) 
        {
            $informe .= consultarInspeccion($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 32) 
        {
            $informe .= consultarAuditoria($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 36) 
        {
            $informe .= consultarCapacitacion($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 40) 
        {
            $informe .= consultarPrograma($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan[$i]['Modulo_idModulo'] == 30) 
        {
            $informe .= consultarMatriz($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
    }
    echo $informe ;


    
    
    //creamos un archivo (fopen) extension html
    $arch = fopen(public_path().'/plantrabajo.html', "w");

    // escribimos en el archivo todo el HTML del informe (fputs)
    fputs ($arch, $informe);

    // cerramos el archivo (fclose)
    fclose($arch);

    // enviamos un correo con la informacion de la tabla plantrabajoalerta y le adjuntamos el archivo que acabamos de crear


    $plan['mensaje'] = $plan[0]['correoMensajePlanTrabajoAlerta'];

    if ($plan[0]['correoCopiaPlanTrabajoAlerta'] != '' and $plan[0]['correoCopiaOcultaPlanTrabajoAlerta'] != '')
    {
        Mail::send('emails.contact',$plan,function($msj) use ($plan)
        {
            $msj->to($plan[0]['correoParaPlanTrabajoAlerta']);
            $msj->subject($plan[0]['correoAsuntoPlanTrabajoAlerta']);
            $msj->cc($plan[0]['correoCopiaPlanTrabajoAlerta']);    
            $msj->bcc($plan[0]['correoCopiaOcultaPlanTrabajoAlerta']);
            $msj->attach(public_path().'/plantrabajo.html'); 
        }); 
    }
    else if($plan[0]['correoCopiaOcultaPlanTrabajoAlerta'] !== '')
    {
        Mail::send('emails.contact',$plan,function($msj) use ($plan)
        { 
            $msj->to($plan[0]['correoParaPlanTrabajoAlerta']);
            $msj->subject($plan[0]['correoAsuntoPlanTrabajoAlerta']);
            $msj->bcc($plan[0]['correoCopiaOcultaPlanTrabajoAlerta']);    
            $msj->attach(public_path().'/plantrabajo.html');
        }); 
    }
    else if($plan[0]['correoCopiaPlanTrabajoAlerta'] !== '')
    {
        Mail::send('emails.contact',$plan,function($msj) use ($plan)
        { 
            $msj->to($plan[0]['correoParaPlanTrabajoAlerta']);
            $msj->subject($plan[0]['correoAsuntoPlanTrabajoAlerta']);
            $msj->cc($plan[0]['correoCopiaPlanTrabajoAlerta']);    
            $msj->attach(public_path().'/plantrabajo.html');
        }); 
    }
    else
    {
        Mail::send('emails.contact',$plan,function($msj) use ($plan)
        {
            $msj->to($plan[0]['correoParaPlanTrabajoAlerta']);
            $msj->subject($plan[0]['correoAsuntoPlanTrabajoAlerta']);
            $msj->attach(public_path().'/plantrabajo.html');
        }); 
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
        <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
               		<div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
                          </h4>
                        </div>
                        <div id="'.$idtabla.'" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  border="1" style="width:100%;" >
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
                                                    $resultado = '$tarea = '.'$dato->'.nombreMes($inicio).date("Y", strtotime($inicio)).'T;';
                                                    eval("$resultado");

                                                    $resultado = '$cumplido = '.'$dato->'.nombreMes($inicio).date("Y", strtotime($inicio)).'C;';
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
                    	      </div>
                          </body>
                        </html>';

	    return $tabla;
   }

   function imprimirTablaExamenesMedicos($titulo, $informacion, $idtabla, $filtroEstado, $fechaInicial, $fechaFinal)
    {

        
        $tabla = '';

        $tabla .= '
          <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
                  </h4>
                </div>
                <div id="'.$idtabla.'" class="panel-collapse">
                  <div class="panel-body" style="overflow:auto;">';

        $dato = array();
        for ($i=0; $i < count($informacion); $i++) 
        { 
            $dato[] = get_object_vars($informacion[$i]);
        }

        // hacemos rompimiento por el campo de Tipo de examen medico
        $reg = 0;
        while ($reg < count($dato)) 
        {
            $examenAnt = $dato[$reg]['nombreTipoExamenMedico'];
        
            $tabla .= '<div class="panel panel-primary" style="border:1px solid">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#'.str_replace(" ", "_", $examenAnt).'" href="#'.str_replace(" ", "_", $examenAnt).'">'.$examenAnt.'</a> 
                  </h4>
                </div>
                <div id="'.str_replace(" ", "_", $examenAnt).'" class="panel-collapse">
                  <div class="panel-body" style="overflow:auto;">';

            $tabla .= '<table  border="1" style="width:100%;" >
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

            while ($reg < count($dato) AND $examenAnt == $dato[$reg]['nombreTipoExamenMedico']) 
            {       
                $tabla .= '<tr align="center">
                             <th scope="row">'.$dato[$reg]["descripcionTarea"].'</th>';
                                               
                                $inicio = $fechaInicial;
                                $anioAnt = date("Y", strtotime($inicio));
                                while($inicio < $fechaFinal)
                                {
                                    $resultado = '$tarea = '.'$dato[$reg]["'.nombreMes($inicio).date("Y", strtotime($inicio)).'T"];';
                                    eval("$resultado");

                                    $resultado = '$cumplido = '.'$dato[$reg]["'.nombreMes($inicio).date("Y", strtotime($inicio)).'C"];';
                                    eval("$resultado");

                                    // adicionamos la columna del mes
                                    $tabla .= '<td >'. colorTarea($tarea, $cumplido, $filtroEstado).'</td>';
                                    //Avanzamos al siguiente mes
                                    $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                }
                $tabla .= '</tr>';
                $reg++;
            }

            $tabla .= '</tbody>
                </table>
              </div> 
            </div>
          </div>';
        }
            $tabla .= '</div> 
                </div>
                </div>
            </body>
        </html>';

        return $tabla;

    }

       

	?>
	{!!Form::close()!!}
@stop