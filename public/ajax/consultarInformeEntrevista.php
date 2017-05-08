<?php 


    $condicion = $_POST['condicion'];


        $estadoEntrevistaResultado = $_POST['estados'];

        $accion = $_POST['accion'];

        $readonly = '';
        $disabled = '';

        if ($accion == 'eliminar') 
        {
          $readonly = 'readonly';
          $disabled = 'disabled';
        }
        else
        {
          $readonly = ''; 
          $disabled = '';
    
         } 

        $estado = substr($estadoEntrevistaResultado, 0, strlen($estadoEntrevistaResultado)-1);
        // el substr es para que llegue a la posicion 0 luego a la 1 y luego a la 2. luego en el strlen recorre el string hasta llegar

        $estadoEntrev = '';

        if ($estado != '') 
        {
          $estadoEntrev = ' AND estadoEntrevista IN ('.str_replace('3', '\'Rechazado\'', str_replace('2', '\'Seleccionado\'', str_replace('1','\'EnProceso\'',$estado))).')';  
        }

        $and = ($estadoEntrev == '' ? '' : $estadoEntrev);


        $consulta = DB::Select('
        SELECT idEntrevista,e.Cargo_idCargo,e.Tercero_idEntrevistador,fechaEntrevista,c.porcentajeEducacionCargo,c.porcentajeExperienciaCargo,c.porcentajeFormacionCargo,c.porcentajeResponsabilidadCargo,c.porcentajeHabilidadCargo,Competencia_idCompetencia,nombre1AspiranteEntrevista,nombre2AspiranteEntrevista,apellido1AspiranteEntrevista,apellido2AspiranteEntrevista,t.nombreCompletoTercero,e.calificacionEducacionEntrevista,e.calificacionFormacionEntrevista,e.calificacionHabilidadCargoEntrevista,e.calificacionHabilidadActitudinalEntrevista,e.experienciaAspiranteEntrevista,e.experienciaRequeridaEntrevista,e.estadoEntrevista,e.TipoIdentificacion_idTipoIdentificacion,e.observacionEntrevista
        FROM entrevista e
        Left Join cargo c
        On e.Cargo_idCargo = c.idCargo
        left join cargocompetencia cc
        On cc.Cargo_idCargo = c.idCargo
        left join tercero t
        On e.Tercero_idEntrevistador = t.idTercero 
        WHERE '.$condicion.' '.$and); 


$Experienciainfo = '';
$arraynombre = ''; 
$arrayLabels = '';
$arrayDatos = '';
$informehtml = '';
$datosconsulta = null;
$respuestaInforme = null;

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

    $estado = array('EnProceso' => 'EnProceso', 'Seleccionado' => 'Seleccionado', 'Rechazado' => 'Rechazado');

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
      $respuestaInforme = $Sumatoriamultiplicaciones/($Sumatoriapesoporcentaje == 0 ? 1 : $Sumatoriapesoporcentaje);



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
          <td> <textarea id="observacionInformeEntrevista" name="observacionInformeEntrevista[]" '; $informehtml.= $readonly.' >'.$datosconsulta['observacionEntrevista'].'</textarea></td>
          <input type="hidden" id="idEntrevista" value ="'.$datosconsulta["idEntrevista"].'" name="idEntrevista[]">
          <input type="hidden" id="TipoIdentificacion_idTipoIdentificacion" value ="'.$datosconsulta["TipoIdentificacion_idTipoIdentificacion"].'" name="TipoIdentificacion_idTipoIdentificacion[]">
          <td>
          <select id="seleccionInformeEntrevista" name="seleccionInformeEntrevista[]"'; $informehtml.= $disabled.'>
          ';
        foreach ($estado as $numEstado => $posEstado) 
        {
          // print_r($datosSelect);
          // se hace un forech para saber el estado de la entreevista para que salga en el informe tal cual esta alla.
            $informehtml .= '<option value="'.$posEstado.'"'.($posEstado == $datosconsulta["estadoEntrevista"] ? 'selected="selected"' : '') .' >'.$posEstado.'</option>';
        }
          '</select></td> 
      </tr>
      ';

  }
      $informehtml .= '
        </tbody>
        </table>
      </div>';

  $arrayLabels .= "['Experiencia','Educacion','Formación','Habilidades Actitudinales','Habilidades propias del Cargo','Resultado(%)']";

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

/* $informehtml.=?> {!! Form::close() !!}
 <?php  */
echo json_encode($informehtml);

?>
