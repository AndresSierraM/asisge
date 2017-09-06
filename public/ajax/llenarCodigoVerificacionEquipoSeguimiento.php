<?php 
	// Recibe ese id enviado por get
    $id = (isset($_GET['idequipseguimiento']) ? $_GET['idequipseguimiento'] : 0);
    
    $codigoverificacion = DB::select(
    'SELECT esd.idEquipoSeguimientoDetalle,es.idEquipoSeguimiento,esd.identificacionEquipoSeguimientoDetalle,t.nombreCompletoTercero,
    esd.errorPermitidoCalibracionEquipoSeguimientoDetalle
    FROM equiposeguimiento es
    LEFT JOIN equiposeguimientodetalle esd
    ON esd.EquipoSeguimiento_idEquipoSeguimiento = es.idEquipoSeguimiento
    LEFT JOIN tercero t
    ON es.Tercero_idResponsable = t.idTercero
    WHERE esd.EquipoSeguimiento_idEquipoSeguimiento = '.$id);

    //  $sublineas= array();
    // for($i = 0; $i < count($sublinea); $i++) 
    // {
    //   $sublineas[] = get_object_vars($sublinea[$i]);
    // }
   

     echo json_encode($codigoverificacion);
  
?>


