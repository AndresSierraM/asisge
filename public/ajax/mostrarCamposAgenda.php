<?php 

$idCategoriaAgenda = $_POST['idCategoriaAgenda'];

$campos = DB::Select('
	SELECT
	    nombreCampoCRM
	FROM
	    categoriaagendacampo cac
	    	LEFT JOIN
	    campocrm camp ON cac.CampoCRM_idCampoCRM = camp.idCampoCRM
	WHERE CategoriaAgenda_idCategoriaAgenda = '.$idCategoriaAgenda);

echo json_encode($campos);
?>