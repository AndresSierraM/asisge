<?php 

$idEntrega = $_POST['Tercero_idTercero'];

$consulta = DB::Select('
SELECT eep.idEntregaElementoProteccion,t.nombreCompletoTercero
FROM entregaelementoproteccion eep
LEFT JOIN tercero t
ON eep.Tercero_idTercero = t.idTercero
WHERE eep.idEntregaElementoProteccion = '.$idEntrega);
 	
$tablahtml = '';
$datosconsulta = null;
// convertimos la consulta en array por facilidad de manejo


// Se crea el concatenado para  armar la tabla 
 $tablahtml .=   '<div class="container" style="width: 100px;">                                       
<table class="table table-striped table-bordered table-hover table-condensed"> ';

for($i = 0; $i < count($consulta); $i++)
{
    $datosconsulta = get_object_vars($consulta[$i]); 


	// Contenido de los tr y td 
	$tablahtml .= '
	<tr background-color:#EEEEEE;>
		<td><button type="button" value="'.$datosconsulta["idEntregaElementoProteccion"].'" class="btn btn-primary" onclick="signaturePad.clear();
                mostrarFirma();asignaridEntrega(this.value)" style="width:100%;">Firmar</button></td>
		<td>'.$datosconsulta['nombreCompletoTercero'].'</td>   
	</tr>
	';

 
	// Se cierra la tabla
	$tablahtml .= '
	</tbody>
	</table>
	</div>';
}




echo json_encode($tablahtml);
?>


