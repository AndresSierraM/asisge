<?php 

$compania = DB::Select('SELECT idCompania from compania ');

for ($i=0; $i < count($compania); $i++) 
{ 
	$idCompania = get_object_vars($compania[$i])['idCompania'];

	generarAlerta($idCompania);
}

function generarAlerta($idCompania)
{
	$plantrabajo = DB::Select('
		SELECT
			idPlanTrabajoAlerta,
			nombrePlanTrabajoAlerta,
			correoParaPlanTrabajoAlerta,
			correoCopiaPlanTrabajoAlerta,
			correoCopiaOcultaPlanTrabajoAlerta,
			correoAsuntoPlanTrabajoAlerta,
			correoMensajePlanTrabajoAlerta,
			tareaFechaInicioPlanTrabajoAlerta,
			tareaHoraPlanTrabajoAlerta,
			tareaDiaLaboralPlanTrabajoAlerta,
			tareaIntervaloPlanTrabajoAlerta,
			tareaDiasPlanTrabajoAlerta,
			tareaMesesPlanTrabajoAlerta,
			filtroMesesPasadosPlanTrabajoAlerta,
			filtroMesesFuturosPlanTrabajoAlerta,
			filtroEstadosPlanTrabajoAlerta,
			fechaUltimaAlertaPlanTrabajoAlerta,
			Modulo_idModulo
		FROM
			plantrabajoalerta pta
				LEFT JOIN 
			plantrabajoalertamodulo ptam ON pta.idPlanTrabajoAlerta = ptam.PlanTrabajoAlerta_idPlanTrabajoAlerta
		WHERE Compania_idCompania = '.$idCompania);

	for ($i=0; $i < count($plantrabajo); $i++) 
	{ 
		$plan = get_object_vars($plantrabajo[$i]);

		#OBTENGO EL NUMERO Y EL NOMBRE DE LOS MESES
	    $mes = date('m');
	    $añoInicial = date('Y');
	    $añoFinal = date('Y');
	    $mesInicial = $mes - $plan["filtroMesesPasadosPlanTrabajoAlerta"];
	    $mesFinal = $mes + $plan["filtroMesesFuturosPlanTrabajoAlerta"];
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

	    if($mesInicial < 0)
	    {
	        $mesInicial += 12;
	        $añoInicial -= 1;
	    }

	    $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	    $nombreMesPasado = $meses[$mesInicial];
	    $nombreMesFuturo = $meses[$mesFinal];

	    $fechaInicial = $añoInicial.'-'. str_repeat ( '0' , 2 - strlen($mesInicial)).$mesInicial.'-01';
	    $fechaFinal  = date("Y-m-d", mktime(0,0,0, $mesFinal+1, 0, $añoFinal));
	

		#DEPENDIENDO DEL MODULO GUARDADO EN ESTE REGISTRO, REALIZO LA CONSULTA Y DESDE LA MISMA IMPRIMO EL INFORME
	    $informe = '';
        $filtroEstado = $plan['filtroEstadosPlanTrabajoAlerta'];

   		if ($plan['Modulo_idModulo'] == 3) 
        {
            $informe .= consultarAccidente($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 9) 
        {
       		$informe .= consultarGrupoApoyo($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 43) 
        {
       		$informe .= consultarActividadGrupoApoyo($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 22) 
        {
            $informe .= consultarExamen($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 24) 
        {
            $informe .= consultarInspeccion($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 32) 
        {
            $informe .= consultarAuditoria($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 36) 
        {
            $informe .= consultarCapacitacion($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 40) 
        {
            $informe .= consultarPrograma($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 1) 
        {
            $informe .= consultarACPM($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        elseif ($plan['Modulo_idModulo'] == 30) 
        {
            $informe .= consultarMatriz($idCompania, $filtroEstado, $fechaInicial, $fechaFinal);
        }
        echo $informe ;       

        //creamos un archivo (fopen) extension html
	    $arch = fopen(public_path().'/plantrabajo.html', "w");

	    // escribimos en el archivo todo el HTML del informe (fputs)
	    fputs ($arch, $informe);

	    // cerramos el archivo (fclose)
	    fclose($arch);

	    //Programación diaria 
	    if ($plan['tareaDiasPlanTrabajoAlerta'] != '') 
        {
        	if (date('Y-m-d H-m-s') > date('Y-m-d H-m-s', strtotime($plan['fechaUltimaAlertaPlanTrabajoAlerta']))) 
        	{

		        $fechaActualizacion = date("Y-m-d", strtotime('+'.$plan['tareaIntervaloPlanTrabajoAlerta'].' day',  strtotime ($plan['fechaUltimaAlertaPlanTrabajoAlerta'])));

		        DB::Update('UPDATE plantrabajoalerta SET fechaUltimaAlertaPlanTrabajoAlerta = "'.$fechaActualizacion.'" WHERE idPlanTrabajoAlerta = '.$plan['idPlanTrabajoAlerta']);
        	}
        }
        else
        {
        	//Programación mensual
        	if ($plan['tareaMesesPlanTrabajoAlerta'] != '') 
        	{
        		if (date('Y-m-d H-m-s') > date('Y-m-d H-m-s', strtotime($plan['fechaUltimaAlertaPlanTrabajoAlerta']))) 
	        	{
			        $fechaActualizacion = date("Y-m-d", strtotime('+'.$plan['tareaIntervaloPlanTrabajoAlerta'].' month',  strtotime ($plan['fechaUltimaAlertaPlanTrabajoAlerta'])));

			        DB::Update('UPDATE plantrabajoalerta SET fechaUltimaAlertaPlanTrabajoAlerta = "'.$fechaActualizacion.'" WHERE idPlanTrabajoAlerta = '.$plan['idPlanTrabajoAlerta']);
	        	}
        	}
        	//Programación semanal
        	else
        	{
        		if (date('Y-m-d H-m-s') > date('Y-m-d H-m-s', strtotime($plan['fechaUltimaAlertaPlanTrabajoAlerta']))) 
	        	{
			        $fechaActualizacion = date("Y-m-d", strtotime('+'.$plan['tareaIntervaloPlanTrabajoAlerta'].' week',  strtotime ($plan['fechaUltimaAlertaPlanTrabajoAlerta'])));

			        DB::Update('UPDATE plantrabajoalerta SET fechaUltimaAlertaPlanTrabajoAlerta = "'.$fechaActualizacion.'" WHERE idPlanTrabajoAlerta = '.$plan['idPlanTrabajoAlerta']);
	        	}
        	}
        }

        $plan['mensaje'] = $plan['correoMensajePlanTrabajoAlerta'].'<br><br>'.$informe;

	    if ($plan['correoCopiaPlanTrabajoAlerta'] != '' and $plan['correoCopiaOcultaPlanTrabajoAlerta'] != '')
	    {
	        Mail::send('emails.contact',$plan,function($msj) use ($plan)
	        {
	            $msj->to($plan['correoParaPlanTrabajoAlerta']);
	            $msj->subject($plan['correoAsuntoPlanTrabajoAlerta']);
	            $msj->cc($plan['correoCopiaPlanTrabajoAlerta']);    
	            $msj->bcc($plan['correoCopiaOcultaPlanTrabajoAlerta']);
	            $msj->attach(public_path().'/plantrabajo.html'); 
	        }); 
	    }
	    else if($plan['correoCopiaOcultaPlanTrabajoAlerta'] !== '')
	    {
	        Mail::send('emails.contact',$plan,function($msj) use ($plan)
	        { 
	            $msj->to($plan['correoParaPlanTrabajoAlerta']);
	            $msj->subject($plan['correoAsuntoPlanTrabajoAlerta']);
	            $msj->bcc($plan['correoCopiaOcultaPlanTrabajoAlerta']);    
	            $msj->attach(public_path().'/plantrabajo.html');
	        }); 
	    }
	    else if($plan['correoCopiaPlanTrabajoAlerta'] !== '')
	    {
	        Mail::send('emails.contact',$plan,function($msj) use ($plan)
	        { 
	            $msj->to($plan['correoParaPlanTrabajoAlerta']);
	            $msj->subject($plan['correoAsuntoPlanTrabajoAlerta']);
	            $msj->cc($plan['correoCopiaPlanTrabajoAlerta']);    
	            $msj->attach(public_path().'/plantrabajo.html');
	        }); 
	    }
	    else
	    {
	        Mail::send('emails.contact',$plan,function($msj) use ($plan)
	        {
	            $msj->to($plan['correoParaPlanTrabajoAlerta']);
	            $msj->subject($plan['correoAsuntoPlanTrabajoAlerta']);
	            $msj->attach(public_path().'/plantrabajo.html');
	        }); 
	    }
    }
}

#REALIZO TODAS LAS CONSULTAS QUE VAN AL PLAN DE TRABAJO HABITUAL

function nombreMes($fecha)
{
    $mes = (int) date("m", strtotime($fecha));
    $meses = array('', 'Enero','Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    return $meses[$mes];
}

function buscarTerceroExamen($idTercero, $idExamen, $datos)
{
    $pos = -1;

    for ($i=0; $i < count($datos); $i++) 
    { 

        if ($datos[$i]['idTercero'] == $idTercero && $datos[$i]['idTipoExamenMedico'] == $idExamen) 
        {
            $pos = $i;
            $i = count($datos);
        }
    }

    return $pos;
}

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
       $logo =  '<img src="data:image/png;base64,' . $base64 .'" alt="Texto alternativo" width="30"/>';
    }
    return $logo;
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
        left join
        compania c ON Aus.Compania_idCompania = c.idCompania
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
        left join compania c 
        on PA.Compania_idCompania = c.idCompania
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
        left join compania c
        on PC.Compania_idCompania = c.idCompania
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
        left join compania c 
        on agp.Compania_idCompania = c.idCompania
        Where  agp.Compania_idCompania = '.$idCompania .' 
        and fechaEjecucionGrupoApoyoDetalle >= fechaCreacionCompania and fechaEjecucionGrupoApoyoDetalle >= fechaCreacionCompania
        Group by ga.idGrupoApoyo, idActaGrupoApoyoDetalle');

		return imprimirTabla('Acta Reunión - Actividades', $actividadesgrupoapoyo, 'actividadesgrupoapoyo', $filtroEstado, $fechaInicial, $fechaFinal);
}


// -------------------------------------------
//  R E P O R T E     A C P M 
// -------------------------------------------

function consultarACPM($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
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

        return imprimirTabla('Reporte ACPM', $actividadesgrupoapoyo, 'reporteacpm', $filtroEstado, $fechaInicial, $fechaFinal);
}

// -------------------------------------------
//  E X A M E N E S   M E D I C O S
// -------------------------------------------

function consultarExamen($idCompania, $filtroEstado, $fechaInicial, $fechaFinal)
{
	
    $examen = DB::Select(
        '   SELECT valorFrecuenciaMedicion, unidadFrecuenciaMedicion, idTercero, idTipoExamenMedico, concat(nombreCompletoTercero , " (", nombreCargo, ")", " - ", TEC.nombreTipoExamenMedico) as descripcionTarea,   
                fechaIngresoTerceroInformacion, fechaRetiroTerceroInformacion, fechaCreacionCompania,
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
                ( 2017 >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and 2017 <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR 2017 >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and 2017 <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                    fechaRetiroTerceroInformacion = "0000-00-00") AND
                    fechaIngresoTerceroInformacion != "0000-00-00" AND  
                estadoTercero = "ACTIVO" 
                AND T.Compania_idCompania = '.$idCompania .' 
            order by nombreCompletoTercero, idTercero
       ');

    $datos = array();
      
    for($i= 0; $i < count($examen); $i++)
    {
        $registro = get_object_vars($examen[$i]);
        $pos = buscarTerceroExamen($registro["idTercero"], $registro["idTipoExamenMedico"], $datos);

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
        $datos[$pos]['idTipoExamenMedico'] = $registro["idTipoExamenMedico"];
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


    $examen = DB::Select(
        '   SELECT idTercero, idTipoExamenMedico,  fechaCreacionCompania, 
                   EM.fechaExamenMedico
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
                (2017 >= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") and 2017 <= DATE_FORMAT(fechaIngresoTerceroInformacion,"%Y") OR 2017 >= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") and 2017 <= DATE_FORMAT(fechaRetiroTerceroInformacion,"%Y") OR
                    fechaRetiroTerceroInformacion = "0000-00-00") AND
                    fechaIngresoTerceroInformacion != "0000-00-00" AND 
                estadoTercero = "ACTIVO" 
                AND EMD.ExamenMedico_idExamenMedico IS NOT NULL AND
                T.Compania_idCompania = '.$idCompania .' 
            order by nombreCompletoTercero, idTercero
       ');

    
    for($i= 0; $i < count($examen); $i++)
    {
        $registro = get_object_vars($examen[$i]);
        $pos = buscarTerceroExamen($registro["idTercero"], $registro["idTipoExamenMedico"], $datos);

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
                        <a data-toggle="collapse" data-parent="#accordion" href="#examenmedico">Examenes Medicos</a>
                      </h4>
                    </div>';
                    $tabla .= '
                    <div id="examenmedico" class="panel-collapse"> 
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

                                    for ($i=0; $i <count($datos); $i++) 
                                    { 
                                    	$tabla .='<tr align="center">
                                            <th scope="row">'.$datos[$i]["Nombre"].'</th>';
                                       
                                        $inicio = $fechaInicial;
                                        $anioAnt = date("Y", strtotime($inicio));
                                        while($inicio < $fechaFinal)
                                        {
                                            
	                                        $tabla .= 
	                                        '<td >'. colorTarea($datos[$i][date("m", strtotime($inicio)).'T'],$datos[$i][date("m", strtotime($inicio)).'C']).'</td>';
	                                        //Avanzamos al siguiente mes
                                            $inicio = date("Y-m-d", strtotime("+1 MONTH", strtotime($inicio)));
                                        }
                                        $tabla .= '</tr>';
                                    }
                                    $tabla .= '
                                    </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </body>
        </html>';

    return $tabla;
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
        $icono = base64('images/iconosmenu/Amarillo.png');
        $etiqueta = '<label>'.number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',').'%</label>';
    }
    elseif($valorTarea == $valorCumplido and $valorTarea != 0)
    {
        $icono = base64('images/iconosmenu/Verde.png');
    }
    elseif($valorTarea > 0 and $valorCumplido == 0)
    {
        $icono = base64('images/iconosmenu/Rojo.png');
    }

    if($valorTarea != 0 or $valorCumplido != 0)
    {
        $icono =    '<a href="#" data-toggle="tooltip" data-placement="right" title="'.$tool.'">
                           '.$icono.'
                        </a>'.$etiqueta;    
    }
    //$valorTarea .' '. $valorCumplido. 
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

?>