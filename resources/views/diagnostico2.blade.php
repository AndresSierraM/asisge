@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Diagn&oacute;stico General (Version 2)</center></h3>@stop
@section('content')
@include('alerts.request')


<!-- {!!Html::script('js/diagnostico.js')!!} -->
  <script>

     

    $(document).ready(function()
    {
      // Ejecuta la funcon para que cargue los resultados en el edit,update 
      sumarResultado();
    });

    
  </script>

<?php 
// Se obtiene  el idDiagnostico2 que esta quemadito como null para hacer la validacion 
// se convierte de un sttd a un array normal para obtener el idDiagnostico2 y hacer la validacion en el boton 
  $idDiagnostico2 = get_object_vars($diagnostico2[0])['idDiagnostico2'];

?>

  @if(isset($diagnostico2))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($diagnostico2,['route'=>['diagnostico2.destroy',$idDiagnostico2],'method'=>'DELETE', 'files' => true])!!}
    @endif
    @if($idDiagnostico2 != '')
      {!!Form::model($diagnostico2,['route'=>['diagnostico2.update',$idDiagnostico2],'method'=>'PUT', 'files' => true])!!}
    @endif
    @if($idDiagnostico2 == '')
      {!!Form::open(['route'=>'diagnostico2.store','method'=>'POST', 'files' => true])!!}
    @endif
  @endif




<div id='form-section' >

	<fieldset id="diagnostico-form-fieldset">	
		    <div class="form-group" id='test'>
          {!! Form::label('codigoDiagnostico2', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoDiagnostico2',(isset($diagnosticoEncabezado)? $diagnosticoEncabezado -> codigoDiagnostico2 : NULL),['class'=>'form-control','placeholder'=>'Ingresa el codigo del diagnostico 2'])!!}
              {!! Form::hidden('idDiagnostico2', null, array('id' => 'idDiagnostico2')) !!}


              <input type="hidden" id="token" value="{{csrf_token()}}"/>
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaElaboracionDiagnostico2', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaElaboracionDiagnostico2',(isset($diagnosticoEncabezado)? $diagnosticoEncabezado -> fechaElaboracionDiagnostico2 : NULL), ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
            </div>
          </div>
        </div>
		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreDiagnostico2', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombreDiagnostico2',(isset($diagnosticoEncabezado)? $diagnosticoEncabezado -> nombreDiagnostico2 : NULL),['class'=>'form-control','placeholder'=>'Ingresa la descripci&oacute;n del diagnostico 2'])!!}
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Detalles</div>
                <div class="panel-body">

                  <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Equipos Cr&iacute;ticos</a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('equiposCriticosDiagnostico2',(isset($diagnosticoEncabezado)? $diagnosticoEncabezado -> equiposCriticosDiagnostico2 : NULL),['class'=>'form-control','placeholder'=>'Especfica los objetos criticos'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Herramientas  Cr&iacute;ticas</a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                              <div class="col-sm-10">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square-o "></i>
                                  </span>
                                  {!!Form::textarea('herramientasCriticasDiagnostico2',(isset($diagnosticoEncabezado)? $diagnosticoEncabezado -> herramientasCriticasDiagnostico2 : NULL),['class'=>'form-control','placeholder'=>'Especfica las herramientas criticas'])!!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Observaciones</a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('observacionesDiagnostico2',(isset($diagnosticoEncabezado)? $diagnosticoEncabezado -> observacionesDiagnostico2 : NULL),['class'=>'form-control','placeholder'=>'Especfica las observaciones del diagnostico 2'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Div para el armado de la tabla Dinamica -->
          <div class="panel-body">
            <div class="form-group" id='test'>
              <div id="diagnostico2" class="col-sm-12">
                  <!-- Se pregunta si existe la variable que se manda desde el contraroller -->
              <?php 
                if (isset($diagnostico2)) 
                {
                  // Se queman los campos del select para cuando este editando el registro
               $estado = array('NOCUMPLE' => 'NO CUMPLE','CUMPLE' => 'CUMPLE','NOAPLICA' => 'NO APLICA');  

               $datos = array();
               // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                   for ($i = 0, $c = count($diagnostico2); $i < $c; ++$i) 
                   {
                      $datos[$i] = (array) $diagnostico2[$i];
                      
                   }


                echo '<table  class="table table-striped table-bordered table-hover">';
                $i = 0;
                // Se crea una variable que a llevar el total de los registros contados
                $total = count($diagnostico2);


                // Ciclo principal que recorre toda la consulta, Que hace el primer rompimiento, "Nivel 1 de tabla diagnostico"

                // El primer while va hacer el primer Rompimiento que se va a encargar en devolver los titulos.
                while ($i < $total)   
                {
                   $niveles = $datos[$i]['tituloDiagnosticoNivel1'];
                   $idniveles = $datos[$i]['idDiagnosticoNivel1'];

                     echo '
                    <thead class="thead-inverse">  
                        <tr class="table-info">
                       <th colspan="20" style=" background-color:#255986; color:white;">'.$datos[$i]['numeroDiagnosticoNivel1'].'. '.$datos[$i]['tituloDiagnosticoNivel1'].'</th>                
                      </tr>                                    
                    </thead>';


                  
                  // se hace rompimiento de aca en adelante para los demas niveles  
                  while ($i < $total and $niveles == $datos[$i]["tituloDiagnosticoNivel1"])
                    {
                        // dentro de acada while se va crear una variable que contenga almenos el titulo para comprarlo con el sigueinte
                        $nivel2 = $datos[$i]['tituloDiagnosticoNivel2'];
                        $porcnivel2 = $datos[$i]['valorDiagnosticoNivel2'];
                        $idnivel2 = $datos[$i]['idDiagnosticoNivel2'];
                        echo '
                          <thead class="thead-inverse">  
                            <tr class="table-info">
                            <th colspan="20" style=" background-color:#1B43AB; color:white;">'.$datos[$i]['tituloDiagnosticoNivel2'].'('.$datos[$i]['valorDiagnosticoNivel2'].'%)'.'</th>                
                            </tr>                            
                          </thead>';    

                          
                           while ($i < $total and $nivel2 == $datos[$i]["tituloDiagnosticoNivel2"])
                            {

                                $nivel3 = $datos[$i]['tituloDiagnosticoNivel3'];
                                echo '
                              <thead class="thead-inverse">  
                                <tr class="table-info">
                                <th colspan="20" style=" background-color:#041F64; color:white;">'.$datos[$i]['tituloDiagnosticoNivel3'].'('.$datos[$i]['valorDiagnosticoNivel3'].'%)'.'</th>                
                                </tr>                          
                              </thead>';
                            
                              while ($i < $total and $nivel3 == $datos[$i]["tituloDiagnosticoNivel3"])
                                {
                            
                                  $nivel4 = $datos[$i]['tituloDiagnosticoNivel4'];
                                  // se ocultan los 2 id de dianostico nivel 1 y 2 para saber en que linea va al momento de hacer la suma del valor  
                                  echo '
                                  <tbody>

                                        <tr>
                                          <td style=" background-color:#058451; color:white;">'.$datos[$i]['numeroDiagnosticoNivel4'].' '.$datos[$i]['tituloDiagnosticoNivel4'].'</td>
                                          <td style=" background-color:#058451;"><input type="text" id="puntuacionDiagnostico2Detalle'.$i.'" name="puntuacionDiagnostico2Detalle[]" value="'.$datos[$i]['valorDiagnosticoNivel4'].'" readonly="readonly">                                          
                                          <input type="hidden" id="idDiagnosticoNivel1_'.$i.'" name="idDiagnosticoNivel1[]" value="'.$datos[$i]["idDiagnosticoNivel1"].'" >
                                          <input type="hidden" id="idDiagnosticoNivel2_'.$i.'" name="idDiagnosticoNivel2[]" value="'.$datos[$i]["idDiagnosticoNivel2"].'" >
                                          <input type="hidden" id="idDiagnosticoNivel4_'.$i.'" name="idDiagnosticoNivel4[]" value="'.$datos[$i]["idDiagnosticoNivel4"].'">
                                          <input type="hidden" id="idDiagnostico2Detalle" name="idDiagnostico2Detalle[]" value="'.$datos[$i]["idDiagnostico2Detalle"].'">                                      
                                          </td>
                                          <td><select id="respuestaDiagnostico2Detalle'.$i.'" name="respuestaDiagnostico2Detalle[]" onchange="calcularResultado('.$i.');">                    
                                            ';foreach ($estado as $numEstado => $posEstado) 
                                              {
                                                // Se hace el foreach para traer las opciones de la bd 
                                                  echo '<option value="'.$posEstado.'"'.($posEstado == $datos[$i]["respuestaDiagnostico2Detalle"] ? 'selected="selected"' : '') .' >'.$posEstado.'</option>';
                                              }echo'
                                          </select></td>
                                          <td><input type="text" id="resultadoDiagnostico2Detalle'.$i.'" name="resultadoDiagnostico2Detalle[]" value="'.($datos[$i]['resultadoDiagnostico2Detalle'] != '' ? $datos[$i]['resultadoDiagnostico2Detalle'] : 0).'" readonly="readonly">                                          
                                          </td>
                                          <td><textarea  id="mejoraDiagnostico2Detalle'.$i.'" type="textarea" name="mejoraDiagnostico2Detalle[]">'.$datos[$i]['mejoraDiagnostico2Detalle'].'</textarea></td>                              
                                        </tr> 

                                      </tbody
                                  </thead>';
                                  $i++;
                                  //al final del ultimo while tiene que haber una virable incremental í++
                                }      
                              
                            } 
                            // RESULTADO DE NIVEL 2 
                            echo '
                          <thead class="thead-inverse">  
                            <tr class="table-info">
                            <th colspan="3" style=" background-color:#1B43AB; color:white;">RESULTADO  '.$nivel2.'('.$porcnivel2.'%)'.'</th>
                            <th><input type="text" id="resultadonivel2_'.$idnivel2.'" name="resultadonivel2[]" value="0" readonly="readonly"></th>                
                            </tr>                            
                          </thead>';
                      }
                      // aca termina eel nivel 1 se podria poner un espacio en blanco 
                       echo '
                    <thead class="thead-inverse">  
                        <tr class="table-info">
                       <th colspan="3" style=" background-color:#255986; color:white;">RESULTADO '.$niveles.' (PUNTAJE MÁXIMO 25%)</th>
                       <th><input type="text" id="resultadonivel1_'.$idniveles.'" name="resultadonivel1[]" value="0" readonly="readonly"></th>              
                      </tr>
                      <tr class="table-info">
                       <th colspan="20" >&nbsp;</th>                
                      </tr>                                    
                    </thead>'; 
                } 
                // RESULTADO FINAL

                 echo '
                    <thead class="thead-inverse">  
                       <tr class="table-info">
                       <th colspan="4" style=" background-color:gray; color:white;">RESULTADO DIAGNÓSTICO</th>
                       <th><input type="text" id="resultadodiagnostico" name="resultadodiagnostico[]" value="0" readonly="readonly" onchange="asd">
                       </th>                
                      </tr>                                                        
                    </thead>';              
                echo '</table>';
                }

               ?>              
              </div>
            </div>
          </div>
    </fieldset>
  @if(isset($diagnostico2))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
        {!!Form::submit('Eliminar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
    @endif
    @if($idDiagnostico2 != '')
        {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
    @endif
    @if($idDiagnostico2 == '')
        {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'habilitarSubmit(event);'])!!}      
    @endif
  @endif

	{!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
        $('#fechaElaboracionDiagnostico2').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

      function calcularResultado(linea)
      {

          // tomamos el valor de la lista seleccionado por el usuario
          var lista = $("#respuestaDiagnostico2Detalle"+linea).val();

          // dependiendo del valor devolvemos un resultado en el input correspondiente
          // si NO CUMPLE el valor es cero (0), de lo contrario es el mismo valor del campo Valor
          if(lista == 'NOCUMPLE')
              $("#resultadoDiagnostico2Detalle"+linea).val(0);
          else
              $("#resultadoDiagnostico2Detalle"+linea).val($("#puntuacionDiagnostico2Detalle"+linea).val());  

          sumarResultado()        
      }
      // Se calcula el resultado solamente del nivel 2 que es solo sumar el resultado
   

    function sumarResultado()
      {
          // mientras exista un objeto que se llame asi
          //$("#idDiagnosticoNivel1_"+i)
          var sumaTotal = 0;
          var i = 0;
          while ( i < 60 ) 
          {
            var nivel1 = $("#idDiagnosticoNivel1_"+i).val();
            var suma1 = 0;
              // Se va a dejar quemado la cantidad de registros que tiene la tabla Nivel 4
            while ( i < 60  && nivel1 == $("#idDiagnosticoNivel1_"+i).val()) 
            {

              var nivel2 = $("#idDiagnosticoNivel2_"+i).val();
              var suma2 = 0;

              while ( i < 60  && nivel1 == $("#idDiagnosticoNivel1_"+i).val() &&  nivel2 == $("#idDiagnosticoNivel2_"+i).val()) 
              {
                suma1 += parseFloat($("#resultadoDiagnostico2Detalle"+i).val());
                suma2 += parseFloat($("#resultadoDiagnostico2Detalle"+i).val());
                i++;
              }

              // asignamos el valor de la suma de niveles 2 al campo correspondiente
              $("#resultadonivel2_"+nivel2).val(suma2);
            }
            // asignamos el valor de la suma de niveles 1 al campo correspondiente
            $("#resultadonivel1_"+nivel1).val(suma1);

            // las sumas de los niveles 1 se van a cumulando en el total del diagnostico
            sumaTotal += suma1; 
            
          }
          
          // asignamos el valor de la suma total al campo correspondiente
          $("#resultadodiagnostico").val(sumaTotal);

                
      }

  </script>


	</div>
</div>
@stop