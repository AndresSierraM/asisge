<?php

    #REALIZO TODAS LAS CONSULTAS QUE VAN AL PLAN DE TRABAJO HABITUAL

    function nombreMes($fecha)
    {
        $mes = (int) date("m", strtotime($fecha));
        $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        return $meses[$mes];
    }

    function nombreMesMinuscula($fecha)
    {
        $mes = (int) date("m", strtotime($fecha));
        $meses = array('', 'enero','febrero','marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        return $meses[$mes];
    }

    function buscarTerceroExamen($idTercero, $idExamen, $datos)
    {
        $pos = -1;

        for ($i=0; $i < count($datos); $i++) 
        { 

            if ($datos[$i]['idTercero'] == $idTercero && $datos[$i]['idConcepto'] == $idExamen) 
            {
                $pos = $i;
                $i = count($datos);
            }
        }

        return $pos;
    }

    function buscarMatriz($idConcepto, $tipo, $datos)
    {
        $pos = -1;

        for ($i=0; $i < count($datos); $i++) 
        { 

            if ($datos[$i]['idConcepto'] == $idConcepto && $datos[$i]['tipo'] == $tipo) 
            {
                $pos = $i;
                $i = count($datos);
            }
        }

        return $pos;
    }


    function buscarTerceroEPP($idTercero, $idElemento, $datos)
    {
        $pos = -1;

        for ($i=0; $i < count($datos); $i++) 
        { 

            if ($datos[$i]['idTercero'] == $idTercero && $datos[$i]['idConcepto'] == $idElemento) 
            {
                $pos = $i;
                $i = count($datos);
            }
        }

        return $pos;
    }

    
    function buscarTipoInspeccion($idTipoInspeccion, $datos)
    {
        $pos = -1;

        for ($i=0; $i < count($datos); $i++) 
        { 

            if ($datos[$i]['idTipoInspeccion'] == $idTipoInspeccion) 
            {
                $pos = $i;
                $i = count($datos);
            }
        }

        return $pos;
    }

    function buscarGrupoApoyo($idGrupoApoyo, $datos)
    {
        $pos = -1;

        for ($i=0; $i < count($datos); $i++) 
        { 

            if ($datos[$i]['idGrupoApoyo'] == $idGrupoApoyo) 
            {
                $pos = $i;
                $i = count($datos);
            }
        }

        return $pos;
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

        return imprimirTabla('Accidente', $accidente, 'accidente', $fechaInicial, $fechaFinal, 3);
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

            return imprimirTabla('Plan de Auditoría', $auditoria, 'auditoria', $fechaInicial, $fechaFinal, 32);
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

            return imprimirTabla('Plan de Capacitación', $capacitacion, 'capacitacion', $fechaInicial, $fechaFinal, 36);
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

            return imprimirTabla('Programas', $programa, 'programa', $fechaInicial, $fechaFinal, 40);   
	}

    // -------------------------------------------
    //  E X A M E N E S   M E D I C O S
    // -------------------------------------------

	function consultarExamen($idCompania, $fechaInicial, $fechaFinal, $letra, $año, $procesos, $idDiv)
    {

        //**********************
        //  C R E A C I O N 
        //  D E   L A S 
        //  T A R E A S 
        //*********************

        $examen = DB::Select(
            '   SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico as idConcepto, concat(nombreCompletoTercero , " (", nombreCargo, ")", " - ", TEC.nombreTipoExamenMedico) as descripcionTarea,   
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, 
                    IF(fechaInicioExamenMedicoTerceroInformacion > fechaCreacionCompania, fechaInicioExamenMedicoTerceroInformacion, fechaCreacionCompania) as fechaCreacionCompania,
                    ingresoCargoExamenMedico as ING, 
                    retiroCargoExamenMedico as RET,
                    periodicoCargoExamenMedico as PER,
                    idFrecuenciaMedicion, nombreCompletoTercero
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
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL   and 
                    ('.$año.' >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and 
                    '.$año.' <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR 
                    '.$año.' >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and 
                    '.$año.' <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                        fechaRetiroTerceroInformacion = "0000-00-00") AND
                        fechaIngresoTerceroInformacion != "0000-00-00" AND  
                    estadoTercero = "ACTIVO" AND nombreCompletoTercero like "'.$letra.'%" AND 
                    T.Compania_idCompania = '.$idCompania .' 
                order by nombreCompletoTercero, idTercero
           ');

        $datos = array();
          

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = buscarTerceroExamen($registro["idTercero"], $registro["idConcepto"], $datos);

            if($pos == -1)
            {
                $pos = count($datos);
                for($mes = 1; $mes <= 12; $mes++)
                {
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'T'] = 0;
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'C'] = 0;
                }
            }
            $datos[$pos]['idTercero'] = $registro["idTercero"];
            $datos[$pos]['idConcepto'] = $registro["idConcepto"];
            $datos[$pos]['Nombre'] = $registro["descripcionTarea"];

            

            // las tareas semanales o diarias deben crear 4 o 30 tareas en cada periodo respectivamente
            // las tareas expresadas en meses o años, solo deben poner una tarea en el periodo
            $frecuencia = ($registro['valorFrecuenciaMedicion'] == 0 ? 1 : $registro['valorFrecuenciaMedicion']);
            $multiplo = ((  $registro['unidadFrecuenciaMedicion'] == 'Años' or 
                            $registro['unidadFrecuenciaMedicion'] == 'Meses') 
                        ? 1 
                        : (($registro['unidadFrecuenciaMedicion'] == 'Semanas' ? 4 : 30) / $frecuencia)) ;

            // INGRESO
            if($registro["fechaIngresoTerceroInformacion"] != '0000-00-00' and $registro["ING"] == 1 and date("Y",strtotime($registro["fechaIngresoTerceroInformacion"])) == date("Y", strtotime($fechaInicial)) and 
                $registro["fechaIngresoTerceroInformacion"] >= $registro["fechaCreacionCompania"])
                $datos[$pos][date("m",strtotime($registro["fechaIngresoTerceroInformacion"])).'T'] += 1;

            // RETIRO
            if($registro["fechaRetiroTerceroInformacion"] != '0000-00-00' and $registro["RET"] == 1 and date("Y",strtotime($registro["fechaRetiroTerceroInformacion"])) == date("Y", strtotime($fechaInicial)))
                $datos[$pos][date("m",strtotime($registro["fechaRetiroTerceroInformacion"])).'T'] += 1;


            $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);
            
            // PERIODICIDAD
            if($registro["fechaIngresoTerceroInformacion"] != '0000-00-00' and $registro["PER"] == 1 and $periodicidad > 0)
            {
                
                $ingreso = date("Y-m-d",strtotime($registro["fechaIngresoTerceroInformacion"]));
                $ingreso = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($ingreso)));
                $retiro = $registro["fechaRetiroTerceroInformacion"] == '0000-00-00' ? date("Y-12-31") : $registro["fechaRetiroTerceroInformacion"];

                while($ingreso <= date("Y-12-31") and $ingreso < $retiro)
                {
                    
                    if (date("Y", strtotime($ingreso)) == date("Y", strtotime($fechaInicial)) and $ingreso >= $registro["fechaCreacionCompania"]) 
                    {
                        $datos[$pos][str_pad(date("m",strtotime($ingreso)), 2, '0', STR_PAD_LEFT).'T'] += (1*$multiplo);    
                    }

                    $ingreso = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($ingreso)));
                }
            }

            

        }

        //**********************
        //  C R E A C I O N 
        //  D E   L O S 
        //  C U M P L I M I E N T O S
        //*********************

        $examen = DB::Select(
            '   SELECT idTercero, idTipoExamenMedico,  fechaCreacionCompania, 
                       EM.fechaExamenMedico, idExamenMedico
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoexamenmedico CE
                on C.idCargo = CE.Cargo_idCargo
                left join tipoexamenmedico TEC
                on CE.TipoExamenMedico_idTipoExamenMedico = TEC.idTipoExamenMedico
                left join examenmedico EM 
                on T.idTercero = EM.Tercero_idTercero
                left join examenmedicodetalle EMD
                on EM.idExamenMedico = EMD.ExamenMedico_idExamenMedico and EMD.TipoExamenMedico_idTipoExamenMedico = CE.TipoExamenMedico_idTipoExamenMedico
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idTipoExamenMedico IS NOT NULL   and 
                    ('.$año.' >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and '.$año.' <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR '.$año.' >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and '.$año.' <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                        fechaRetiroTerceroInformacion = "0000-00-00") AND
                        fechaIngresoTerceroInformacion != "0000-00-00" AND 
                    estadoTercero = "ACTIVO" AND nombreCompletoTercero like "'.$letra.'%" AND 
                    EMD.ExamenMedico_idExamenMedico IS NOT NULL AND
                    T.Compania_idCompania = '.$idCompania .' 
                order by nombreCompletoTercero, idTercero
           ');
        
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = buscarTerceroExamen($registro["idTercero"], $registro["idTipoExamenMedico"], $datos);
            if($pos == -1)
                $pos = $i;
        
            $datos[$pos]['idConcepto'] = $registro["idTipoExamenMedico"];

            // CUMPLIMIENTO
            if($registro["fechaExamenMedico"] != '0000-00-00' and 
                date("Y",strtotime($registro["fechaExamenMedico"])) == date("Y", strtotime($fechaInicial)) and 
                $registro["fechaExamenMedico"] >= $registro["fechaCreacionCompania"])
            {
                $datos[$pos][date("m",strtotime($registro["fechaExamenMedico"])).'C'] += 1;
            }
        }


        $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#examenmedico">Examenes Medicos</a>
                          </h4>
                        </div>';
                        $tabla .= 
                        '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value,\''.$procesos.'\',\''.$idDiv.'\')" value="" type="button">Todos</button>';
                        for($i=65; $i<=90; $i++) 
                        {  
                            $letra = chr($i);  
                            $tabla .= 
                            '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value,\''.$procesos.'\',\''.$idDiv.'\')" value="'.$letra.'" type="button">'.$letra.'</button>';
                        }
                        $tabla .= '
                        <div id="examenmedico" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
                                    <thead class="thead-inverse">
                                        <tr class="table-info">
                                            <th scope="col" width="30%">&nbsp;</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Septiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                            <th>Meta</th>
                                            <th>Observación</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
                                        for ($i=0; $i <count($datos); $i++) 
                                        { 
                                            $tabla .= 
                                            '<tr align="center">
                                                <input type="hidden" id="idPlanTrabajoDetalle" name="idPlanTrabajoDetalle[]" value="null">
                                                <input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="22">
                                                <input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$datos[$i]['idConcepto'].'">
                                                <input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="">

                                            <th scope="row">'
                                                .$datos[$i]["Nombre"].
                                            '<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$datos[$i]["Nombre"].'">
                                            </th>';
                                            
                                            
                                            for($mes = 1; $mes <= 12; $mes++)
                                            {
                                                $cMes = str_pad($mes,2,'0',STR_PAD_LEFT);
                                                $fechaMes = date("Y-".$cMes."-01");
                                                $tabla .= 
                                                    '<td>'.colorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).
                                                    '<input type="hidden" id="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle" name="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle[]" 
                                                            value="'.valorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).'">
                                                    </td>';
                                            }

                                            $tabla .= 
                                                '<td>
                                                    0
                                                    <input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    0
                                                    <input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    0
                                                    <input type="hidden" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    <textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">
                                                    </textarea>
                                                </td>
                                            </tr>';
                                        }
                                        $tabla .= '
                                        </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>';

        return $tabla;
	}



    // -------------------------------------------
    //  E N T R E G A   D E   E P P 
    // -------------------------------------------

	function consultarEntregaEPP($idCompania, $fechaInicial, $fechaFinal, $letra, $año, $procesos, $idDiv)
    {

        //**********************
        //  C R E A C I O N 
        //  D E   L A S 
        //  T A R E A S 
        //*********************

        $examen = DB::Select(
            '   SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, 
                    idElementoProteccion as idConcepto, 
                    concat(nombreCompletoTercero , " (", nombreCargo, ")", " - ", EP.nombreElementoProteccion) as descripcionTarea,   
                    fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, fechaCreacionCompania, 
                    idFrecuenciaMedicion, nombreCompletoTercero
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoelementoproteccion CE
                on C.idCargo = CE.Cargo_idCargo
                left join frecuenciamedicion FM
                on CE.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
                left join elementoproteccion EP
                on CE.ElementoProteccion_idElementoProteccion = EP.idElementoProteccion
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idElementoProteccion IS NOT NULL   and 
                    ('.$año.' >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and 
                    '.$año.' <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR 
                    '.$año.' >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and 
                    '.$año.' <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                        fechaRetiroTerceroInformacion = "0000-00-00") AND
                        fechaIngresoTerceroInformacion != "0000-00-00" AND  
                    estadoTercero = "ACTIVO" AND nombreCompletoTercero like "'.$letra.'%" AND 
                    T.Compania_idCompania = '.$idCompania .' 
                order by nombreCompletoTercero, idTercero
           ');

        $datos = array();
          

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = buscarTerceroEPP($registro["idTercero"], $registro["idConcepto"], $datos);

            if($pos == -1)
            {
                $pos = count($datos);
                for($mes = 1; $mes <= 12; $mes++)
                {
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'T'] = 0;
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'C'] = 0;
                }
            }
            $datos[$pos]['idTercero'] = $registro["idTercero"];
            $datos[$pos]['idConcepto'] = $registro["idConcepto"];
            $datos[$pos]['Nombre'] = $registro["descripcionTarea"];

            

            // las tareas semanales o diarias deben crear 4 o 30 tareas en cada periodo respectivamente
            // las tareas expresadas en meses o años, solo deben poner una tarea en el periodo
            $frecuencia = ($registro['valorFrecuenciaMedicion'] == 0 ? 1 : $registro['valorFrecuenciaMedicion']);
            $multiplo = ((  $registro['unidadFrecuenciaMedicion'] == 'Años' or 
                            $registro['unidadFrecuenciaMedicion'] == 'Meses') 
                        ? 1 
                        : (($registro['unidadFrecuenciaMedicion'] == 'Semanas' ? 4 : 30) / $frecuencia)) ;


            $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);
            
            // PERIODICIDAD
            if($registro["fechaIngresoTerceroInformacion"] != '0000-00-00' and $periodicidad > 0)
            {
                
                $ingreso = date("Y-m-d",strtotime($registro["fechaIngresoTerceroInformacion"]));
                $ingreso = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($ingreso)));
                $retiro = $registro["fechaRetiroTerceroInformacion"] == '0000-00-00' ? date("Y-12-31") : $registro["fechaRetiroTerceroInformacion"];

                while($ingreso <= date("Y-12-31") and $ingreso < $retiro)
                {
                    
                    if (date("Y", strtotime($ingreso)) == date("Y", strtotime($fechaInicial)) and $ingreso >= $registro["fechaCreacionCompania"]) 
                    {
                        $datos[$pos][str_pad(date("m",strtotime($ingreso)), 2, '0', STR_PAD_LEFT).'T'] += (1*$multiplo);    
                    }

                    $ingreso = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($ingreso)));
                }
            }

            

        }

        //**********************
        //  C R E A C I O N 
        //  D E   L O S 
        //  C U M P L I M I E N T O S
        //*********************

        $examen = DB::Select(
            '   SELECT idTercero, idElementoProteccion,  fechaCreacionCompania, 
                       fechaEntregaElementoProteccion, idEntregaElementoProteccion
                FROM tercero T
                left join terceroinformacion TI
                on T.idTercero = TI.Tercero_idTercero
                left join cargo C
                on T.Cargo_idCargo = C.idCargo
                left join cargoelementoproteccion CE
                on C.idCargo = CE.Cargo_idCargo
                left join elementoproteccion EP
                on CE.ElementoProteccion_idElementoProteccion = EP.idElementoProteccion
                left join entregaelementoproteccion EEP 
                on T.idTercero = EEP.Tercero_idTercero
                left join entregaelementoprotecciondetalle EEPD
                on  EP.idElementoProteccion = EEPD.ElementoProteccion_idElementoProteccion and 
                    EEP.idEntregaElementoProteccion = EEPD.EntregaElementoProteccion_idEntregaElementoProteccion
                left join compania COM
                on T.Compania_idCompania = COM.idCompania
                where tipoTercero like "%01%" and idElementoProteccion IS NOT NULL   and 
                    ('.$año.' >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and 
                    '.$año.' <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR 
                    '.$año.' >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and 
                    '.$año.' <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                        fechaRetiroTerceroInformacion = "0000-00-00") AND
                        fechaIngresoTerceroInformacion != "0000-00-00" AND 
                    estadoTercero = "ACTIVO" AND nombreCompletoTercero like "'.$letra.'%" AND 
                    EEPD.ElementoProteccion_idElementoProteccion IS NOT NULL AND
                    T.Compania_idCompania = '.$idCompania .' 
                order by nombreCompletoTercero, idTercero
           ');
        
        for($i= 0; $i < count($examen); $i++)
        {
            $registro = get_object_vars($examen[$i]);
            $pos = buscarTerceroEPP($registro["idTercero"], $registro["idElementoProteccion"], $datos);
            if($pos == -1)
                $pos = $i;
        
            $datos[$pos]['idConcepto'] = $registro["idElementoProteccion"];

            // CUMPLIMIENTO
            if($registro["fechaEntregaElementoProteccion"] != '0000-00-00' and 
                date("Y",strtotime($registro["fechaEntregaElementoProteccion"])) == date("Y", strtotime($fechaInicial)) and 
                $registro["fechaEntregaElementoProteccion"] >= $registro["fechaCreacionCompania"])
            {
                $datos[$pos][date("m",strtotime($registro["fechaEntregaElementoProteccion"])).'C'] += 1;
            }
        }


        $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#entregaEPP">Entrega EPP</a>
                          </h4>
                        </div>';
                        $tabla .= 
                        '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value,\''.$procesos.'\',\''.$idDiv.'\')" value="" type="button">Todos</button>';
                        for($i=65; $i<=90; $i++) 
                        {  
                            $letra = chr($i);  
                            $tabla .= 
                            '<button class="btn btn-primary" onclick="consultarPlanTrabajo('.$año.',this.value,\''.$procesos.'\',\''.$idDiv.'\')" value="'.$letra.'" type="button">'.$letra.'</button>';
                        }
                        $tabla .= '
                        <div id="entregaEPP" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
                                    <thead class="thead-inverse">
                                        <tr class="table-info">
                                            <th scope="col" width="30%">&nbsp;</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Septiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                            <th>Meta</th>
                                            <th>Observación</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
                                        for ($i=0; $i <count($datos); $i++) 
                                        { 
                                            $tabla .= 
                                            '<tr align="center">
                                                <input type="hidden" id="idPlanTrabajoDetalle" name="idPlanTrabajoDetalle[]" value="null">
                                                <input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="20">
                                                <input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$datos[$i]['idConcepto'].'">
                                                <input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="">

                                            <th scope="row">'
                                                .$datos[$i]["Nombre"].
                                            '<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$datos[$i]["Nombre"].'">
                                            </th>';
                                            
                                            
                                            for($mes = 1; $mes <= 12; $mes++)
                                            {
                                                $cMes = str_pad($mes,2,'0',STR_PAD_LEFT);
                                                $fechaMes = date("Y-".$cMes."-01");
                                                $tabla .= 
                                                    '<td>'.colorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).
                                                    '<input type="hidden" id="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle" name="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle[]" 
                                                            value="'.valorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).'">
                                                    </td>';
                                            }

                                            $tabla .= 
                                                '<td>
                                                    0
                                                    <input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    0
                                                    <input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    0
                                                    <input type="hidden" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    <textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">
                                                    </textarea>
                                                </td>
                                            </tr>';
                                        }
                                        $tabla .= '
                                        </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>';

        return $tabla;
	}

    // -------------------------------------------
    //  I N S P E C C I O N E S   D E   S E G U R I D A D
    // -------------------------------------------


    function consultarInspeccion($idCompania, $fechaInicial, $fechaFinal, $año)
    {

        //**********************
        //  C R E A C I O N 
        //  D E   L A S 
        //  T A R E A S 
        //*********************

        $tipoinspeccion = DB::Select(
            '   SELECT nombreTipoInspeccion as descripcionTarea, 
                idTipoInspeccion as idConcepto, 
                IF(fechaInicialTipoInspeccion > fechaCreacionCompania, fechaInicialTipoInspeccion, fechaCreacionCompania) as fechaCreacionCompania,
                valorFrecuenciaMedicion, unidadFrecuenciaMedicion
            FROM tipoinspeccion TI
            left join frecuenciamedicion FM
            on TI.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            LEFT JOIN compania c 
            ON TI.Compania_idCompania = c.idCompania
            Where TI.Compania_idCompania = '.$idCompania .' 
            group by idTipoInspeccion
           ');

        $datos = array();
          

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($tipoinspeccion); $i++)
        {
            $registro = get_object_vars($tipoinspeccion[$i]);
            $pos = buscarTipoInspeccion($registro["idConcepto"], $datos);

            if($pos == -1)
            {
                $pos = count($datos);
                for($mes = 1; $mes <= 12; $mes++)
                {
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'T'] = 0;
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'C'] = 0;
                }
            }
            $datos[$pos]['idTipoInspeccion'] = $registro["idConcepto"];
            $datos[$pos]['Nombre'] = $registro["descripcionTarea"];

            // las tareas semanales o diarias deben crear 4 o 30 tareas en cada periodo respectivamente
            // las tareas expresadas en meses o años, solo deben poner una tarea en el periodo
            $frecuencia = ($registro['valorFrecuenciaMedicion'] == 0 ? 1 : $registro['valorFrecuenciaMedicion']);
            $multiplo = ((  $registro['unidadFrecuenciaMedicion'] == 'Años' or 
                            $registro['unidadFrecuenciaMedicion'] == 'Meses') 
                        ? 1 
                        : (($registro['unidadFrecuenciaMedicion'] == 'Semanas' ? 4 : 30) / $frecuencia)) ;

            
            $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);

            // si la empresa se creó antes del año que estamos consultando, se debe pintar las tareas (fecha inicio enero del año consultado)
            // pero si su creación es posterior, no se deben pintar (fecha de inicio toma la de la compania)
            $fechaInicio = date("Y",strtotime($registro["fechaCreacionCompania"])) < $año 
                            ? date($año."-01-01")
                            : date("Y-m-d",strtotime($registro["fechaCreacionCompania"]));
        
            $fechaInicio = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($fechaInicio)));
            $fechaFin = date($año."-12-31");

            while($fechaInicio <= date("Y-12-31") and $fechaInicio < $fechaFin)
            {
                $datos[$pos][str_pad(date("m",strtotime($fechaInicio)), 2, '0', STR_PAD_LEFT).'T'] += (1*$multiplo);    
                
                $fechaInicio = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($fechaInicio)));
            }

        }

        //**********************
        //  C R E A C I O N 
        //  D E   L O S 
        //  C U M P L I M I E N T O S
        //*********************

        $tipoinspeccion = DB::Select(
            '  SELECT TipoInspeccion_idTipoInspeccion as idConcepto,
                        fechaElaboracionInspeccion, fechaCreacionCompania
            FROM inspeccion I
            LEFT JOIN compania c 
            ON I.Compania_idCompania = c.idCompania
            Where I.Compania_idCompania = '.$idCompania .' and DATE_FORMAT(fechaElaboracionInspeccion,"%Y") = '.$año.' 
           ');

        

        for($i= 0; $i < count($tipoinspeccion); $i++)
        {
            $registro = get_object_vars($tipoinspeccion[$i]);

            // si la empresa se creó antes del año que estamos consultando, se debe pintar las tareas (fecha inicio enero del año consultado)
            // pero si su creación es posterior, no se deben pintar (fecha de inicio toma la de la compania)
            $fechaInicio = date("Y",strtotime($registro["fechaCreacionCompania"])) < $año 
                        ? date($año."-01-01")
                        : date("Y-m-d",strtotime($registro["fechaCreacionCompania"]));

            $pos = buscarTipoInspeccion($registro["idConcepto"], $datos);

            $datos[$pos]['idTipoInspeccion'] = $registro["idConcepto"];
            // CUMPLIMIENTO
           if($registro["fechaElaboracionInspeccion"] != '0000-00-00' and 
                date("Y",strtotime($registro["fechaElaboracionInspeccion"])) == date("Y", strtotime($fechaInicio)) and 
                $registro["fechaElaboracionInspeccion"] >= $registro["fechaCreacionCompania"])
            {
                
                $datos[$pos][date("m",strtotime($registro["fechaElaboracionInspeccion"])).'C'] += 1;
            }
        }

        $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#inspeccion">Inspecciones</a>
                          </h4>
                        </div>';
                        
                        $tabla .= '
                        <div id="inspeccion" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
                                    <thead class="thead-inverse">
                                        <tr class="table-info">
                                            <th scope="col" width="30%">&nbsp;</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Septiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                            <th>Meta</th>
                                            <th>Observación</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
                                        for ($i=0; $i <count($datos); $i++) 
                                        { 
                                            $tabla .= 
                                            '<tr align="center">
                                                <input type="hidden" id="idPlanTrabajoDetalle" name="idPlanTrabajoDetalle[]" value="null">
                                                <input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="24">
                                                <input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$datos[$i]['idTipoInspeccion'].'">
                                                <input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="">

                                            <th scope="row">'
                                                .$datos[$i]["Nombre"].
                                            '<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$datos[$i]["Nombre"].'">
                                            </th>';
                                            
                                            
                                            for($mes = 1; $mes <= 12; $mes++)
                                            {
                                                $cMes = str_pad($mes,2,'0',STR_PAD_LEFT);
                                                $fechaMes = date("Y-".$cMes."-01");
                                                $tabla .= 
                                                    '<td>'.colorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).
                                                    '<input type="hidden" id="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle" name="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle[]" 
                                                            value="'.valorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).'">
                                                    </td>';
                                            }

                                            $tabla .= 
                                                '<td>
                                                    0
                                                    <input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    0
                                                    <input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    0
                                                    <input type="hidden" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="0">
                                                </td>
                                                <td>
                                                    <textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">
                                                    </textarea>
                                                </td>
                                            </tr>';

                                        }
                                        $tabla .= '
                                        </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>';

        return $tabla;
    }

    // -------------------------------------------
    //  M A T R I Z   L E G A L
    // -------------------------------------------

    function consultarMatriz($idCompania, $fechaInicial, $fechaFinal, $año)
    {

        //**********************
        //  C R E A C I O N 
        //  D E   L A S 
        //  T A R E A S 
        //*********************

        $matrices = DB::Select(
           'SELECT concat("Matriz Legal: ",nombreMatrizLegal) as descripcionTarea, 
                        idMatrizLegal as idConcepto, "legal" as tipo,  fechaElaboracionMatrizLegal as fechaInicio,
                        valorFrecuenciaMedicion, unidadFrecuenciaMedicion
            FROM matrizlegal ML
            left join frecuenciamedicion FM
            on ML.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            Where ML.Compania_idCompania = '.$idCompania .'
            group by idMatrizLegal
            
            UNION
            
            SELECT concat("Matriz Riesgo: ",nombreMatrizRiesgo) as descripcionTarea, 
                        idMatrizRiesgo as idConcepto, "riesgo" as tipo,  fechaElaboracionMatrizRiesgo as fechaInicio,
                        valorFrecuenciaMedicion, unidadFrecuenciaMedicion
            FROM matrizriesgo MR
            left join frecuenciamedicion FM
            on MR.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            Where MR.Compania_idCompania = '.$idCompania .' 
            group by idMatrizRiesgo');
           

        $datos = array();
          

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($matrices); $i++)
        {
            $registro = get_object_vars($matrices[$i]);
            $pos = buscarMatriz($registro["idConcepto"], $registro["tipo"], $datos);

            if($pos == -1)
            {
                $pos = count($datos);
                $datos[$pos]['idConcepto'] = $registro["idConcepto"];
                $datos[$pos]['Nombre'] = $registro["descripcionTarea"];
                $datos[$pos]['tipo'] = $registro["tipo"];
                
                for($mes = 1; $mes <= 12; $mes++)
                {
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'T'] = 0;
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'C'] = 0;
                }
            }
            

            // las tareas semanales o diarias deben crear 4 o 30 tareas en cada periodo respectivamente
            // las tareas expresadas en meses o años, solo deben poner una tarea en el periodo
            $frecuencia = ($registro['valorFrecuenciaMedicion'] == 0 ? 1 : $registro['valorFrecuenciaMedicion']);
            $multiplo = ((  $registro['unidadFrecuenciaMedicion'] == 'Años' or 
                            $registro['unidadFrecuenciaMedicion'] == 'Meses') 
                        ? 1 
                        : (($registro['unidadFrecuenciaMedicion'] == 'Semanas' ? 4 : 30) / $frecuencia)) ;

            
            $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);

            // si la empresa se creó antes del año que estamos consultando, se debe pintar las tareas (fecha inicio enero del año consultado)
            // pero si su creación es posterior, no se deben pintar (fecha de inicio toma la de la compania)
            $fechaInicio = date("Y",strtotime($registro["fechaInicio"])) < $año 
                            ? date($año."-01-01")
                            : date("Y-m-d",strtotime($registro["fechaInicio"]));
        
            $fechaInicio = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($fechaInicio)));
            $fechaFin = date($año."-12-31");

            while($fechaInicio <= date("Y-12-31") and $fechaInicio < $fechaFin)
            {
                $datos[$pos][str_pad(date("m",strtotime($fechaInicio)), 2, '0', STR_PAD_LEFT).'T'] += (1*$multiplo);    
                
                $fechaInicio = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($fechaInicio)));
            }

        }

        //**********************
        //  C R E A C I O N 
        //  D E   L O S 
        //  C U M P L I M I E N T O S
        //*********************

        $matrices = DB::Select(
            'SELECT concat("Matriz Legal: ",nombreMatrizLegal) as descripcionTarea, 
                        idMatrizLegal as idConcepto, "legal" as tipo,  idMatrizLegalActualizacion, 
                        fechaMatrizLegalActualizacion as fechaActualizacion
            FROM matrizlegal ML
            LEFT JOIN matrizlegalactualizacion MLA
            on ML.idMatrizLegal = MLA.MatrizLegal_idMatrizLegal
            Where ML.Compania_idCompania = '.$idCompania .' and YEAR(fechaMatrizLegalActualizacion) = "'.$año.'" 

            UNION
            
            SELECT concat("Matriz Riesgo: ",nombreMatrizRiesgo) as descripcionTarea, 
                        idMatrizRiesgo as idConcepto, "riesgo" as tipo,  idMatrizRiesgoActualizacion,
                        fechaMatrizRiesgoActualizacion as fechaActualizacion
            FROM matrizriesgo MR
            LEFT JOIN matrizriesgoactualizacion MRA
            on MR.idMatrizRiesgo = MRA.MatrizRiesgo_idMatrizRiesgo
            Where MR.Compania_idCompania = '.$idCompania .' and YEAR(fechaMatrizRiesgoActualizacion) = "'.$año.'" ');
            
        // si la empresa se creó antes del año que estamos consultando, se debe pintar las tareas (fecha inicio enero del año consultado)
        // pero si su creación es posterior, no se deben pintar (fecha de inicio toma la de la compania)
        

        for($i= 0; $i < count($matrices); $i++)
        {
            $registro = get_object_vars($matrices[$i]);
            
            // $fechaInicio = date("Y",strtotime($registro["fechaActualizacion"])) < $año 
            //             ? date($año."-01-01")
            //             : date("Y-m-d",strtotime($registro["fechaActualizacion"]));

            $pos = buscarMatriz($registro["idConcepto"], $registro["tipo"], $datos);

            //$datos[$pos]['idConcepto'] = $registro["idConcepto"];
            // CUMPLIMIENTO
            $datos[$pos][date("m",strtotime($registro["fechaActualizacion"])).'C'] += 1;
            
        }

        $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#matrices">Revisión de Información</a>
                          </h4>
                        </div>';
                        
                        $tabla .= '
                        <div id="matrices" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
                                    <thead class="thead-inverse">
                                        <tr class="table-info">
                                            <th scope="col" width="30%">&nbsp;</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Septiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                            <th>Meta</th>
                                            <th>Observación</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
                                        for ($i=0; $i <count($datos); $i++) 
                                        { 
                                            $tabla .= 
                                            '<tr align="center">
                                                <input type="hidden" id="idPlanTrabajoDetalle" name="idPlanTrabajoDetalle[]" value="null">
                                                <input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="30">
                                                <input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$datos[$i]["idConcepto"].'">
                                                <input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="">


                                            <td scope="row">'
                                                .$datos[$i]["Nombre"].
                                                '<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$datos[$i]["Nombre"].'">
                                            </td>';

                                            
                                            for($mes = 1; $mes <= 12; $mes++)
                                            {
                                                $cMes = str_pad($mes,2,'0',STR_PAD_LEFT);
                                                $fechaMes = date("Y-".$cMes."-01");
                                                $tabla .= 
                                                    '<td>'.colorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).
                                                    '<input type="hidden" id="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle" name="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle[]" 
                                                            value="'.valorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).'">
                                                    </td>';
                                            }
                                            
                                            $tabla .= 
                                            '<td>
                                                0
                                                <input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                0
                                                <input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                0
                                                <input type="hidden" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                <input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                <textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">
                                                </textarea>
                                            </td>
                                            
                                            </tr>';

                                        }
                                        $tabla .= '
                                        </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>';

        return $tabla;
    }


	function consultarMatrizVieja($idCompania, $fechaInicial, $fechaFinal)
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

            return imprimirTabla('Revision de Información', $matrizlegal, 'matrizlegal', $fechaInicial, $fechaFinal, 30);
    }

    // -------------------------------------------
    //  G R U P O S   D E   A P O Y O
    // -------------------------------------------

    function consultarGrupoApoyo($idCompania, $fechaInicial, $fechaFinal, $año)
    {

        //**********************
        //  C R E A C I O N 
        //  D E   L A S 
        //  T A R E A S 
        //*********************

        $grupoapoyo = DB::Select(
            '   SELECT nombreGrupoApoyo as descripcionTarea, 
                idGrupoApoyo as idConcepto, 
                IF(fechaConstitucionConformacionGrupoApoyo >= fechaCreacionCompania, fechaConstitucionConformacionGrupoApoyo, fechaCreacionCompania) as fechaCreacionCompania,
                valorFrecuenciaMedicion, unidadFrecuenciaMedicion
            FROM grupoapoyo GA
            left join conformaciongrupoapoyo CGA 
            on GA.idGrupoApoyo = CGA.GrupoApoyo_idGrupoApoyo
            left join frecuenciamedicion FM
            on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
            LEFT JOIN compania c 
            ON GA.Compania_idCompania = c.idCompania
            Where GA.Compania_idCompania = '.$idCompania .' 
            group by idGrupoApoyo
           ');

        $datos = array();
          

        //and nombreCompletoTercero like "'.$letra.'%"
        for($i= 0; $i < count($grupoapoyo); $i++)
        {
            $registro = get_object_vars($grupoapoyo[$i]);
            $pos = buscarGrupoApoyo($registro["idConcepto"], $datos);

            if($pos == -1)
            {
                $pos = count($datos);
                for($mes = 1; $mes <= 12; $mes++)
                {
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'T'] = 0;
                    $datos[$pos][str_pad($mes, 2, '0', STR_PAD_LEFT).'C'] = 0;
                }
            }
            $datos[$pos]['idGrupoApoyo'] = $registro["idConcepto"];
            $datos[$pos]['Nombre'] = $registro["descripcionTarea"];

            // las tareas semanales o diarias deben crear 4 o 30 tareas en cada periodo respectivamente
            // las tareas expresadas en meses o años, solo deben poner una tarea en el periodo
            $frecuencia = ($registro['valorFrecuenciaMedicion'] == 0 ? 1 : $registro['valorFrecuenciaMedicion']);
            $multiplo = ((  $registro['unidadFrecuenciaMedicion'] == 'Años' or 
                            $registro['unidadFrecuenciaMedicion'] == 'Meses') 
                        ? 1 
                        : (($registro['unidadFrecuenciaMedicion'] == 'Semanas' ? 4 : 30) / $frecuencia)) ;

            
            $periodicidad = $registro['valorFrecuenciaMedicion'] * ($registro['unidadFrecuenciaMedicion'] == 'Años' ? 12 : 1);

            // si la empresa se creó antes del año que estamos consultando, se debe pintar las tareas (fecha inicio enero del año consultado)
            // pero si su creación es posterior, no se deben pintar (fecha de inicio toma la de la compania)
            $fechaInicio = date("Y",strtotime($registro["fechaCreacionCompania"])) < $año 
                            ? date($año."-01-01")
                            : date("Y-m-d",strtotime($registro["fechaCreacionCompania"]));
        
            $fechaInicio = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($fechaInicio)));
            $fechaFin = date($año."-12-31");

            while($fechaInicio <= date("Y-12-31") and $fechaInicio < $fechaFin)
            {
                $datos[$pos][str_pad(date("m",strtotime($fechaInicio)), 2, '0', STR_PAD_LEFT).'T'] += (1*$multiplo);    
                
                $fechaInicio = date("Y-m-d",strtotime("+ ".$periodicidad." MONTH", strtotime($fechaInicio)));
            }

        }

        //**********************
        //  C R E A C I O N 
        //  D E   L O S 
        //  C U M P L I M I E N T O S
        //*********************

        $grupoapoyo = DB::Select(
            '  SELECT GrupoApoyo_idGrupoApoyo as idConcepto,
                        fechaActaGrupoApoyo, fechaCreacionCompania
            FROM actagrupoapoyo A
            LEFT JOIN compania c 
            ON A.Compania_idCompania = c.idCompania
            Where A.Compania_idCompania = '.$idCompania .' and DATE_FORMAT(fechaActaGrupoApoyo,"%Y") = '.$año.' 
           ');

        // si la empresa se creó antes del año que estamos consultando, se debe pintar las tareas (fecha inicio enero del año consultado)
        // pero si su creación es posterior, no se deben pintar (fecha de inicio toma la de la compania)
        

        for($i= 0; $i < count($grupoapoyo); $i++)
        {
            $registro = get_object_vars($grupoapoyo[$i]);
            
            $fechaInicio = date("Y",strtotime($registro["fechaCreacionCompania"])) < $año 
                        ? date($año."-01-01")
                        : date("Y-m-d",strtotime($registro["fechaCreacionCompania"]));

            $pos = buscarGrupoApoyo($registro["idConcepto"], $datos);

            $datos[$pos]['idGrupoApoyo'] = $registro["idConcepto"];
            // CUMPLIMIENTO
           if($registro["fechaActaGrupoApoyo"] != '0000-00-00' and 
                date("Y",strtotime($registro["fechaActaGrupoApoyo"])) == date("Y", strtotime($fechaInicio)) and 
                $registro["fechaActaGrupoApoyo"] >= $registro["fechaCreacionCompania"])
            {
                
                $datos[$pos][date("m",strtotime($registro["fechaActaGrupoApoyo"])).'C'] += 1;
            }
        }

        $tabla = '';

        $tabla .= '        
                    <div class="panel panel-primary" style="border:1px solid">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#actagrupoapoyo">Acta de Reunión de Grupos de Apoyo</a>
                          </h4>
                        </div>';
                        
                        $tabla .= '
                        <div id="actagrupoapoyo" class="panel-collapse"> 
                            <div class="panel-body" style="overflow:auto;">
                                <table  class="table table-striped table-bordered table-hover">
                                    <thead class="thead-inverse">
                                        <tr class="table-info">
                                            <th scope="col" width="30%">&nbsp;</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Septiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                            <th>Presupuesto</th>
                                            <th>Costo Real</th>
                                            <th>Cumplimiento</th>
                                            <th>Meta</th>
                                            <th>Observación</th>
                                        </tr>
                                        </thead>
                                        <tbody>';
                                        for ($i=0; $i <count($datos); $i++) 
                                        { 
                                            $tabla .= 
                                            '<tr align="center">
                                                <input type="hidden" id="idPlanTrabajoDetalle" name="idPlanTrabajoDetalle[]" value="null">
                                                <input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="9">
                                                <input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$datos[$i]["idGrupoApoyo"].'">
                                                <input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="">


                                            <td scope="row">'
                                                .$datos[$i]["Nombre"].
                                                '<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$datos[$i]["Nombre"].'">
                                            </td>';

                                            
                                            for($mes = 1; $mes <= 12; $mes++)
                                            {
                                                $cMes = str_pad($mes,2,'0',STR_PAD_LEFT);
                                                $fechaMes = date("Y-".$cMes."-01");
                                                $tabla .= 
                                                    '<td>'.colorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).
                                                    '<input type="hidden" id="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle" name="'.nombreMesMinuscula($fechaMes).'PlanTrabajoDetalle[]" 
                                                            value="'.valorTarea($datos[$i][$cMes.'T'],$datos[$i][$cMes.'C']).'">
                                                    </td>';
                                            }
                                            
                                            $tabla .= 
                                            '<td>
                                                0
                                                <input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                0
                                                <input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                0
                                                <input type="hidden" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                <input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="0">
                                            </td>
                                            <td>
                                                <textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">
                                                </textarea>
                                            </td>
                                            
                                            </tr>';

                                        }
                                        $tabla .= '
                                        </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>';

        return $tabla;
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

			return imprimirTabla('Acta Reunión - Actividades', $actividadesgrupoapoyo, 'actividadesgrupoapoyo', $fechaInicial, $fechaFinal, 43);
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

            return imprimirTabla('Reporte ACPM', $actividadesgrupoapoyo, 'reporteacpm', $fechaInicial, $fechaFinal, 1);
    }


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
                                <img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/'.$icono.'"  width="30">
                            </a>'.$etiqueta;    
        }
        //$valorTarea .' '. $valorCumplido. 
        return $icono;
    }

    function valorTarea($valorTarea, $valorCumplido)
    {

        $valor = '';    
        $valor = number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',');

        if ($valorTarea == 0 and $valorCumplido == 0) 
        {
            $valor = '';
        }
        
        return $valor;
    }

    function imprimirTabla($titulo, $informacion, $idtabla, $fechaInicial, $fechaFinal, $Modulo)
    {
        // creamos un consecutivo para los id de campos
        $consec = 0;
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
                                            <th >Meta</th>
                                            <th >Observación</th>
                                        </tr>
                                        </thead>
                                        <tbody>';

                                            $mesesC = 0;
                                            $mesesT = 0;
                                            $valorTarea = 0;
                                            $valorCumplido = 0;
                                            $total = 0;
                                            foreach($informacion as $dato)
                                            {
                                                $num = $Modulo.'_'.$consec;
                                                $tabla .='
                                                <tr align="center">
                                                    <input type="hidden" id="idPlanTrabajoDetalle'.$num.'" name="idPlanTrabajoDetalle[]" value="null">
                                                    <input type="hidden" id="Modulo_idModulo'.$num.'" name="Modulo_idModulo[]" value="'.$Modulo.'">
                                                    <input type="hidden" id="idConcepto'.$num.'" name="idConcepto[]" value="'.$dato->idConcepto.'">
                                                    <input type="hidden" id="TipoExamenMedico_idTipoExamenMedico'.$num.'" name="TipoExamenMedico_idTipoExamenMedico[]" value="">

                                                    <th scope="row">'
                                                        .$dato->descripcionTarea.
                                                        '<input type="hidden" id="nombreConceptoPlanTrabajoDetalle'.$num.'" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$dato->descripcionTarea.'">
                                                    </th>';
                                                
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
                                                    $tabla .= '
                                                    <td>'
                                                        .colorTarea($tarea, $cumplido).
                                                    '   <input type="hidden" id="'.nombreMesMinuscula($inicio).'PlanTrabajoDetalle'.$num.'" name="'.nombreMesMinuscula($inicio).'PlanTrabajoDetalle[]" value="'.valorTarea($tarea, $cumplido).'">
                                                    </td>';

                                                    $valorTarea += $tarea;
                                                    $valorCumplido += $cumplido;
                                                    //Avanzamos al siguiente mes
                                                    $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                                }

                                                    $tabla.=
                                                    '<td>'
                                                        .(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').
                                                    '<input type="hidden" id="presupuestoPlanTrabajoDetalle'.$num.'" name="presupuestoPlanTrabajoDetalle[]" value="'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'">
                                                    </td>
                                                    <td>'
                                                        .(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').
                                                    '<input type="hidden" id="costoRealPlanTrabajoDetalle'.$num.'" name="costoRealPlanTrabajoDetalle[]" value="'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'">
                                                    </td>';

                                                    $total = number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',');

                                                    $tabla.= '
                                                    <td>'
                                                        .$total.
                                                    '<input type="hidden" id="cumplimientoPlanTrabajoDetalle'.$num.'" name="cumplimientoPlanTrabajoDetalle[]" value="'.$total.'">
                                                    </td>

                                                    <td>
                                                        <input type="text" id="metaPlanTrabajoDetalle'.$num.'" name="metaPlanTrabajoDetalle[]" value="0">
                                                    </td>

                                                    <td>
                                                        <textarea id="observacionPlanTrabajoDetalle'.$num.'" name="observacionPlanTrabajoDetalle[]" >
                                                        </textarea>
                                                    </td>
                                                </tr>';

                                                $consec++;
                                            }


                            $tabla.='	</tbody>
                                    </table>
                                    </div> 
                                </div>
                                </div>';

        return $tabla;
    }

// *****************************
//
//  P R O C E S O   D E   
//
//  I N F O R M E 
//
// *****************************

    set_time_limit(0);

    $año = $_POST['año'];
    $letra = $_POST['letra'];
    // en procesos pueden enviar varios separados por coma
    $procesos = $_POST["procesos"];
    $idDiv = $_POST["idDiv"];

    $informe = '';

	$idCompania = \Session::get('idCompania');

    $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

    $fechaInicial = ($año.'-01-01');
    $fechaFinal  = ($año.'-12-31');

    if(strpos($procesos, 'Accidente') !== false or $procesos == '')
        $informe .= consultarAccidente($idCompania, $fechaInicial, $fechaFinal);
    if(strpos($procesos, 'GrupoApoyo') !== false or $procesos == '')
        $informe .= consultarGrupoApoyo($idCompania, $fechaInicial, $fechaFinal, $año);
    if(strpos($procesos, 'ActividadGrupoApoyo') !== false or $procesos == '')
        $informe .= consultarActividadGrupoApoyo($idCompania, $fechaInicial, $fechaFinal);
    if(strpos($procesos, 'Examen') !== false or $procesos == '')
        $informe .= consultarExamen($idCompania, $fechaInicial, $fechaFinal, $letra, $año, $procesos, $idDiv);
    if(strpos($procesos, 'EntregaEPP') !== false or $procesos == '')
        $informe .= consultarEntregaEPP($idCompania, $fechaInicial, $fechaFinal, $letra, $año, $procesos, $idDiv);
    if(strpos($procesos, 'Inspeccion') !== false or $procesos == '')
        $informe .= consultarInspeccion($idCompania, $fechaInicial, $fechaFinal, $año);
    if(strpos($procesos, 'Auditoria') !== false or $procesos == '')
        $informe .= consultarAuditoria($idCompania, $fechaInicial, $fechaFinal);
    if(strpos($procesos, 'Capacitacion') !== false or $procesos == '')
        $informe .= consultarCapacitacion($idCompania, $fechaInicial, $fechaFinal);
    if(strpos($procesos, 'Programa') !== false or $procesos == '')
        $informe .= consultarPrograma($idCompania, $fechaInicial, $fechaFinal);
    if(strpos($procesos, 'ACPM') !== false or $procesos == '')
        $informe .= consultarACPM($idCompania, $fechaInicial, $fechaFinal);
    if(strpos($procesos, 'Matriz') !== false or $procesos == '')
        $informe .= consultarMatriz($idCompania, $fechaInicial, $fechaFinal, $año);



    echo json_encode($informe);

	?>
	