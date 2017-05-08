<?php 

$idEntrevista = $_POST['idEntrevista'];

$consulta = DB::Select("
	SELECT 
    * 
  FROM 
    entrevistacompetencia ec 
    LEFT JOIN 
  competenciapregunta cp ON ec.CompetenciaPregunta_idCompetenciaPregunta = cp.idCompetenciaPregunta 
    LEFT JOIN 
  competenciarespuesta cr ON ec.valorEntrevistaCompetencia = IF( respuestaCompetenciaPregunta = 'Normal', cr.porcentajeNormalCompetenciaRespuesta, cr.porcentajeInversoCompetenciaRespuesta ) 
  WHERE Entrevista_idEntrevista = ".$idEntrevista);


echo json_encode($consulta);
?>
