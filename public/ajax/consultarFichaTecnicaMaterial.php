<?php 

$id = $_GET['idFichaTecnica'];
$cantidadOP = (($_GET['cantidadOP'] == null or $_GET['cantidadOP'] == '') ? 0 : $_GET['cantidadOP']);


$materiales = DB::select(
            'SELECT 
            	nombreFichaTecnicaMaterial as nombreOrdenProduccionMaterial, 
            	SUM(consumoFichaTecnicaMaterial) as consumoUnitarioOrdenProduccionMaterial,
            	SUM(consumoFichaTecnicaMaterial * '.$cantidadOP.') as consumoTotalOrdenProduccionMaterial
            FROM fichatecnicamaterial 
            WHERE FichaTecnica_idFichaTecnica = '.$id.'
            group by nombreFichaTecnicaMaterial');

echo json_encode($materiales);
?>