<?php 

$NumAccidente = $_POST['numeroAccidente'];

$consulta = DB::Select('

SELECT acc.Tercero_idCoordinador,acc.numeroAccidente,t.nombreCompletoTercero
FROM accidente acc
LEFT JOIN compania c
ON acc.Compania_idCompania = c.idCompania
LEFT JOIN tercero t
ON acc.Tercero_idCoordinador = t.idTercero
WHERE acc.numeroAccidente = '.$NumAccidente);
 	
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
		<td><button type="button" value="'.$datosconsulta["Tercero_idCoordinador"].'" class="btn btn-primary" onclick="signaturePad.clear();
                mostrarFirma();asignaridCord(this.value);" style="width:100%;">Firmar</button></td>
		<td style="color:black;">'.$datosconsulta['nombreCompletoTercero'].'</td>   
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


