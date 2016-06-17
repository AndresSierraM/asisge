<?php

// Con el campo de calculo, hacemos un Case, ya que segun su valor lo cambiamos 
// por una funcion de agregacion Mysql	(MIN, MAX, SUM, AVG o COUNT)

// en cada string ponemos la palabra "valor" para despues cambiarla por el 
// nombre del campo y asi nos queda la sintaxis correcta para el SQL
function obtenerFuncion($calculo)
{
	$funcion = 'valor';
	switch ($calculo) {
		case 'Suma':
			$funcion = 'SUM(valor) as valor';
			break;
		case 'Conteo':
			$funcion = 'COUNT(valor) as valor';
			break;
		case 'Promedio':
			$funcion = 'AVG(valor) as valor';
			break;
		case 'Minimo':
			$funcion = 'MIN(valor) as valor';
			break;
		case 'Maximo':
			$funcion = 'MAX(valor) as valor';
			break;
		
		default:
			$funcion = 'valor';
			break;
	}
	return $funcion;
}


// Consultamos la tabla de agrupacion y la recorremos concatenando los campos 
// para la clausula GROUP BY
function obtenerGroupBy($idFormula)
{
	$agrupador = DB::table('cuadromandoagrupador')
	->select(DB::raw('campoCuadroMandoAgrupador'))
	->where ('CuadroMandoFormula_idCuadroMandoFormula', "=", $idFormula)
	->get();

	$groupby = '';
	foreach ($agrupador as $agr => $grupo) 
	{
		// cada valor es un nuevo array de tipo StdClass, el cual debemos convertir en array php
		$datosAgrupador = get_object_vars($grupo); 
		// concatenamos caa campo separado por coma
		$groupby .= $datosAgrupador["campoCuadroMandoAgrupador"].', ';
	}
	// quitamos la coma (,) final si existe
	$groupby = substr($groupby, 0, strlen($groupby)-2);
	return $groupby;
}


// Consultamos la tabla de condicion y la recorremos concatenando los campos 
// para la clausula WHERE
function obtenerWhere($idFormula)
{
	$condicion = DB::table('cuadromandocondicion')
	->select(DB::raw('parentesisInicioCuadroMandoCondicion, campoCuadroMandoCondicion,
						operadorCuadroMandoCondicion, valorCuadroMandoCondicion, 
						parentesisFinCuadroMandoCondicion, conectorCuadroMandoCondicion'))
	->where ('CuadroMandoFormula_idCuadroMandoFormula', "=", $idFormula)
	->get();

	$datowhere = '';
	foreach ($condicion as $cond => $where) 
	{
		// cada valor es un nuevo array de tipo StdClass, el cual debemos convertir en array php
		$datosCondicion = get_object_vars($where); 
		$like = ($datosCondicion["operadorCuadroMandoCondicion"] == 'like' ? '%': '');

		// concatenamos caa campo separado por coma
		$datowhere .= $datosCondicion["parentesisInicioCuadroMandoCondicion"].' '.
						$datosCondicion["campoCuadroMandoCondicion"].' '.
						$datosCondicion["operadorCuadroMandoCondicion"].' '.
						'"'.$like.$datosCondicion["valorCuadroMandoCondicion"].$like.'" '.
						$datosCondicion["parentesisFinCuadroMandoCondicion"].' '.
						$datosCondicion["conectorCuadroMandoCondicion"].' ';

						
	}
	// quitamos el conector logico (AND , OR) final si existe
	$datowhere = substr($datowhere, 0, strlen($datowhere)-4);echo $datowhere;
	return $datowhere;
}

function calcularFormula($idCuadroMando)
{
	//********************************************************
	// Proceso de Calculo de las formulas del cuadro de mando
	//********************************************************

	/*
	1. Consultamos los componentes de la formula desde la tabla CuadromandoFormula*/

	$indicador = DB::table('cuadromandoformula')
	->leftjoin('modulo', 'cuadromandoformula.Modulo_idModulo', "=", 'modulo.idModulo')
	->select(DB::raw('idCuadroMandoFormula, tipoCuadroMandoFormula, 
					CuadroMando_idIndicador, nombreCuadroMandoFormula, 
					Modulo_idModulo, nombreModulo, tablaModulo, 
					campoCuadroMandoFormula, calculoCuadroMandoFormula'))
	->where ('CuadroMando_idCuadroMando', "=", $idCuadroMando)
	->get();


	/*
	2. Recorremos Cada uno de los componentes de la formula, teniendo en cuenta que 
	cada uno tiene un tipo que diferencia su forma de Operación asi:

	--------------------------------------------------------------------------------------------------------
	Tipo 		Descripción														Proceso
	--------------------------------------------------------------------------------------------------------
	Operador	Indica que es un operador matemático como +, -, *, /, (, )		No se realiza ningun proceso
	--------------------------------------------------------------------------------------------------------
	Indicador	Indica que la formula esta conformada por un indicador 			Llamar la funcion de calculo
				previamente creado en el cuadro de Mando						recursivamente con el ID 
																				del indicador a calcular
	--------------------------------------------------------------------------------------------------------
	Constante	Indica que es un valor numerico dgitado manualmente				No se realiza ningun proceso
	--------------------------------------------------------------------------------------------------------
	Variable	Indica que el componente de la formula debe calcularse para		Con datos adicionales como 
				obtener su valor												el modulo, el campo, la operacion
																				a realizar, el agrupador y la 
																				condicion, debe ejecutar una
																				consulta a la BD para obtener un
																				valor resultante
	--------------------------------------------------------------------------------------------------------*/

	// en la variable $formula vamos a concatenar toda la formula pero con sus valores finales
	$formula = '';
	$resultado = '';
	// recorremos el array de la consulta de Formula
	foreach ($indicador as $pos => $valor) 
	{
		// cada valor es un nuevo array de tipo StdClass, el cual debemos convertir en array php
		$datosFormula = get_object_vars($valor); 
		

		// hacemos una estructura CASE con la variable de tipo para saber el 
		// proceso a seguir con cada componente
		switch ($datosFormula["tipoCuadroMandoFormula"]) 
		{
			case 'Operador':
				// si es un operador matemático, simplemente lo concatenamos con espacio a los lados
				$formula .= " ".$datosFormula["nombreCuadroMandoFormula"]." ";
				break;

			case 'Constante':
				// si es un valor constante, simplemente lo concatenamos con espacio a los lados
				$formula .= " ".$datosFormula["nombreCuadroMandoFormula"]." ";
				break;

			case 'Variable':
				/*
				3. nos concentramos en el componente de tipo VARIABLE, asi:

				--------------------------------------------------------------------------------------------------------
				Dato 						Tratamiento
				--------------------------------------------------------------------------------------------------------
				Modulo 						Nombre de la tabla para el FROM (SQL)
				Campo 						Nombre del Campo a consultar en el SELECT (SQL)
				Calculo						Funcion de agregación de MYSQL para el campo (MIN, MAX, SUM, AVG o COUNT)
				Agrupador 					Nombres de campos para la Clausula GROUP BY de la consulta
				Condicion 					Nombres de campos para la Clausula WHERE de la consulta*/

				$sql = '';

				// 3.1. CALCULO (Funcion de agregacion)
				$funcion = obtenerFuncion($datosFormula["calculoCuadroMandoFormula"]);

				// 3.2. AGRUPADOR (group by)
				$groupby = obtenerGroupBy($datosFormula["idCuadroMandoFormula"]);

				// 3.3. CONDICION (Where)
				$datowhere = obtenerWhere($datosFormula["idCuadroMandoFormula"]);

				// creamos una sentencia de SQL con los componentes mencionados
				$sql = 'SELECT '.str_replace('valor', $datosFormula["campoCuadroMandoFormula"], $funcion).
						' FROM '.$datosFormula["tablaModulo"].
						($datowhere != '' ? ' WHERE '.$datowhere : '').
						($groupby != '' ? ' GROUP BY '.$groupby : '');

				// ejecutamos la consulta con QueryBuilder
				$resultado = DB::select($sql);
				
				// convertimos el objeto stdClass en array para acceder a sus datos
				$datosresultado = get_object_vars($resultado[0]); 

				// concatenamos a la formula el valor calculado para la variable
				$formula .= " ".$datosresultado[$datosFormula["campoCuadroMandoFormula"]]." ";
				break;

			case 'Indicador':
				// 4. Cuando la formula contiene un INDICADOR implicito, debemos llamar esta misma funcion recursivamente 
				// pero con el ID del indicador a calcular
				$valorIndicador = calcularFormula($datosFormula["CuadroMando_idIndicador"]);

				// concatenamos a la formula el valor calculado para el indicador
				$formula .= " ".$valorIndicador." ";
				
				break;

			default:
				
				break;
		}
		
	}

	eval('$resultado = '.$formula.';');

	// echo 'Resultado Indicador con ID '.$idCuadroMando.'<br>'.$formula.' = '. $resultado.'<br>';
	return  $resultado;
}


function calcularIndicadores($fecha)
{
	//-----------------------------------------------------
	//	CALCULO DE INDICADORES DEL CUADRO DE MANDO
	// los indicadores se deben calcular según la formula 
	// creada en el cuadro de mando, adicionalmente, los vamos a 
	// calcular con este proceso diariamente, lo que quiere
	// decir que se insertarán en la tabla con el valor acumulado 
	// hasta la fecha y solo se insertara un nuevo valor despues
	// de que haya pasado su fecha de corte
	//-----------------------------------------------------

	// FRECUENCIA DE MEDICION
	// cada indicador tiene asociada una frecuencia, a pesar
	// de que se calcula cada dia, vamos a tener en cuanta la frecuencia
	// para saber hasta que dia calculamos el indicador con el acumulado
	// y apenas llegue a su corte, el siguiente dia creara un nuevo registro 
	// para empezar a acumular de nuevo

	// TIPOS DE FRECUENCIAS
	// Semanal. Cortar los dias domingo
	// Quincenal. Corta cada 2 Domingos
	// Mensual. corta el ultimo dia del mes
	// los demas cortan cada X meses el ultimo dia del mes
	$fecha = strtotime($fecha);
	// guardamos la fecha de hoy para los indicadores Diarios
	$dia = date("Y-m-d", $fecha);

	// consultamos la fecha del proximo domingo
	//la semana tiene 7 dias, si tomamos 7 - dia actual tendremos los dias que faltan para domingo
	// luego sumamos a la fecha de hoy esos dias 
	$dias = 7 - date("w", $fecha);
	$semana = date ( 'Y-m-d' , strtotime ( "+ $dias day" , $fecha) );

	// consultamos la fecha de la proxima Quincena
	// por lo tanto asumimos que sera los dias 15 o el ultimo dia del mes
	// miramos cual es el mas cerca y tomamos ese
	// verificamos si la fecha actual es menor a 15, entonces tomamos 15, sino buscamos ultimo dia del mes
	$quincena = date('Y-m',$fecha) . '-' . (date('d',$fecha) <= 15 ? '15' : date("t",strtotime(date("Y-m",$fecha))));

	// Consultamos la fecha del ultimo dia del mes
	$mes = date('Y-m',$fecha) . '-' . date("t",strtotime(date("Y-m",$fecha)));

	// Para el bimestre verificamos si el mes actual es PAR, sino entonces le sumamos 1 al mes para obtenerlo
	if(intval(date('m',$fecha))%2 == 0)
	{
		$bimestre = date('Y-m',$fecha) . '-' . date("t",strtotime(date("Y-m",$fecha)));
	}
	else
	{
		$proximoMes = date ( 'Y-m' , strtotime ("+ 1 month" , $fecha) );
		$bimestre = date('Y-m',$fecha) . '-' . date("t",strtotime($proximoMes));
	}

	// Para el Trimestre verificamos si el mes actual es multiplo de 3, sino entonces debemos llegar hasta el multiplo de 3
	if(intval(date('m',$fecha))%3 == 0)
	{
		$trimestre = date('Y-m',$fecha) . '-' . date("t",strtotime(date("Y-m",$fecha)));
	}
	else
	{
		$numeroMes = date('m',$fecha);
		while(intval($numeroMes)%3 != 0)
		{
			$numeroMes++;
		}	
		$proximoMes = date ( 'Y-' . $numeroMes,$fecha);
		$trimestre = date('Y-',$fecha). str_pad($numeroMes, 2, '0', STR_PAD_LEFT) . '-' . date("t",strtotime($proximoMes));
	}

	// consultamos la fecha del proximo semestre
	// por lo tanto asumimos que sera en junio o Diciembre, miramos cual es el mas cerca y tomamos ese
	// verificamos si la fecha actual es menor a JUNIO, entonces tomamos ese, sino Tomamos Diciembre
	$semestre = date('Y-',$fecha) . (date('m',$fecha) <= 6 ? str_pad('6', 2, '0', STR_PAD_LEFT). '-30' : str_pad('12', 2, '0', STR_PAD_LEFT). '-31');


	// por ultimo la fecha del ultimo dia del año, que siempre sera fija
	$anio = date('Y-12-31',$fecha);

		// echo $dia.'<br>';
		// echo $semana.'<br>';
		// echo $quincena.'<br>';
		// echo $mes.'<br>';
		// echo $bimestre.'<br>';
		// echo $trimestre.'<br>';
		// echo $semestre.'<br>';
		// echo $anio.'<br>';

	$cuadroMandoObjeto = DB::table('cuadromando as CM')
	    ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
	    ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, valorFrecuenciaMedicion, unidadFrecuenciaMedicion, operadorMetaCuadroMando, valorMetaCuadroMando, tipoMetaCuadroMando, Proceso_idProceso'))
	    ->where('CM.Compania_idCompania','=', \Session::get('idCompania'))
	    ->get();
	// print_r($cuadroMandoObjeto);

	// por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
	foreach ($cuadroMandoObjeto as $key => $value) 
	{
	    $CuadroMando[] = (array) $value;
	}

	// recorremos cada indicador para calcularlo y almacenar su resultado en la tabla de indicadores
	for ($i=0; $i < count($CuadroMando); $i++) 
	{ 
		//echo $CuadroMando[$i]["unidadFrecuenciaMedicion"].'<br>';
		$resultado = calcularFormula($CuadroMando[$i]["idCuadroMando"]);

		// verificamos la periodicidad del indicador para tomar la fecha de corte
		// este dato depende del valor y la unidad de frecuencia
		switch ($CuadroMando[$i]["unidadFrecuenciaMedicion"]) 
		{
			case 'Dias':
				$fechaCorte = $dia;
				break;

			case 'Semanas':
				switch ($CuadroMando[$i]["valorFrecuenciaMedicion"]) 
				{
					case 1:
						$fechaCorte = $semana;
						break;
					case 2:
						$fechaCorte = $quincena;
						break;
					
					default:
						$fechaCorte = $semana;
						break;
				}
				break;
			case 'Meses':
				switch ($CuadroMando[$i]["valorFrecuenciaMedicion"]) 
				{
					case 1:
						$fechaCorte = $mes;
						break;
					case 2:
						$fechaCorte = $bimestre;
						break;
					case 3:
						$fechaCorte = $trimestre;
						break;
					case 6:
						$fechaCorte = $semestre;
						break;
					
					default:
						$fechaCorte = $mes;
						break;
				}
				break;
			case 'Años':
				$fechaCorte = $anio;
				break;
			
			default:
				$fechaCorte = $dia;
				break;
		}

		// Evaluamos si el resultado cumple con la meta del indicador siempre y cuando ya sea la fecha de su corte
		// si no cumple con la meta, insertamos un registro en el ACPM (Accion Correctiva)
		// Armamos una comparacion concatenada para luego ejecutarla con el eval
		$resp = '';
		eval('$resp = ('. $resultado .' '. $CuadroMando[$i]["operadorMetaCuadroMando"].' '.$CuadroMando[$i]["valorMetaCuadroMando"].' ? "Si" : "No");');
		// echo $resp;

		if($resp == 'No' )
		{
	            $reporteACPM = \App\ReporteACPM::All()->last();
	            \App\ReporteACPMDetalle::create([

	                'ReporteACPM_idReporteACPM' => $reporteACPM->idReporteACPM,
	                'ordenReporteACPMDetalle' => 0,
	                'fechaReporteACPMDetalle' => date("Y-m-d"),
	                'Proceso_idProceso' => $CuadroMando[$i]['Proceso_idProceso'],
	                'Modulo_idModulo' => 1,
	                'tipoReporteACPMDetalle' => 'Correctiva',
	                'descripcionReporteACPMDetalle' => 'El indicador '.$CuadroMando[$i]['indicadorCuadroMando'].' no cumple la meta (Valor '.$resultado.' Meta '. $CuadroMando[$i]["operadorMetaCuadroMando"].' '.$CuadroMando[$i]["valorMetaCuadroMando"].' '.$CuadroMando[$i]["tipoMetaCuadroMando"].')',
	                'analisisReporteACPMDetalle' => '',
	                'correccionReporteACPMDetalle' => '',
	                'Tercero_idResponsableCorrecion' => NULL,
	                'planAccionReporteACPMDetalle' => '',
	                'Tercero_idResponsablePlanAccion' => NULL,
	                'fechaEstimadaCierreReporteACPMDetalle' => '0000-00-00',
	                'estadoActualReporteACPMDetalle' => '',
	                'fechaCierreReporteACPMDetalle' => '0000-00-00',
	                'eficazReporteACPMDetalle' => 0

	            ]);
		}

		// verificamos si el resultado hay que insertarlo o actualizarlo en la tabla de indicadores
		// esto depende de su periodicidad, por lo tanto la verificamos y tomamos la fecha del corte
		// siya existe en la tabla el idCuadroMando con la fecha de corte, y esta es igual tambien a 
		// la fecha de calculao, entonces debemos Insertar uno nuevo, sino actulaizamos el existente
	    $indice = array(
	    	'CuadroMando_idCuadroMando' => $CuadroMando[$i]["idCuadroMando"],
	     	'fechaCorteIndicador' => $fechaCorte);

		$data = array(
			'fechaCalculoIndicador' => date("Y-m-d", $fecha),
			'valorIndicador' => $resultado);
		print_r($indice);
		print_r($data);
	    $indicador = \App\Indicador::updateOrCreate($indice, $data);

	}


	return;
}

// echo $_GET["fecha"].'<br>';
// tomamos una fecha inicial para el proceso, que viene como paremetro en la variable fecha
// si no existe, tomamos el dia de hoy
$fecha = isset($_GET["fecha"]) ? $_GET["fecha"] : date("Y-m-d");

while($fecha <= date("Y-m-d"))
{
	calcularIndicadores($fecha);
	$fecha = date ( 'Y-m-d' , strtotime ( "+ 1 day" , strtotime($fecha)) );
	// echo $fecha.'<br>';
}
echo 'Fin del proceso de recalculo de indicadores';

?>