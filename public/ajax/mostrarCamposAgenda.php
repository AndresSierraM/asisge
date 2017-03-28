<?php 

$idCategoriaAgenda = $_POST['idCategoriaAgenda'];
$idAgenda = (isset($_POST['idAgenda']) ? $_POST['idAgenda'] : '');

if ($idAgenda != '') 
{
	$categoria = DB::Select('SELECT CategoriaAgenda_idCategoriaAgenda FROM agenda WHERE idAgenda = '.$idAgenda);

	$idCategoriaAgenda = get_object_vars($categoria[0])['CategoriaAgenda_idCategoriaAgenda'];
}

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