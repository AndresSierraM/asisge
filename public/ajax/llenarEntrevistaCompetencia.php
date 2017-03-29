<?php 

$idCargo = $_POST['idCargo'];

// consultamos las preguntas que ya han sido guardadas en la entrevista
$preguntas = DB::Select('
	SELECT
	idEntrevistaCompetencia, CompetenciaPregunta_idCompetenciaPregunta,preguntaCompetenciaPregunta,valorEntrevistaCompetencia, respuestaCompetenciaPregunta
  FROM entrevistacompetencia ec
  LEFT JOIN competenciapregunta cp
    On ec.CompetenciaPregunta_idCompetenciaPregunta = cp.idCompetenciaPregunta 
  LEFT JOIN entrevista e
    On ec.Entrevista_idEntrevista = e.idEntrevista
    where estadoCompetenciaPregunta = "Activo" and Cargo_idCargo = '.$idCargo);


// consultamos los posibles tipo sde respuestas para las preguntas
$respuestas = DB::Select('	
	SELECT 
		idCompetenciaRespuesta, respuestaCompetenciaRespuesta, porcentajeNormalCompetenciaRespuesta, porcentajeInversoCompetenciaRespuesta
  	FROM competenciarespuesta');

$consulta = array($preguntas, $respuestas);
echo json_encode($consulta);
?>
