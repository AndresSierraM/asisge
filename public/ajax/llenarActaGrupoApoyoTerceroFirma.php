<?php 

$idActaGrupo = $_POST['GrupoApoyo_idGrupoApoyo'];

$consulta = DB::Select('
SELECT t.nombreCompletoTercero,t.idTercero
FROM
  actagrupoapoyo  aga
  LEFT JOIN actagrupoapoyotercero  agat
  ON agat.ActaGrupoApoyo_idActaGrupoApoyo = aga.idActaGrupoApoyo
  LEFT JOIN tercero t
  ON agat.Tercero_idParticipante = t.idTercero
  where aga.idActaGrupoApoyo = '.$idActaGrupo);


 	
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
                mostrarFirma();asisgnaridTercero(this.value)" style="width:100%;">Firmar</button></td>
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


