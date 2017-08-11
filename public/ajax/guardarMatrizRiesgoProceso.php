<?php 
	// Se recibe por parametro todo lo que envia desde antess de guardar en cada Update or Create en el controller MatrizDofaController
     function guardarMatrizRiesgoProceso($idProceso, $idTercero, $descripcionMatrizRiesgo, $fechaMatrizDofa)
      {

          $matrizriesgoproceso = DB::select("
             SELECT mrp.idMatrizRiesgoProceso
             FROM matrizriesgoproceso mrp
             LEFT JOIN compania c
             ON mrp.Compania_idCompania = c.idCompania
             WHERE
             mrp.Compania_idCompania = ". \Session::get("idCompania").
             ' AND Proceso_idProceso = '.$idProceso);

          // Se conviete para facilidad de manejo
          $idMatrizRiesgo = (empty($matrizriesgoproceso) ? '' : get_object_vars($matrizriesgoproceso[0])["idMatrizRiesgoProceso"]);


          if ($idMatrizRiesgo == '') 
          {
          		DB::statement('INSERT into matrizriesgoproceso (idMatrizRiesgoProceso, fechaMatrizRiesgoProceso, Tercero_idRespondable, Proceso_idProceso, Compania_idCompania) values (0, "'.$fechaMatrizDofa.'", '.$idTercero.', '.$idProceso.', '.\Session::get("idCompania").')');

          		// Consultamos el ultimo id con el max

		        $matrizriesgoproceso = DB::select("Select MAX(idMatrizRiesgoProceso) as idMatrizRiesgoProceso
		          From matrizriesgoproceso 
		          where Compania_idCompania = ". \Session::get("idCompania"));

		        $idMatrizRiesgo = get_object_vars($matrizriesgoproceso[0])["idMatrizRiesgoProceso"];

		        $indice = array(
		            'idMatrizRiesgoProcesoDetalle' => ''
		            );

		        $data = array(
                 'MatrizRiesgoProceso_idMatrizRiesgoProceso' => $idMatrizRiesgo,
                  'descripcionMatrizRiesgoProcesoDetalle' => $descripcionMatrizRiesgo
		            );
          }
          else
          {
          		$indice = array(
		            'idMatrizRiesgoProcesoDetalle' => ''
		            );

		        $data = array(
                 'MatrizRiesgoProceso_idMatrizRiesgoProceso' => $idMatrizRiesgo,
                  'descripcionMatrizRiesgoProcesoDetalle' => $descripcionMatrizRiesgo
		            );
          }

          $respuesta = \App\MatrizRiesgoProcesoDetalle::updateOrCreate($indice, $data);
      }
?>