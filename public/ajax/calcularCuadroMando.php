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
function obtenerWhere($idFormula, $tabla, $campoFecha, $fechaInicio, $fechaFin, $idCompania)
{
	// a la condicion de la consulta le debemos adicionar una fecha de corte
	// y el id de la compañia actual
	// para adicionar el id de la compania, primero verificamos si en la tabla existe ese campo
	//echo 'Consulta de tabla '.$tabla.'<br>';
	$consulta = DB::table('information_schema.COLUMNS')
				->select(DB::raw('COLUMN_NAME'))
				->where('TABLE_SCHEMA', '=', ENV('DB_DATABASE','sisoft'))
				->where('TABLE_NAME', '=', $tabla)
				->where('COLUMN_NAME', 'like', '%idCompania%') 
				->get();


	$datowhere = '';
	// si la tabla tiene campo de id de compania, armamos una condicion con el id de compania de la session actual sino la dejamos en blanco
	if(isset($consulta[0]))
		$datowhere = get_object_vars($consulta[0])["COLUMN_NAME"] .' = '. $idCompania. ' AND ';
	else
		$datowhere = '';
	
	// Si el usuario asocio una fecha de corte, la aplicamos en la condicion
	$datowhere .= ($campoFecha != null and $campoFecha != '')
		? '('. $campoFecha . ' >= "'. $fechaInicio . '" and '.
		$campoFecha . ' <= "'. $fechaFin . '") AND '
		: '';

	$condicion = DB::table('cuadromandocondicion')
				->select(DB::raw('parentesisInicioCuadroMandoCondicion, campoCuadroMandoCondicion, operadorCuadroMandoCondicion, valorCuadroMandoCondicion, parentesisFinCuadroMandoCondicion, conectorCuadroMandoCondicion'))
				->where ('CuadroMandoFormula_idCuadroMandoFormula', "=", $idFormula)
				->get();

	
	foreach ($condicion as $cond => $where) 
	{
		// cada valor es un nuevo array de tipo StdClass, el cual debemos convertir en array php
		$datosCondicion = get_object_vars($where); 
		$like = ($datosCondicion["operadorCuadroMandoCondicion"] == 'like' ? '%': '');
		$tipoString = substr($datosCondicion["valorCuadroMandoCondicion"],0,1) == '('
						? ''
						: '"';
		// concatenamos caa campo separado por coma
		$datowhere .= $datosCondicion["parentesisInicioCuadroMandoCondicion"].' '.
						$datosCondicion["campoCuadroMandoCondicion"].' '.
						$datosCondicion["operadorCuadroMandoCondicion"].' '.
						$tipoString.$like.$datosCondicion["valorCuadroMandoCondicion"].$like.$tipoString.' '.
						$datosCondicion["parentesisFinCuadroMandoCondicion"].' '.
						$datosCondicion["conectorCuadroMandoCondicion"].' ';

						
	}
	// quitamos el conector logico (AND , OR) final si existe
	$datowhere = substr($datowhere, 0, strlen($datowhere)-4);
	return $datowhere;
}

function calcularFormula($idCuadroMando, $fechaInicio, $fechaFin, $idCompania)
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
					campoCuadroMandoFormula, calculoCuadroMandoFormula,
					fechaCorteCuadroMandoFormula'))
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
				$formula .= $datosFormula["nombreCuadroMandoFormula"];
				break;

			case 'Constante':
				// si es un valor constante, simplemente lo concatenamos con espacio a los lados
				$formula .= $datosFormula["nombreCuadroMandoFormula"];
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
				//print_r($datosFormula);
				$datowhere = obtenerWhere($datosFormula["idCuadroMandoFormula"], $datosFormula["tablaModulo"], $datosFormula["fechaCorteCuadroMandoFormula"], $fechaInicio, $fechaFin, $idCompania);

				// creamos una sentencia de SQL con los componentes mencionados
				$sql = 'SELECT '.str_replace('valor', $datosFormula["campoCuadroMandoFormula"], $funcion).
						' FROM '.$datosFormula["tablaModulo"].
						($datowhere != '' ? ' WHERE '.$datowhere : '').
						($groupby != '' ? ' GROUP BY '.$groupby : '');

//						' WHERE '.$datosFormula["fechaCorteCuadroMandoFormula"].' = '

				// ejecutamos la consulta con QueryBuilder
				$resultado = DB::select($sql);
				
				// convertimos el objeto stdClass en array para acceder a sus datos
				$datosresultado = get_object_vars($resultado[0]); 
				//echo $sql .'<br>';
				
				echo '<br>';
				echo 'valor = '.$datosresultado[$datosFormula["campoCuadroMandoFormula"]].'<br>';
				// concatenamos a la formula el valor calculado para la variable
				if($datosresultado[$datosFormula["campoCuadroMandoFormula"]] == null)
					$formula .= 0;
				else
					$formula .= $datosresultado[$datosFormula["campoCuadroMandoFormula"]];

				break;

			case 'Indicador':
				// 4. Cuando la formula contiene un INDICADOR implicito, debemos llamar esta misma funcion recursivamente 
				// pero con el ID del indicador a calcular
				$valorIndicador = calcularFormula($datosFormula["CuadroMando_idIndicador"], $fechaInicio, $fechaFin, $idCompania);

				// concatenamos a la formula el valor calculado para el indicador
				$formula .= $valorIndicador;
				
				break;

			default:
				
				break;
		}
		
	}
	
	//eval('$resultado = "'.$formula.'";');
	try {
		$resultado = eval('return '.$formula.';');
	} catch (Exception $e) {
		echo 'error de division por cero <br>';
		$resultado = 0;
	}
	

	echo 'Resultado Indicador con ID '.$idCuadroMando.'<br>'.$formula.' = '. $resultado.'<br>';
	return  $resultado;
}


function calcularIndicadores($fecha, $idCompania)
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
	$semanaFin = date ( 'Y-m-d' , strtotime ( "+ $dias day" , $fecha) );
	$semanaIni = date ( 'Y-m-d' , strtotime ( "- 6 day" , strtotime($semanaFin)) );

	// consultamos la fecha de la proxima Quincena
	// por lo tanto asumimos que sera los dias 15 o el ultimo dia del mes
	// miramos cual es el mas cerca y tomamos ese
	// verificamos si la fecha actual es menor a 15, entonces tomamos 15, sino buscamos ultimo dia del mes
	$quincenaFin = date('Y-m',$fecha) . '-' . (date('d',$fecha) <= 15 ? '15' : date("t",strtotime(date("Y-m",$fecha))));
	$quincenaIni = date('Y-m',strtotime($quincenaFin)) . '-' . (date('d',strtotime($quincenaFin)) <= 15 ? '01' : date("t",strtotime(date("Y-m",strtotime($quincenaFin)))));


	// Consultamos la fecha del ultimo dia del mes
	$mesFin = date('Y-m',$fecha) . '-' . date("t",strtotime(date("Y-m",$fecha)));
	$mesIni = date('Y-m',strtotime($mesFin)) . '-01';

	// Para el bimestreFin verificamos si el mes actual es PAR, sino entonces le sumamos 1 al mes para obtenerlo
	if(intval(date('m',$fecha))%2 == 0)
	{
		$bimestreFin = date('Y-m',$fecha) . '-' . date("t",strtotime(date("Y-m",$fecha)));
	}
	else
	{
		$proximoMes = date ( 'Y-m' , strtotime ("+ 1 month" , $fecha) );
		$bimestreFin = date('Y-m',$fecha) . '-' . date("t",strtotime($proximoMes));
	}
	$bimestreIni = date('Y-m',strtotime ( "- 2 months" , strtotime($bimestreFin))) . '-01';

	// Para el trimestreFin verificamos si el mes actual es multiplo de 3, sino entonces debemos llegar hasta el multiplo de 3
	if(intval(date('m',$fecha))%3 == 0)
	{
		$trimestreFin = date('Y-m',$fecha) . '-' . date("t",strtotime(date("Y-m",$fecha)));
	}
	else
	{
		$numeroMes = date('m',$fecha);
		while(intval($numeroMes)%3 != 0)
		{
			$numeroMes++;
		}	
		$proximoMes = date ( 'Y-' . $numeroMes,$fecha);
		$trimestreFin = date('Y-',$fecha). str_pad($numeroMes, 2, '0', STR_PAD_LEFT) . '-' . date("t",strtotime($proximoMes));
	}
	$trimestreIni = date('Y-m',strtotime ( "- 3 months" , strtotime($trimestreFin))) . '-01';
	

	// consultamos la fecha del proximo semestreFin
	// por lo tanto asumimos que sera en junio o Diciembre, miramos cual es el mas cerca y tomamos ese
	// verificamos si la fecha actual es menor a JUNIO, entonces tomamos ese, sino Tomamos Diciembre
	$semestreFin = date('Y-',$fecha) . (date('m',$fecha) <= 6 ? str_pad('6', 2, '0', STR_PAD_LEFT). '-30' : str_pad('12', 2, '0', STR_PAD_LEFT). '-31');
	$semestreIni = date('Y-m',strtotime ( "- 6 months" , strtotime($semestreFin))) . '-01';

	// por ultimo la fecha del ultimo dia del año, que siempre sera fija
	$anioFin = date('Y-12-31',$fecha);
	$anioIni = date('Y-01-01',$fecha);

		// echo $dia.'<br>';
		// echo $semanaIni.' - '.$semanaFin.'<br>';
		// echo $quincenaIni.' - '.$quincenaFin.'<br>';
		// echo $mesIni.' - '.$mesFin.'<br>';
		// echo $bimestreIni.' - '.$bimestreFin.'<br>';
		// echo $trimestreIni.' - '.$trimestreFin.'<br>';
		// echo $semestreIni.' - '.$semestreFin.'<br>';
		// echo $anioIni.' - '.$anioFin.'<br>';

	$cuadroMandoObjeto = DB::table('cuadromando as CM')
	    ->leftJoin('frecuenciamedicion as FM', 'CM.FrecuenciaMedicion_idFrecuenciaMedicion', '=', 'FM.idFrecuenciaMedicion')
	    ->select(DB::raw('idCuadroMando, indicadorCuadroMando, formulaCuadroMando, valorFrecuenciaMedicion, unidadFrecuenciaMedicion, operadorMetaCuadroMando, valorMetaCuadroMando, tipoMetaCuadroMando, Proceso_idProceso'))
	    ->orderby('idCuadroMando')
	    ->get();
	 //print_r($cuadroMandoObjeto);
/*->where('CM.Compania_idCompania','=', $idCompania)
	    ->orWhereNull('CM.Compania_idCompania')*/

	// por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
	$CuadroMando = array();
	foreach ($cuadroMandoObjeto as $key => $value) 
	{
	    $CuadroMando[] = (array) $value;
	}

	// recorremos cada indicador para calcularlo y almacenar su resultado en la tabla de indicadores
	for ($i=0; $i < count($CuadroMando); $i++) 
	{ 
		echo 'Calculo de ID '.$CuadroMando[$i]["idCuadroMando"].'<br>';
		

		// verificamos la periodicidad del indicador para tomar la fecha de corte
		// este dato depende del valor y la unidad de frecuencia
		switch ($CuadroMando[$i]["unidadFrecuenciaMedicion"]) 
		{
			case 'Dias':
				$fechaIni = $dia;
				$fechaCorte = $dia;
				break;

			case 'Semanas':
				switch ($CuadroMando[$i]["valorFrecuenciaMedicion"]) 
				{
					case 1:
						$fechaIni = $semanaIni;
						$fechaCorte = $semanaFin;
						break;
					case 2:
						$fechaIni = $quincenaIni;
						$fechaCorte = $quincenaFin;
						break;
					
					default:
						$fechaIni = $semanaIni;
						$fechaCorte = $semanaFin;
						break;
				}
				break;
			case 'Meses':
				switch ($CuadroMando[$i]["valorFrecuenciaMedicion"]) 
				{
					case 1:
						$fechaIni = $mesIni;
						$fechaCorte = $mesFin;
						break;
					case 2:
						$fechaIni = $bimestreIni;
						$fechaCorte = $bimestreFin;
						break;
					case 3:
						$fechaIni = $trimestreIni;
						$fechaCorte = $trimestreFin;
						break;
					case 6:
						$fechaIni = $semestreIni;
						$fechaCorte = $semestreFin;
						break;
					
					default:
						$fechaIni = $mesIni;
						$fechaCorte = $mesFin;
						break;
				}
				break;
			case 'Años':
				$fechaIni = $anioIni;
				$fechaCorte = $anioFin;
				break;
			
			default:
				$fechaIni = $dia;
				$fechaCorte = $dia;
				break;
		}
		$resultado = calcularFormula($CuadroMando[$i]["idCuadroMando"], $fechaIni, $fechaCorte, $idCompania);
		// Evaluamos si el resultado cumple con la meta del indicador siempre y cuando ya sea la fecha de su corte
		// si no cumple con la meta, insertamos un registro en el ACPM (Accion Correctiva)
		// Armamos una comparacion concatenada para luego ejecutarla con el evalecho 

		$resultado = (($resultado === null or $resultado == '') ? 0 : $resultado);
		$resp = '';

		// eval('$resp = ('. $resultado .' '. $CuadroMando[$i]["operadorMetaCuadroMando"].' '.$CuadroMando[$i]["valorMetaCuadroMando"].' ? "Si" : "No");');
		
		// if($resp == 'No' )
		// {
		// 	$reporteACPM = DB::select("Select MAX(idReporteACPM) as idReporteACPM
		//       From reporteacpm 
		//       where Compania_idCompania = ".  $idCompania);

		//     $reporte = get_object_vars($reporteACPM[0])["idReporteACPM"];

		//     if ($reporte == "") 
		//     {
		//     	DB::statement('INSERT into reporteacpm (idReporteACPM, numeroReporteACPM, fechaElaboracionReporteACPM, descripcionReporteACPM, Compania_idCompania) values (0, 1, "0000-00-00", "Acciones correctivas, preventivas y de mejora", '. $idCompania.')');

		//         $reporteACPM = DB::select("Select MAX(idReporteACPM) as idReporteACPM
		//           From reporteacpm 
		//           where Compania_idCompania = ".  $idCompania);

		//         $reporte = get_object_vars($reporteACPM[0])["idReporteACPM"];
	 //        }

  //           \App\ReporteACPMDetalle::create([

  //               'ReporteACPM_idReporteACPM' => $reporte,
  //               'ordenReporteACPMDetalle' => 0,
  //               'fechaReporteACPMDetalle' => date("Y-m-d"),
  //               'Proceso_idProceso' => $CuadroMando[$i]['Proceso_idProceso'],
  //               'Modulo_idModulo' => 1,
  //               'tipoReporteACPMDetalle' => 'Correctiva',
  //               'descripcionReporteACPMDetalle' => 'El indicador '.$CuadroMando[$i]['indicadorCuadroMando'].' no cumple la meta (Valor '.$resultado.' Meta '. $CuadroMando[$i]["operadorMetaCuadroMando"].' '.$CuadroMando[$i]["valorMetaCuadroMando"].' '.$CuadroMando[$i]["tipoMetaCuadroMando"].')',
  //               'analisisReporteACPMDetalle' => '',
  //               'correccionReporteACPMDetalle' => '',
  //               'Tercero_idResponsableCorrecion' => NULL,
  //               'planAccionReporteACPMDetalle' => '',
  //               'Tercero_idResponsablePlanAccion' => NULL,
  //               'fechaEstimadaCierreReporteACPMDetalle' => '0000-00-00',
  //               'estadoActualReporteACPMDetalle' => '',
  //               'fechaCierreReporteACPMDetalle' => '0000-00-00',
  //               'eficazReporteACPMDetalle' => 0

  //           ]);
		// }


		// verificamos si el resultado hay que insertarlo o actualizarlo en la tabla de indicadores
		// esto depende de su periodicidad, por lo tanto la verificamos y tomamos la fecha del corte
		// siya existe en la tabla el idCuadroMando con la fecha de corte, y esta es igual tambien a 
		// la fecha de calculao, entonces debemos Insertar uno nuevo, sino actulaizamos el existente
	    $indice = array(
	    	'CuadroMando_idCuadroMando' => $CuadroMando[$i]["idCuadroMando"],
	     	'fechaCorteIndicador' => $fechaCorte,
	     	'Compania_idCompania' => $idCompania);

		$data = array(
			'fechaCalculoIndicador' => date("Y-m-d", $fecha),
			'valorIndicador' => $resultado);
		
	    $indicador = \App\Indicador::updateOrCreate($indice, $data);

	}


	return;
}

set_time_limit(0);
// echo $_GET["fecha"].'<br>';
// tomamos una fecha inicial para el proceso, que viene como parametro en la variable fecha
// si no existe, tomamos el dia de hoy

$CondCompania = isset($_GET["idCompania"]) ? ' where idCompania = '.$_GET["idCompania"] : '';

$compania = DB::Select('SELECT idCompania, nombreCompania from compania '.$CondCompania);
for ($i=0; $i < count($compania); $i++) 
{ 
	$idCompania = get_object_vars($compania[$i]);
	echo 'INDICADORES PARA : '.$idCompania["nombreCompania"].'<br>';
	
	$fechaIni = isset($_GET["fechaIni"]) ? $_GET["fechaIni"] : date("Y-m-d");
	$fechaFin = isset($_GET["fechaFin"]) ? $_GET["fechaFin"] : date("Y-m-d");
	while($fechaIni <= $fechaFin)
	{
		calcularIndicadores($fechaIni, $idCompania["idCompania"]);
		$fechaIni = date ( 'Y-m-d' , strtotime ( "+ 1 day" , strtotime($fechaIni)) );
		 echo $fechaIni.'<br>';
	}
}

echo 'Fin del proceso de recalculo de indicadores';

?>