<?php 
	// Se recibe por parametro todo lo que envia desde antess de guardar en cada Update or Create en el controller MatrizDofaController
     function guardarMatrizRiesgoProceso($idProceso, $idTercero, $descripcionMatrizRiesgo, $fechaMatrizDofa,$idMatrizDofaDetalle)
      {

      		// se hace una consulta, para preguntar los procesos que tiene Matriz Riesgo proceso en la compañia que este logueada 
          $matrizriesgoproceso = DB::select("
             SELECT mrp.idMatrizRiesgoProceso
             FROM matrizriesgoproceso mrp
             LEFT JOIN compania c
             ON mrp.Compania_idCompania = c.idCompania
             WHERE
             mrp.Compania_idCompania = ". \Session::get("idCompania").
             ' AND Proceso_idProceso = '.$idProceso);

          // Se conviete para facilidad de manejo
          // Se utiliza el empty para validar si es un cero,vacio, permita hacer la validacion de vacios o simplemente que devuelva la consulta convertida
          $idMatrizRiesgo = (empty($matrizriesgoproceso) ? '' : get_object_vars($matrizriesgoproceso[0])["idMatrizRiesgoProceso"]);

          // Si el proceso no existe el va a crear el registro completo con encabezado y detalle 
          if ($idMatrizRiesgo == '') 
          {
          		DB::statement('INSERT into matrizriesgoproceso (idMatrizRiesgoProceso, fechaMatrizRiesgoProceso, Tercero_idRespondable, Proceso_idProceso, Compania_idCompania) values (0, "'.$fechaMatrizDofa.'", '.$idTercero.', '.$idProceso.', '.\Session::get("idCompania").')');

          		// Consultamos el ultimo id con el max

		        $matrizriesgoproceso = DB::select("Select MAX(idMatrizRiesgoProceso) as idMatrizRiesgoProceso
		          From matrizriesgoproceso 
		          where Compania_idCompania = ". \Session::get("idCompania"));

		        $idMatrizRiesgo = get_object_vars($matrizriesgoproceso[0])["idMatrizRiesgoProceso"];

		        $indice = array(
		        	// lo dejamos en blanco ya que este se va a insertar en el ultimo registro 
		            'MatrizDOFADetalle_idMatrizDOFADetalle' => $idMatrizDofaDetalle
		            );

		        $data = array(
		        'MatrizDOFADetalle_idMatrizDOFADetalle' => $idMatrizDofaDetalle,
                 'MatrizRiesgoProceso_idMatrizRiesgoProceso' => $idMatrizRiesgo,
                  'descripcionMatrizRiesgoProcesoDetalle' => $descripcionMatrizRiesgo
		            );
          }
          else
          	// si el proceso si existe nada mas va a crear el detalle en ese proceso que ya existe en MATRIZ RIESGO PROCESO 
          {
          		$indice = array(
          			// lo dejamos en blanco ya que este se va a insertar en el ultimo registro 
		            'MatrizDOFADetalle_idMatrizDOFADetalle' => $idMatrizDofaDetalle
		            );

		        $data = array(
		        'MatrizDOFADetalle_idMatrizDOFADetalle' => $idMatrizDofaDetalle,
                 'MatrizRiesgoProceso_idMatrizRiesgoProceso' => $idMatrizRiesgo,
                  'descripcionMatrizRiesgoProcesoDetalle' => $descripcionMatrizRiesgo
		            );
          }

          $respuesta = \App\MatrizRiesgoProcesoDetalle::updateOrCreate($indice, $data);
      }
?>