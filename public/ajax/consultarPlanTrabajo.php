<?php

$año = $_POST['año'];
$letra = $_POST['letra'];
$informe = '';

	#REALIZO TODAS LAS CONSULTAS QUE VAN AL PLAN DE TRABAJO HABITUAL

    function nombreMes($fecha)
    {
        $mes = (int) date("m", strtotime($fecha));
        $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        return $meses[$mes];
    }

    // -------------------------------------------
    // A C C I D E N T E S / I N C I D E N T E S
    // -------------------------------------------

	function consultarAccidente($idCompania, $fechaInicial, $fechaFinal)
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
            left join
            compania c ON Aus.Compania_idCompania = c.idCompania
            Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
                Aus.Compania_idCompania = '.$idCompania .' 
            group by Aus.Tercero_idTercero;');

        return imprimirTabla('Accidente', $accidente, 'accidente', $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    // P L A N   D E   A U D I T O R I A
    // -------------------------------------------

	function consultarAuditoria($idCompania, $fechaInicial, $fechaFinal)
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
            left join compania c 
            on PA.Compania_idCompania = c.idCompania
            Where  PA.Compania_idCompania = '.$idCompania .' 
            group by idPlanAuditoriaAgenda;');

            return imprimirTabla('Plan de Auditoría', $auditoria, 'auditoria', $fechaInicial, $fechaFinal);
	}


    // -------------------------------------------
    //  P L A N   D E   C A P A C I T A C I O N
    // -------------------------------------------

	function consultarCapacitacion($idCompania, $fechaInicial, $fechaFinal)
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
            left join compania c
            on PC.Compania_idCompania = c.idCompania
            Where  PC.Compania_idCompania = '.$idCompania .'
            group by idPlanCapacitacion');

            return imprimirTabla('Plan de Capacitación', $capacitacion, 'capacitacion', $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  P R O G R A M A S   /   A C T I V I D A D E S
    // -------------------------------------------
	function consultarPrograma($idCompania, $fechaInicial, $fechaFinal)
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
                '.$columnas.',
                SUM(recursoPlaneadoProgramaDetalle) as PresupuestoT,
                SUM(recursoEjecutadoProgramaDetalle) as PresupuestoC
            From programa P
            left join programadetalle PD
            on P.idPrograma = PD.Programa_idPrograma
            Where  P.Compania_idCompania = '.$idCompania .' 
            Group by idPrograma');

            return imprimirTabla('Programas', $programa, 'programa', $fechaInicial, $fechaFinal);   
	}

    // -------------------------------------------
    //  E X A M E N E S   M E D I C O S
    // -------------------------------------------

	function consultarExamen($idCompania, $fechaInicial, $fechaFinal, $letra, $año)
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
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, nombreCompletoTercero 
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
                group by idTercero
             
            UNION

                SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")") as descripcionTarea,  TEC.nombreTipoExamenMedico, 
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, ingresoCargoExamenMedico as ING, retiroCargoExamenMedico as RET,
                    IF(EMD.ExamenMedico_idExamenMedico IS NULL , "0000-00-00", EM.fechaExamenMedico) as fechaExamenMedico, idFrecuenciaMedicion, nombreCompletoTercero
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
            where nombreCompletoTercero like "'.$letra.'%"
            group by idTercero
            order by nombreCompletoTercero');

            return imprimirTablaExamenes('Examen Médico', $examen, 'examen', $fechaInicial, $fechaFinal, $año);
	}

    // -------------------------------------------
    //  I N S P E C C I O N E S   D E   S E G U R I D A D
    // -------------------------------------------

	function consultarInspeccion($idCompania, $fechaInicial, $fechaFinal)
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
             $columnas .= "SUM(IF((MOD('".date("m", strtotime($inicio))."',valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("m", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaElaboracionInspeccion) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaElaboracionInspeccion) =  '".date("Y", strtotime($inicio))."') AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("m", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';

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
            LEFT JOIN compania c 
            ON TI.Compania_idCompania = c.idCompania
            Where TI.Compania_idCompania = '.$idCompania .' 
            group by idTipoInspeccion');

            return imprimirTabla('Inspección', $inspeccion, 'inspeccion', $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  M A T R I Z   L E G A L
    // -------------------------------------------

	function consultarMatriz($idCompania, $fechaInicial, $fechaFinal)
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
             $columnasLegal .= "SUM(IF((MOD('".date("m", strtotime($inicio))."',valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("Y", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';
                
            $columnasLegal .= "SUM(IF((MONTH(fechaActualizacionMatrizLegal) =  '".date("m", strtotime($inicio))."' AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("Y", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') AND YEAR(fechaActualizacionMatrizLegal) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';

            $columnasRiesgo .= "SUM(IF((MOD('".date("m", strtotime($inicio))."',valorFrecuenciaMedicion) = 0 AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("Y", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') and unidadFrecuenciaMedicion IN ('Meses')), 1 , 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnasRiesgo .= "SUM(IF((MONTH(fechaActualizacionMatrizRiesgo) =  '".date("m", strtotime($inicio))."' AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("Y", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') AND YEAR(fechaActualizacionMatrizRiesgo) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';      

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
            left join compania c on ML.Compania_idCompania = c.idCompania 
            Where ML.Compania_idCompania = '.$idCompania .'
            group by idMatrizLegal
            
            UNION
            
            SELECT concat("Matriz Riesgo: ",nombreMatrizRiesgo) as descripcionTarea, 
                idMatrizRiesgo as idConcepto,
                '.$columnasRiesgo.'
            FROM matrizriesgo MR
            left join frecuenciamedicion FM
            on MR.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            left join compania c on MR.Compania_idCompania = c.idCompania
            Where MR.Compania_idCompania = '.$idCompania .' 
            group by idMatrizRiesgo');

            return imprimirTabla('Revision de Información', $matrizlegal, 'matrizlegal', $fechaInicial, $fechaFinal);
    }

    // -------------------------------------------
    //  G R U P O S   D E   A P O Y O
    // -------------------------------------------

	function consultarGrupoApoyo($idCompania, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "IF(MOD('".date("m", strtotime($inicio))."' AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("m", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') AND (AGA.añoActa) =  '".date("Y", strtotime($inicio))."',GA.multiploMes) = 0, numeroTareas, 0) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF(AGA.mesActa = '".date("m", strtotime($inicio))."' AND CONCAT(DATE_FORMAT(NOW(), '%Y-'), '".date("m", strtotime($inicio))."') >= DATE_FORMAT(fechaCreacionCompania, '%Y-%m') AND (AGA.añoActa) =  '".date("Y", strtotime($inicio))."', numeroCumplidas, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));

        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

        $grupoapoyo = DB::Select(
            'SELECT 
                nombreGrupoApoyo as descripcionTarea, 
                idGrupoApoyo as idConcepto,
                '.$columnas.',
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
                        valorFrecuenciaMedicion) AS multiploMes,
                    fechaCreacionCompania
                FROM
                    grupoapoyo GA
                        LEFT JOIN
                    frecuenciamedicion FM ON GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                        LEFT JOIN 
                    compania c ON GA.Compania_idCompania = c.idCompania
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

            return imprimirTabla('Acta Reunión', $grupoapoyo, 'grupoapoyo', $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  A C T A S   D E   R E U N I O N 
    // -------------------------------------------

	function consultarActividadGrupoApoyo($idCompania, $fechaInicial, $fechaFinal)
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
            'SELECT CONCAT(actividadGrupoApoyoDetalle) as descripcionTarea,
                idActaGrupoApoyoDetalle as idConcepto,
                '.$columnas.',
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
            and fechaEjecucionGrupoApoyoDetalle >= fechaCreacionCompania and fechaEjecucionGrupoApoyoDetalle >= fechaCreacionCompania
            Group by ga.idGrupoApoyo, idActaGrupoApoyoDetalle');

			return imprimirTabla('Acta Reunión - Actividades', $actividadesgrupoapoyo, 'actividadesgrupoapoyo', $fechaInicial, $fechaFinal);
	}

    // -------------------------------------------
    //  R E P O R T E     A C P M 
    // -------------------------------------------

    function consultarACPM($idCompania, $fechaInicial, $fechaFinal)
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
           
            $columnas .= "SUM(IF((MONTH(fechaReporteACPMDetalle) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaReporteACPMDetalle) =  '".date("Y", strtotime($inicio))."'), 1, 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'T, ';

            $columnas .= "SUM(IF((MONTH(fechaReporteACPMDetalle) =  '".date("m", strtotime($inicio))."' AND YEAR(fechaReporteACPMDetalle) =  '".date("Y", strtotime($inicio))."'), IF(fechaCierreReporteACPMDetalle IS NULL, 0, 1), 0)) as ". nombreMes($inicio).date("Y", strtotime($inicio)).'C, ';
            

            //Avanzamos al siguiente mes
            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
        }

        // Quitamos la ultima coma del concatenado de columnas
        $columnas = substr($columnas,0, strlen($columnas)-2);

        
        $actividadesgrupoapoyo = DB::select(
            'SELECT concat(IFNULL(nombreModulo,""), " - (", tipoReporteACPMDetalle , ")  ",descripcionReporteACPMDetalle) as descripcionTarea,
                idReporteACPMDetalle as idConcepto,
                '.$columnas.'
            From reporteacpmdetalle acpmd
            left join reporteacpm acpm
            on acpmd.ReporteACPM_idReporteACPM = acpm.idReporteACPM
            left join modulo m
            on acpmd.Modulo_idModulo = m.idModulo
            Where  acpm.Compania_idCompania = '.$idCompania.'
            Group by idReporteACPMDetalle
            order by fechaReporteACPMDetalle, descripcionReporteACPMDetalle');

            return imprimirTabla('Reporte ACPM', $actividadesgrupoapoyo, 'reporteacpm', $fechaInicial, $fechaFinal);
    }


	$idCompania = \Session::get('idCompania');

    $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

    $fechaInicial = ($año.'-01-01');
    $fechaFinal  = ($año.'-12-31');


            $informe .= consultarAccidente($idCompania, $fechaInicial, $fechaFinal);
       
       		$informe .= consultarGrupoApoyo($idCompania, $fechaInicial, $fechaFinal);
       
       		$informe .= consultarActividadGrupoApoyo($idCompania, $fechaInicial, $fechaFinal);
       
            $informe .= consultarExamen($idCompania, $fechaInicial, $fechaFinal, $letra, $año);
     
            $informe .= consultarInspeccion($idCompania, $fechaInicial, $fechaFinal);
      
            $informe .= consultarAuditoria($idCompania, $fechaInicial, $fechaFinal);
        
            $informe .= consultarCapacitacion($idCompania, $fechaInicial, $fechaFinal);
       
            $informe .= consultarPrograma($idCompania, $fechaInicial, $fechaFinal);
        
            $informe .= consultarACPM($idCompania, $fechaInicial, $fechaFinal);
       
            $informe .= consultarMatriz($idCompania, $fechaInicial, $fechaFinal);

   	#EJECUTO LA FUNCIÓN PARA VER DE QUE COLOR SE PINTARÁ EL SEMÁFORO Y QUE VALOR TENDRÁ 
function colorTarea($valorTarea, $valorCumplido)
{

    $icono = '';    
    $tool = 'Tareas Pendientes : '.number_format($valorTarea,0,'.',',')."\n".
            'Tareas Realizadas : '.number_format($valorCumplido,0,'.',','); 
    $etiqueta = '';
    if($valorTarea != $valorCumplido and $valorCumplido != 0)
    {
        $icono = 'Amarillo.png';
        $etiqueta = '<label>'.number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',').'%</label>';
    }elseif($valorTarea == $valorCumplido and $valorTarea != 0)
    {
        $icono = 'Verde.png';
    }
    elseif($valorTarea > 0 and $valorCumplido == 0)
    {
        $icono = 'Rojo.png';        
    }

    if($valorTarea != 0 or $valorCumplido != 0)
    {
        $icono =    '<a href="#" data-toggle="tooltip" data-placement="right" title="'.$tool.'">
                            <img src="images/iconosmenu/'.$icono.'"  width="30">
                        </a>'.$etiqueta;    
    }
    //$valorTarea .' '. $valorCumplido. 
    return $icono;
}

   function imprimirTabla($titulo, $informacion, $idtabla, $fechaInicial, $fechaFinal)
   {
   		$tabla = '';

   		$tabla .= '        
               		<div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
                          </h4>
                        </div>
                        <div id="'.$idtabla.'" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
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

                                
                						$tabla .= '
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                        </tr>
                    					</thead>
                    					<tbody>';

                                            $mesesC = 0;
                                            $mesesT = 0;

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

                                                    $mesesT += '$tarea = '.'$dato->'.nombreMes($inicio).date("Y", strtotime($inicio)).'T;';

                                                    $mesesC += '$tarea = '.'$dato->'.nombreMes($inicio).date("Y", strtotime($inicio)).'C;' ;

                                                    // adicionamos la columna del mes
                                                    $tabla .= '<td >'. colorTarea($tarea, $cumplido).'</td>';
                                                    //Avanzamos al siguiente mes
                                                    $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                                }

                                                $tabla.=
                                                '<td>'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'</td>
                                                <td>'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'</td>';

                                            $total = number_format(($mesesC / ($mesesT == 0 ? 1: $mesesT) *100),1,'.',',');

                                        $tabla.= '<td>'.$total.'</td>';

                                
                                        $tabla .= '</tr>';
                                            }


                    		$tabla.='	</tbody>
                    				</table>
                    	          </div> 
                    	        </div>
                    	      </div>';

	    return $tabla;
   }

   function imprimirTablaExamenes($titulo, $informacion, $idtabla, $fechaInicial, $fechaFinal, $año)
   {
        $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
                          </h4>
                        </div>';
                        $tabla .= 
                        '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value)" value="" type="button">Todos</button>';
                        for($i=65; $i<=90; $i++) 
                        {  
                            $letra = chr($i);  
                            $tabla .= 
                            '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value)" value="'.$letra.'" type="button">'.$letra.'</button>';
                        }

                        $tabla .= 
                        '<div id="'.$idtabla.'" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
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

                                
                                        $tabla .= '
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                        </tr>
                                        </thead>
                                        <tbody>';

                                            $mesesC = 0;
                                            $mesesT = 0;

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

                                                    $mesesT += '$tarea = '.(int)'$dato->'.nombreMes($inicio).date("Y", strtotime($inicio)).'T;';

                                                    $mesesC += '$tarea = '.(int)'$dato->'.nombreMes($inicio).date("Y", strtotime($inicio)).'C;' ;

                                                    // adicionamos la columna del mes
                                                    $tabla .= '<td >'. colorTarea($tarea, $cumplido).'</td>';
                                                    //Avanzamos al siguiente mes
                                                    $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                                }

                                                $tabla.=
                                                '<td>'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'</td>
                                                <td>'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'</td>';

                                            $total = number_format(($mesesC / ($mesesT == 0 ? 1: $mesesT) *100),1,'.',',');

                                        $tabla.= '<td>'.$total.'</td>';
                                
                                        $tabla .= '</tr>';
                                            }


                            $tabla.='   </tbody>
                                    </table>
                                  </div> 
                                </div>
                              </div>';

        return $tabla;
   }


    echo json_encode($informe);

	?>
	