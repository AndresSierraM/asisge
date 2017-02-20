@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Resultados de Entrevistas</center></h3>@stop
@section('content')
@include('alerts.request')
{!! Html::script('chart/Chart.js'); !!}
{!!Html::script('js/entrevistaresultado.js')!!}

<?php

$accion = '';
// lo que hacemos es pregutnar si existe la accion se pregunta si esa accion es igual a eliminar  es un editar de lo contrario la accion es eliminar
if (isset($_GET['accion'])) 
{
  $accion = 'display:none;';

  if ($_GET['accion'] == 'editar') 
  {
      echo 
    '<input type="hidden" id="accionFormulario" value="editar">
    <script>
    alert($(\'#accionFormulario\').val());
      $(document).ready(function(){
      consultarInformeEntrevista("$(\'#fechaInicialEntrevistaResultado\').val(), $(\'#fechaFinalEntrevistaResultado\').val(), $(\'#Cargo_idCargo\').val(), $(\'#Tercero_idEntrevistador\').val(), $(\'#accionFormulario\').val()")
    });
    </script>';
  }
  else if ($_GET['accion'] == 'eliminar')
  {
      echo 
    '<script>
      $(document).ready(function(){
      consultarInformeEntrevista("$(\'#fechaInicialEntrevistaResultado\').val(), $(\'#fechaFinalEntrevistaResultado\').val(), $(\'#Cargo_idCargo\').val(), $(\'#Tercero_idEntrevistador\').val(),\'eliminar\'")
    });
    </script>';
  }
  
}

?>
@if(isset($entrevistaresultado))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($entrevistaresultado,['route'=>['entrevistaresultado.destroy',$entrevistaresultado->idEntrevistaResultado],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($entrevistaresultado,['route'=>['entrevistaresultado.update',$entrevistaresultado->idEntrevistaResultado],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'entrevistaresultado.store','method'=>'POST'])!!}
  @endif



 <input type="hidden" id="token" value="{{csrf_token()}}"/>              
<div class="entrevistaresultado-container">

                      <!-- Cargo de entrevistaresultado            en php se ejecuta la accion para ocultar el div  -->
                  <div class="form-group" id='test' style="<?php echo $accion ?>">  
                             {!!Form::label('Cargo_idCargo', 'Cargo', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group"  style="padding-left:10px "> 
                                  <span class="input-group-addon">
                                    <i class="fa fa-bars"></i> 
                                  </span>
                                  {!!Form::hidden('idEntrevistaResultado', null, array('id' => 'idEntrevistaResultado')) !!}
                               
                                  {!!Form::select('Cargo_idCargo',$cargo, (isset($entrevistaresultado) ? $entrevistaresultado->Cargo_idCargo : 0),["class" => "select form-control", "placeholder" =>"Seleccione el Cargo" ])!!}  
                                                                                  
                            </div>
                        </div>
                    </div>
                                   <!--  Fecha Entrevista  -->

                     <div class="form-group" id='test'  style='display: inline; <?php echo $accion ?>'>
                     {!!Form::label('fechaInicialEntrevistaResultado', 'Fecha ', array('class' => 'col-sm-1 control-label')) !!}
                                    <div class="col-md-5 ">
                                            <div class="input-group"  style="padding-left:10px ">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-calendar" aria-hidden="true"></i>
                                                     </span>
                               {!!Form::text('fechaInicialEntrevistaResultado',(isset($entrevistaresultado) ? $entrevistaresultado->fechaInicialEntrevistaResultado : null),['class'=> 'form-control','placeholder'=>'Desde'])!!}
                                               </div>
                                    </div>
                                    <!-- Fecha final -->

                                  <div class="form-group" id='test'>
                                     {!!Form::label('fechaFinalEntrevistaResultado', 'Hasta', array('class' => 'col-sm-1 control-label')) !!}
                                          <div class="col-md-5">
                                                <div class="input-group" >
                                                       <span class="input-group-addon">
                                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                                       </span>
                          {!!Form::text('fechaFinalEntrevistaResultado',(isset($entrevistaresultado) ? $entrevistaresultado->fechaFinalEntrevistaResultado : null),['class'=> 'form-control','placeholder'=>'Hasta'])!!}
                                                   </div>
                                          </div>
                                 </div>
                      </div>

                    
                            <!--  Entrevistador --> 
                              <div class="form-group "  id='test' style="<?php echo $accion ?>" >
                                  {!!Form::label('Tercero_idEntrevistador', 'Entrevistador', array('class' => 'col-sm-1 control-label')) !!}
                                  <div class="col-sm-11">
                                    <div class="input-group" style="padding-left:10px ">
                                      <span class="input-group-addon">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                      </span>
                                        {!!Form::select('Tercero_idEntrevistador',$tercero, (isset($entrevistaresultado) ? $entrevistaresultado->Tercero_idEntrevistador : 0),["class" => "select form-control", "placeholder" =>"Seleccione el entrevistador"])!!}

                                         
                                    </div>
                                  </div>
                              </div>
                 
                            <!-- </br> -->


                              <div class="row" style="<?php echo $accion ?>">
                                <div class="form-group" id='test'>
        {!!Form::label('estadoEntrevistaResultado', 'Estado', array('class' => 'col-sm-1 control-label','style'=>'width:180px;padding-left:30px;')) !!}
                                    <div class="col-md-2">
                                        <div class="input-group">
                                        <!-- se pone null el estado para que laravel solito llene ese campo con lo que trae de la consulta del controlador -->
                                            {!! Form::checkbox('Estado1', 1,false, ['onclick' => 'seleccionarEstado();', 'id' => 'Estado1']) !!} 
                                            {!!Form::hidden('estadoEntrevistaResultado',null, array('id' => 'estadoEntrevistaResultado')) !!} En Proceso
                                          
                                        </div>
                                  </div>  
                                  <div class="col-md-2">
                                        <div class="input-group">
                                             {!! Form::checkbox('Estado2', 1, false, ['onclick' => 'seleccionarEstado();', 'id' => 'Estado2'] ) !!} Seleccionado
                                        </div>
                                  </div>
                                  <div class="col-md-2">
                                         <div class="input-group">
                                              {!! Form::checkbox('Estado3', 1, false, ['onclick' => 'seleccionarEstado();', 'id' => 'Estado3']) !!} Rechazado
                                         </div>
                                  </div>    
                              </div> 
                                </div>
                                </br>  
                                </br>   
                                </br>  
                                <div id="informe">
                                <!-- contenido del informe html impreso -->
                                </div>

                                </br>    
                                <div>          
                                        @if(isset($entrevistaresultado))
                                           @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
                                              {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
                                            @else
                                              {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
                                            @endif
                                          @else
                                            {!!Form::submit('Guardar',["class"=>"btn btn-primary"])!!}  
                                          @endif
                                          <!-- Se envia por parametro el valor de estadoEntrevistaResultado lo recibe en el contraoller y en la el js  -->
                                          {!!Form::button('Consultar',["class"=>"btn btn-warning",'onclick'=>'consultarInformeEntrevista(
                                            $(\'#fechaInicialEntrevistaResultado\').val(),
                                            $(\'#fechaFinalEntrevistaResultado\').val(),
                                            $(\'#Cargo_idCargo option:selected\').val(),
                                            $(\'#Tercero_idEntrevistador option:selected\').val(),\'""\')'])!!}
                            </div>

<!-- ;graficoBarra.val() -->
                   

                        <!--  SE HACE ESTA FUNCION PARA EJECUTAR LA GRAFICA -->
<?php
function graficoBarra($marco, $arrayLabels, $arrayDatos)
{
    echo '
    <script type="text/javascript">
        
        var chrt = document.getElementById("'.$marco.'").getContext("2d");
                var data = {
                    labels: '.$arrayLabels.'
                    datasets: [
                        {
                            fillColor: "rgba(220,120,220,0.8)",
                            strokeColor: "rgba(220,120,220,0.8)",
                            highlightFill: "rgba(220,220,220,0.75)",
                            highlightStroke: "rgba(220,220,220,1)",
                            data: '.$arrayDatos.'
                        }
                    ]
                };
                var myFirstChart = new Chart(chrt).Bar(data);

        </script>';
}


?>
<script>
$(document).ready( function () {

  $("#fechaInicialEntrevistaResultado").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );

 $("#fechaFinalEntrevistaResultado").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );
});
</script>


 </div>    
   @stop
   

        

                   