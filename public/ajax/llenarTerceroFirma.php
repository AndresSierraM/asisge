<?php 

$numeroActa = $_POST['numeroActaCapacitacion'];


$consulta = DB::Select('
SELECT  ac.idActaCapacitacion,t.nombreCompletoTercero,t.idTercero
FROM actacapacitacion ac
LEFT JOIN actacapacitacionasistente  acasis
ON acasis.ActaCapacitacion_idActaCapacitacion = ac.idActaCapacitacion
LEFT JOIN tercero t 
ON acasis.Tercero_idAsistente = t.idTercero
WHERE ac.numeroActaCapacitacion = '.$numeroActa.' and ac.Compania_idCompania = '.\Session::get('idCompania'));



 	
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
		<td><button type="button" value="'.$datosconsulta["idTercero"].'" class="btn btn-primary" onclick="signaturePad.clear();
                mostrarFirma();asisgnaridTercero(this.value);asignaridactacapa('.$datosconsulta['idActaCapacitacion'].')" style="width:100%;">Firmar</button></td>
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


