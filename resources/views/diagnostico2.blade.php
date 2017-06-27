@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Diagn&oacute;stico General (Version 2)</center></h3>@stop
@section('content')
@include('alerts.request')


<!-- {!!Html::script('js/diagnostico.js')!!} -->
  <script>

     // var Diagnostico = '<?php echo (isset($diagnostico) ? json_encode($diagnostico) : "");?>';

    $(document).ready(function(){


    });

    
  </script>



<div id='form-section' >

	<fieldset id="diagnostico-form-fieldset">	
		    <div class="form-group" id='test'>
          {!! Form::label('codigoDiagnostico', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoDiagnostico',null,['class'=>'form-control','placeholder'=>'Ingresa el codigo del diagnostico 2'])!!}
             <!--  {!! Form::hidden('idDiagnostico', null, array('id' => 'idDiagnostico')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!} -->
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaElaboracionDiagnostico', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaElaboracionDiagnostico',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
            </div>
          </div>
        </div>
		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreDiagnostico', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombreDiagnostico',null,['class'=>'form-control','placeholder'=>'Ingresa la descripci&oacute;n del diagnostico 2'])!!}
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
                                {!!Form::textarea('equiposCriticosDiagnostico',null,['class'=>'form-control','placeholder'=>'Especfica los objetos criticos'])!!}
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
                                  {!!Form::textarea('herramientasCriticasDiagnostico',null,['class'=>'form-control','placeholder'=>'Especfica las herramientas criticas'])!!}
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
                                {!!Form::textarea('observacionesDiagnostico',null,['class'=>'form-control','placeholder'=>'Especfica las observaciones del diagnostico 2'])!!}
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
                if (isset($diagnostico)) 
                {
                                
               $datos = array();
               // por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
                   for ($i = 0, $c = count($diagnostico); $i < $c; ++$i) 
                   {
                      $datos[$i] = (array) $diagnostico[$i];
                      
                   }

                echo '<table  class="table table-striped table-bordered table-hover">';
                $i = 0;
                // Se crea una variable que a llevar el total de los registros contados
                $total = count($diagnostico);


                // Ciclo principal que recorre toda la consulta, Que hace el primer rompimiento, "Nivel 1 de tabla diagnostico"

                // El primer while va hacer el primer Rompimiento que se va a encargar en devolver los titulos.
                while ($i < $total)   
                {
                 $niveles = $datos[$i]['tituloDiagnosticoNivel1'];

                   echo '
                  <thead class="thead-inverse">  
                      <tr class="table-info">
                     <th colspan="20" style=" background-color:#255986; color:white;">'.$datos[$i]['tituloDiagnosticoNivel1'].'</th>                
                    </tr>                  
                  </thead>';

                // se hace rompimiento de aca en adelante para los demas niveles  
                while ($i < $total and $niveles == $datos[$i]["tituloDiagnosticoNivel1"])
                  {
                      // dentro de acada while se va crear una variable que contenga almenos el titulo para comprarlo con el sigueinte
                      $nivel2 = $datos[$i]['tituloDiagnosticoNivel2'];
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
                              echo '
                              <tbody>

                                    <tr>
                                      <td style=" background-color:#058451; color:white;">'.$datos[$i]['numeroDiagnosticoNivel4'].' '.$datos[$i]['tituloDiagnosticoNivel4'].'</td>
                                      <td style=" background-color:#058451; color:white;">'.$datos[$i]['valorDiagnosticoNivel4'].'</td>
                                      <td><select name="select" >
                                        <option value="CUMPLE">Cumple</option> 
                                        <option value="NOCUMPLE" selected>No Cumple</option>
                                        <option value="NOAPLICA">No Aplica</option>
                                      </select></td>
                                      <td>resultado</td>
                                      <td><textarea name="textarea"></textarea></td>                              
                                    </tr>                                   
                                  </tbody
                              </thead>';
                              $i++;
                              //al final del ultimo while tiene que haber una virable incremental í++
                            }  

                        }  
                    }    
                }
                echo '</table>';
                }

               ?>              
              </div>
            </div>
          </div>
  <!--         <table class="table table-striped table-bordered" width="100%" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tbody>
            <th>1.Planeacion</th>
              <tr>
                <td colspan="2">Estándar</td>
                <th>Item del estandar</th>
                <th>Valor</th>
                <th>Calificación</th>
                <th>Resultado Item</th>
                <th>Observaciones</th>
              </tr>
              <tr>
                <td rowspan="11">Recursos</td>
                <td rowspan="8" style="width:20px">Recursos financieros, técnicos,  humanos y de otra índole requeridos para coordinar y desarrollar el Sistema de Gestión de la Seguridad y la Salud en el Trabajo (SG-SST) (4%)</td>
                <td>1.1.1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.4</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.5</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.6</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.7</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.1.8</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td rowspan="3"> Capacitación en el Sistema de Gestión de la Seguridad y la Salud en el Trabajo (6%)</td>
                <td>1.2.1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.2.2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>1.2.3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="5"> RESULTADO RECUSSOS</td>
              </tr>
            </tbody>
          </table> -->
    </fieldset>
<!-- 	@if(isset($diagnostico))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @<?php else: ?>
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'habilitarSubmit(event);'])!!}
  @endif -->
  
  

	{!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
        $('#fechaElaboracionDiagnostico').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

  </script>


	</div>
</div>
@stop