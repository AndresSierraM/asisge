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
		// concatenamos caa campo separado por coma
		$datowhere .= $datosCondicion["parentesisInicioCuadroMandoCondicion"].' '.
						$datosCondicion["campoCuadroMandoCondicion"].' '.
						$datosCondicion["operadorCuadroMandoCondicion"].' '.
						'"'.$datosCondicion["valorCuadroMandoCondicion"].'" '.
						$datosCondicion["parentesisFinCuadroMandoCondicion"].' '.
						$datosCondicion["conectorCuadroMandoCondicion"].' ';
	}
	// quitamos el conector logico (AND , OR) final si existe
	$datowhere = substr($datowhere, 0, strlen($datowhere)-4);
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

	echo 'Resultado Indicador con ID '.$idCuadroMando.'<br>'.$formula.' = '. $resultado.'<br>';
	return  $resultado;
}


calcularFormula(3);
?>