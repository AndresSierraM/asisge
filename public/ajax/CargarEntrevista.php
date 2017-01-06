
<?php 
$id = isset($_POST["idEncuesta"]) ? $_POST["idEncuesta"] : 0;
if($id == 0 || $id=='')
{
  $respuesta = array ('contenido' => '');
  echo json_encode($respuesta);
}
else
{
  $encuesta = DB::select(
    'SELECT idEncuesta,
      tituloEncuesta, descripcionEncuesta,
      idEncuestaPregunta, preguntaEncuestaPregunta, detalleEncuestaPregunta, tipoRespuestaEncuestaPregunta,
   idEncuestaOpcion, valorEncuestaOpcion, nombreEncuestaOpcion
    FROM encuesta
     left join encuestapregunta
    on encuesta.idEncuesta = encuestapregunta.Encuesta_idEncuesta
    left join encuestaopcion
    on encuestapregunta.idEncuestaPregunta = encuestaopcion.EncuestaPregunta_idEncuestaPregunta
    where idEncuesta = '.$id);


// convertimos la consulta en array por facilidad de manejo
$datos = array();

for($i = 0; $i < count($encuesta); $i++)
{
    $datos[] = get_object_vars($encuesta[$i]); 
}

$textohtml =  '<div class="PublicacionForm">
  <input type="hidden" id="idEncuesta" name="idEncuesta" value="'.$datos[0]["idEncuesta"].'">
  <center><label class="PublicacionTitulo">'.$datos[0]["tituloEncuesta"].'</label></center>
  <label class="PublicacionSubtitulo">'.$datos[0]["descripcionEncuesta"].'</label>';

$i = 0;
$numPreg = 0;
while($i < count($datos))
{
 $preguntaAnt = $datos[$i]["idEncuestaPregunta"];

 $textohtml .=  '<div class="divEncuesta">
   <input type="hidden" id="idEncuestaPregunta" name="idEncuestaPregunta['.$numPreg.']" value="'.$datos[$i]["idEncuestaPregunta"].'">
   <div class="PublicacionPregunta">'.($numPreg+1).') '.$datos[$i]["preguntaEncuestaPregunta"].'</div> 
   
   <div class="PublicacionDetalle">
    '.$datos[$i]["detalleEncuestaPregunta"].'
   </div>';

 $tipo = '';
 switch($datos[$i]["tipoRespuestaEncuestaPregunta"])
 {
  case 'Respuesta Corta':
   $tipo = '<input type="text" id="respuesta" name="respuesta['.$numPreg.'][]" value="">';
   $i++;
   break;
  case 'Párrafo':
   $tipo = '<textarea id="respuesta" name="respuesta['.$numPreg.'][]"></textarea>';
   $i++;
   break;
  case 'Fecha':
   $tipo = '<input type="date" id="respuesta" name="respuesta['.$numPreg.'][]" value="">';
   $i++;
   break;
  case 'Hora':
   $tipo = '<input type="time" id="respuesta" name="respuesta['.$numPreg.'][]" value="">';
   $i++;
   break;

  default:

    switch($datos[$i]["tipoRespuestaEncuestaPregunta"])
    {
     case 'Selección Múltiple':
      $tipo = '';
      while($i < count($datos) and $preguntaAnt == $datos[$i]["idEncuestaPregunta"])
      {
       $tipo .= '<input type="radio" id="respuesta" name="respuesta['.$numPreg.'][]" value="'.$datos[$i]["valorEncuestaOpcion"].'" ><label class="PublicacionOpcion">'.$datos[$i]["nombreEncuestaOpcion"].'</label>';
       $i++;
      }
      break;
     case 'Casillas de Verificación':
      $tipo = '';
      while($i < count($datos) and $preguntaAnt == $datos[$i]["idEncuestaPregunta"])
      {
       $tipo .= '<input type="checkbox" id="respuesta" name="respuesta['.$numPreg.'][]" value="'.$datos[$i]["valorEncuestaOpcion"].'" ><label class="PublicacionOpcion">'.$datos[$i]["nombreEncuestaOpcion"].'</label>';
       $i++;
      }
      break;
     case 'Lista de Opciones':
      $tipo = '<select id="respuesta" name="respuesta['.$numPreg.'][]" class="PublicacionSelect">';
      while($i < count($datos) and $preguntaAnt == $datos[$i]["idEncuestaPregunta"])
      {
       $tipo .= '<option value="'.$datos[$i]["valorEncuestaOpcion"].'">'.$datos[$i]["nombreEncuestaOpcion"].'</option>';
       $i++;
      }
      $tipo .= '</select>';
      break;
     case 'Escala Lineal':
      $tipo = 'rango';
      break;
    }
  
   break;
 }

 $textohtml .=  '<div class="PublicacionSelect">'.
   $tipo.'
  </div>
  </div>';
 $numPreg++;
}



$textohtml .=  '
  </div>
  </div>';


$respuesta = array('contenido' => $textohtml);
  echo json_encode($respuesta);
}

?>


