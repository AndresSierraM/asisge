<?php 
$idCargo = $_POST['idCargo'];

// Consultamos las preguntas asociadas al cargo
$preguntas = DB::Select('
	SELECT
	NULL as idEntrevistaCompetencia, idCompetenciaPregunta as CompetenciaPregunta_idCompetenciaPregunta, preguntaCompetenciaPregunta, NULL as CompetenciaRespuesta_idCompetenciaRespuesta
  FROM cargocompetencia cc
  LEFT JOIN competenciapregunta cp
    On cc.Competencia_idCompetencia = cp.Competencia_idCompetencia
  LEFT JOIN competencia c
    On cc.Competencia_idCompetencia = c.idCompetencia
    where Cargo_idCargo = '.$idCargo);

// consultamos los posibles tipo sde respuestas para las preguntas
$respuestas = DB::Select('	
	SELECT 
		idCompetenciaRespuesta, respuestaCompetenciaRespuesta, porcentajeNormalCompetenciaRespuesta, porcentajeInversoCompetenciaRespuesta
  	FROM competenciarespuesta');

$consulta = array($preguntas, $respuestas);
echo json_encode($consulta);
?>



