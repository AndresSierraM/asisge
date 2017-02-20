@extends('layouts.formato')

@section('contenido')
{!!Form::model($consulta)!!}
<?php
	


$Experienciainfo = '';
$arraynombre = ''; 
$arrayLabels = '';
$arrayDatos = '';
$informehtml = '';
$datosconsulta = null;
$respuestaInforme = null;

// for ($i = 0, $c = count($consulta); $i < $c; ++$i) 
// {
//   $nombremetadato[$i] = (array) $consulta[$i];
// }

 $informehtml .=   '<div class="container">                                       
  <table class="table table-striped table-bordered table-hover table-condensed">
  <thead>
</thead>
    <thead>  ';
     for ($i=0; $i <count($consulta) ; $i++) 
    { 
      $datosconsulta = get_object_vars($consulta[$i]);

    $informehtml .= '
      <tr>

        <td colspan="2"></td>
        <td>'.$datosconsulta['porcentajeExperienciaCargo'].'%'.'</td> 
          <td>'.$datosconsulta['porcentajeEducacionCargo'].'%'.'</td> 
          <td>'.$datosconsulta['porcentajeFormacionCargo'].'%'.'</td>
          <td>Anterior Competencia</td>
          <td>'.$datosconsulta['porcentajeHabilidadCargo'].'%'.'</td>
          <td>'.$datosconsulta['porcentajeResponsabilidadCargo'].'%'.'</td>


      </tr>
      ';
     }
$informehtml .= '
      <tr>
        <th>Nombre Entrevistador</th>
        <th>Aspirante</th>
        <th>Experiencia</th>
        <th>Educacion</th>
        <th>Formación</th>
    <th>Habilidades Actitudinales</th>
    <th>Habilidades propias del Cargo</th>
    <th>Responsabilidades</th>
        <th>Resultado(%)</th>
    <th>Concepto del Entrevistador</th>
    <th>Estado Final</th>
      </tr>
    
    </thead>
    <tbody>
    
    ';

    for ($i=0; $i <count($consulta) ; $i++) 
    { 
      $datosconsulta = get_object_vars($consulta[$i]);
  

      //Promedio Experiencia 
      //Simplemente para el campo de experiencia se sacara un promedio 
      //Primero se divide la exp del aspirante / requerida 
      $Experienciainfo = $datosconsulta['experienciaAspiranteEntrevista'] / ($datosconsulta['experienciaRequeridaEntrevista'] == 0 ? 1 : $datosconsulta['experienciaRequeridaEntrevista'])*100;
        //Calculo promedio ponderado
      //Primero se multiplica con el porcentaje que obtuvo  con el porcentaje peso obtenidos de (perfiles/cargos)
      $Valor1= (($datosconsulta['calificacionEducacionEntrevista'] * ($datosconsulta['porcentajeEducacionCargo'] == 0 ? 1 : $datosconsulta['porcentajeEducacionCargo'])/100));
      $Valor2= (($datosconsulta['calificacionFormacionEntrevista'] * ($datosconsulta['porcentajeFormacionCargo'] == 0 ? 1 : $datosconsulta['porcentajeFormacionCargo'])/100));
      $Valor3= (($datosconsulta['calificacionHabilidadCargoEntrevista'] * ($datosconsulta['porcentajeHabilidadCargo']==0 ? 1 : $datosconsulta['porcentajeHabilidadCargo'])/100));
      //luego se suman los valores obtenidos  de las multiplicaciones 
      $Sumatoriamultiplicaciones= $Valor1 + $Valor2 +$Valor3 + $Experienciainfo;
      //despues se suman los porcentajes peso 
      $Sumatoriapesoporcentaje = $datosconsulta['porcentajeEducacionCargo'] + $datosconsulta['porcentajeExperienciaCargo']+ $datosconsulta['porcentajeFormacionCargo'] + $datosconsulta['porcentajeHabilidadCargo'] + $datosconsulta['porcentajeResponsabilidadCargo'];

      //finalmente la sumatoria de las multiplicaciones se divide por la sumatoria de los porcentaje peso para obtener el ponderado
      $respuestaInforme = $Sumatoriamultiplicaciones/$Sumatoriapesoporcentaje;



      $informehtml .= '
      <tr background-color:#EEEEEE;>
          <td>'.$datosconsulta['nombreCompletoTercero'].'</td>
          <td>'.$datosconsulta['nombre1AspiranteEntrevista'].' '.$datosconsulta['nombre2AspiranteEntrevista'].' '.$datosconsulta['apellido1AspiranteEntrevista'].' '.$datosconsulta['apellido2AspiranteEntrevista'].'</td>
          <td>'.$Experienciainfo.'%'.'</td>
      <td>'.$datosconsulta['calificacionEducacionEntrevista'].'%'.'</td>
          <td>'.$datosconsulta['calificacionFormacionEntrevista'].'%'.'</td>
      <td>'.$datosconsulta['calificacionHabilidadActitudinalEntrevista'].'%'.'</td>
      <td>'.$datosconsulta['calificacionHabilidadCargoEntrevista'].'%'.'</td>
          <td></td> 
          <td>'.$respuestaInforme.'%'.'</td>
          <td>'.$datosconsulta["observacionEntrevista"].'</td>
          <input type="hidden" id="idEntrevista" value ="'.$datosconsulta["idEntrevista"].'" name="idEntrevista[]">
          <input type="hidden" id="TipoIdentificacion_idTipoIdentificacion" value ="'.$datosconsulta["TipoIdentificacion_idTipoIdentificacion"].'" name="TipoIdentificacion_idTipoIdentificacion[]">
          <td>'.$datosconsulta["estadoEntrevista"].'</td> 
      </tr>
      ';

  }
  
      $informehtml .= '
        </tbody>
        </table>
      </div>';

  $arrayLabels .= "['Nombre', 'Experiencia','Educacion','Formación','Habilidades Actitudinales','Habilidades propias del Cargo','Resultado(%)']";

  $arrayDatos .= '['.$Experienciainfo.','.$datosconsulta["calificacionEducacionEntrevista"].','.$datosconsulta["calificacionFormacionEntrevista"].','.$datosconsulta["calificacionHabilidadActitudinalEntrevista"].','.$datosconsulta["calificacionHabilidadCargoEntrevista"].','.$respuestaInforme.']';

  


 // // Se introduce esta porcion de codigo para que imprima la grafica de los datos obtenidos
     $informehtml .= '  
       <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-6" style=" left:25%;">
          <div class="panel panel-primary" >
            <div class="panel-heading">
             <i class="fa fa-pie-chart fa-fw"></i> Entrevista
            </div>
            <div class="panel-body" style="min-height: 400px; max-height: 400px;">
                  <canvas id="graficoentrevista" ></canvas>
            </div>
          </div>
        </div>
        </div>';

  


function graficoBarra($marco, $arrayLabels, $arrayDatos)
{
    $informehtml = '';
    $informehtml .='
    <script type="text/javascript">
        var chrt = document.getElementById("'.$marco.'").getContext("2d");
                var data = {
                    labels:'.$arrayLabels.',
                    datasets: [
                        {
                          
                            fillColor: "rgba(220,120,220,0.8)",
                            strokeColor: "rgba(220,120,220,0.8)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            data:'.$arrayDatos.'
                           
                        }
                    ]
                };
                var myFirstChart = new Chart(chrt).Bar(data);
        </script>';

        return $informehtml;
}
/*$informehtml .='
 <button class="btn btn-primary" onclick="guardarDatos()">Actualizar</button> 
';*/
$informehtml .= graficoBarra('graficoentrevista', $arrayLabels, $arrayDatos);

echo $informehtml;
?>
	{!!Form::close()!!}
@stop