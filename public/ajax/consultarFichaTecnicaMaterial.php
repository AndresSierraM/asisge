<?php 

$id = $_GET['idFichaTecnica'];
$cantidadOP = (($_GET['cantidadOP'] == null or $_GET['cantidadOP'] == '') ? 0 : $_GET['cantidadOP']);


$materiales = DB::select(
            'SELECT 
            	FichaTecnica_idMaterial,
            	referenciaFichaTecnica as referenciaOrdenProduccionMaterial,
            	nombreFichaTecnica as nombreOrdenProduccionMaterial, 
            	SUM(consumoFichaTecnicaMaterial) as consumoUnitarioOrdenProduccionMaterial,
            	SUM(consumoFichaTecnicaMaterial * '.$cantidadOP.') as consumoTotalOrdenProduccionMaterial
            FROM fichatecnicamaterial FTM 
            LEFT JOIN fichatecnica FT 
            ON FTM.FichaTecnica_idMaterial = FT.idFichaTecnica 
            WHERE FichaTecnica_idFichaTecnica = '.$id.'
            group by FichaTecnica_idMaterial');

echo json_encode($materiales);
?>