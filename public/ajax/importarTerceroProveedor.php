<?php

Excel::load('importacion/Plantilla Terceros.xlsx', function($reader) {

	// // llemos todo el archivo
	// $datos = $reader->get();

	// // Tiulo de la Hoja
	// $workbookTitle = $datos->getTitle();
	// echo 'A'.$workbookTitle;

	$datos = $reader->getActiveSheet();
   	
   	 // echo $datos->getCell('C5')->getValue();

   	$terceros = array();
   	$errores = array();
   	$fila = 5;
   	$posTer = 0;
   	$posErr = 0;
   	
   	while ($datos->getCellByColumnAndRow(0, $fila)->getValue() != '' and
    		$datos->getCellByColumnAndRow(0, $fila)->getValue() != NULL) {
        

        // para cada registro de terceros recorremos las columnas desde la 0 hasta la 22
        $terceros[$posTer]["idTercero"] = 0;
    	$terceros[$posTer]["Compania_idCompania"] = 0;
        for ($columna = 0; $columna <= 22; $columna++) {
            // en la fila 4 del archivo de excel (oculta) estan los nombres de los campos de la tabla
            $campo = $datos->getCellByColumnAndRow($columna, 4)->getValue();

            // si es una celda calculada, la ejeutamos, sino tomamos su valor
            if ($datos->getCellByColumnAndRow($columna, $fila)->getDataType() == 'f')
                $terceros[$posTer][$campo] = $datos->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
            else
                $terceros[$posTer][$campo] = $datos->getCellByColumnAndRow($columna, $fila)->getValue();

        }

        // tomamos el tipo de identificacion que el usuario llena como codigo para convertirlo en id buscandolo en el modelo
        
        //*****************************
        // Tipo de identificacion
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"] == '' or 
        	$terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el Tipo de identificacion';
			
			$posErr++;
        }
        else
        {
	        $consulta = \App\TipoIdentificacion::where('codigoTipoIdentificacion','=', $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"])->lists('idTipoIdentificacion');

	        // si se encuentra el id lo guardamos en el array
	        if(isset($consulta[0]))
				$terceros[$posTer]["TipoIdentificacion_idTipoIdentificacion"] = $consulta[0];
			else
			{
				$errores[$posErr]["linea"] = $fila;
				$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
				$errores[$posErr]["mensaje"] = 'Tipo de identificacion '. $terceros[ $posTer]["TipoIdentificacion_idTipoIdentificacion"]. ' no existe';
				
				$posErr++;
			}
		}

		//*****************************
        // Número de documento
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["documentoTercero"] == '' or 
        	$terceros[ $posTer]["documentoTercero"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el Número de Documento';
			
			$posErr++;
        }
        else
        {
        	//buscamos el id en el modelo correspondiente
	        $consulta = \App\Tercero::where('documentoTercero','=', $terceros[ $posTer]["documentoTercero"])->lists('idTercero','nombreCompletoTercero');
	        // si se encuentra el id lo guardamos en el array

	        if(isset($consulta[0]))
				$terceros[$posTer]["idTercero"] = $consulta[0];
		}

		//*****************************
        // Primer Nombre 
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["nombre1Tercero"] == '' or 
        	$terceros[ $posTer]["nombre1Tercero"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el Primer Nombre';
			
			$posErr++;
        }

        //*****************************
        // Primer Apellido
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["apellido1Tercero"] == '' or 
        	$terceros[ $posTer]["apellido1Tercero"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el Primer Apellido';
			
			$posErr++;
        }


		//*****************************
        // Nombre Completo
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["nombreCompletoTercero"] == '' or 
        	$terceros[ $posTer]["nombreCompletoTercero"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el Nombre completo o Razon Social';
			
			$posErr++;
        }

        //*****************************
        // Fecha de Creación 
        //*****************************
        // si la celda esta en blanco, la llenamos con la fecha actual
        if($terceros[ $posTer]["fechaCreacionTercero"] == '' or 
        	$terceros[ $posTer]["fechaCreacionTercero"] == null)
        {
        	$terceros[$posTer]["fechaCreacionTercero"] = date("Y-m-d");
        }


        //*****************************
        // Estado
        //*****************************
        // si la celda esta en blanco o no tiene una de las palabras válida, la llenamos con activo
        if($terceros[$posTer]["estadoTercero"] == '' or 
        	$terceros[$posTer]["estadoTercero"] == null or 
        	$terceros[$posTer]["estadoTercero"] != 'Activo' or 
        	$terceros[$posTer]["estadoTercero"] != 'Inactivo')
        {
        	$terceros[$posTer]["estadoTercero"] = 'Activo';
			
			$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'El estado '.$terceros[$posTer]["estadoTercero"].' no es válido, se reemplaza automáticamente por Activo';
			
			$posErr++;
        }
	
        //*****************************
        // Ciudad
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["Ciudad_idCiudad"] == '' or 
        	$terceros[ $posTer]["Ciudad_idCiudad"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el código de la ciudad';
			
			$posErr++;
        }
        else
        {
	        $consulta = \App\Ciudad::where('codigoCiudad','=', $terceros[ $posTer]["Ciudad_idCiudad"])->lists('idCiudad');

	        // si se encuentra el id lo guardamos en el array
	        if(isset($consulta[0]))
				$terceros[$posTer]["Ciudad_idCiudad"] = $consulta[0];
			else
			{
				$errores[$posErr]["linea"] = $fila;
				$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
				$errores[$posErr]["mensaje"] = 'Código de Ciudad '. $terceros[ $posTer]["Ciudad_idCiudad"]. ' no existe';
				
				$posErr++;
			}
		}


		//*****************************
        // Cargo
        //*****************************
        // si la celda esta en blanco, reportamos error de obligatoriedad
        if($terceros[ $posTer]["Cargo_idCargo"] == '' or 
        	$terceros[ $posTer]["Cargo_idCargo"] == null)
        {
        	$errores[$posErr]["linea"] = $fila;
			$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
			$errores[$posErr]["mensaje"] = 'Debe diligenciar el código del Cargo';
			
			$posErr++;
        }
        else
        {
	        $consulta = \App\Cargo::where('codigoCargo','=', $terceros[ $posTer]["Cargo_idCargo"])->lists('idCargo');

	        // si se encuentra el id lo guardamos en el array
	        if(isset($consulta[0]))
				$terceros[$posTer]["Cargo_idCargo"] = $consulta[0];
			else
			{
				$errores[$posErr]["linea"] = $fila;
				$errores[$posErr]["nombre"] = $terceros[ $posTer]["nombreCompletoTercero"];
				$errores[$posErr]["mensaje"] = 'Código de Cargo '. $terceros[ $posTer]["Cargo_idCargo"]. ' no existe';
				
				$posErr++;
			}
		}
		
		$posTer++;
        $fila++;
        print_r($errores);
        print_r($terceros);
    }


});


	


// $datos->getCellByColumnAndRow($columna, $fila)->getStyle('A1')->applyFromArray(
// 			    array(
// 			        'fill' => array(
// 			            'type' => PHPExcel_Style_Fill::FILL_SOLID,
// 			            'color' => array('rgb' => 'FF0000')
// 			        )
// 			    )
// 			);

