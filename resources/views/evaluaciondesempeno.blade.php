@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Evaluacion de Desempeño</center></h3>@stop
@section('content')
@include('alerts.request')

<!-- {!!Html::script('js/entrevista.js')!!} -->

@if(isset($evaluaciondesempeno))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($evaluaciondesempeno,['route'=>['evaluaciondesempeno.destroy',$evaluaciondesempeno->idevaluaciondesempeno],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($evaluaciondesempeno,['route'=>['evaluaciondesempeno.update',$evaluaciondesempeno->idevaluaciondesempeno],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'evaluaciondesempeno.store','method'=>'POST'])!!}
  @endif






<script>


   

</script> 
                        <div id='form-section' >

                            <fieldset id="evaluaciondesempeno-form-fieldset">  

                                                                              

                                                                             

                                                                      

                                                                                             
                            </fieldset>                                          
                        </div>
 <input type="hidden" id="token" value="{{csrf_token()}}"/>
                                              <!-- OPCIONES DEL FORMULARIO  -->  

                                        
                            <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab"  onclick="mostrarDivGenerales('General')" href="#General">Habilidades propias del Cargo</a></li> <!-- Se hizo un cambio para evitar cambiar la funciones de los divs nada mas se le cambia el nombre a competencia y Generales -->
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Competencias')" href="#Competencias">Generales</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Habilidades')" href="#Habilidades">Habilidades actitudinales</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('otraspreguntas')" href="#otraspreguntas">Otras Preguntas</a></li>

                              </ul>

<div class="tab-content">
                            <div id="General" class="tab-panel fade in active" >
                                  <div class="form-group">
                                      <div class="panel panel-default">
                                            <!-- <div class="panel-heading">General</div> -->
                                          <div class="panel-body">
                                              <div class="panel-group" id="accordion">
                                                            <!-- Educacion -->
                                                    <div class="panel panel-default">
                                                          <div class="panel-heading">
                                                              <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#Educacion">Educacion</a>
                                                              </h4>
                                                          </div>
                                                            <div id="Educacion" class="panel-collapse collapse">
                                                            
                                          
                                                            </div>
                                                    </div>  
                                                                          <!-- FORMACION -->
                                                    <div class="panel panel-default">
                                                              <div class="panel-heading">
                                                                  <h4 class="panel-title">
                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#Formacion">Formacion</a>
                                                                  </h4>
                                                              </div>
                                                              <div id="Formacion" class="panel-collapse collapse">  
                                                                    
                                                              </div>
                                                    </div>  
                                                                              <!-- habilidades -->
                                                    <div class="panel panel-default">
                                                              <div class="panel-heading">
                                                                  <h4 class="panel-title">
                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#Habilidadesinterno">Habilidades propias del Cargo</a>
                                                                  </h4>
                                                              </div>
                                                                <div id="Habilidadesinterno" class="panel-collapse collapse">  
                                                                        <div class="panel-body">
                                                                            
                                                                        </div>
                                                               </div>
                                                    </div>
                                              </div>
                                          </div>
                                    </div>
                                </div>
                            </div>


                                                                                    <!-- OPCION 2 -->

                    <div id="Competencias" class="tab-pane fade ">
                                                    <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                                                    <li class="active"><a data-toggle="tab" onclick="mostrarDivInternos('aspectopersonal')" href="#aspectopersonal">Aspectos Personales</a></li>
                                                  
                                                    <li class=""><a data-toggle="tab"  onclick="mostrarDivInternos('educativo')" href="#educativo">Educativos</a></li>
                                                    <li class=""><a data-toggle="tab"  onclick="mostrarDivInternos('laboral')" href="#laboral">Laborales</a></li>
                                                    <li class=""><a data-toggle="tab"  onclick="mostrarDivInternos('sociales')" href="#sociales">Sociales/Personalidad</a></li>

                                                    </ul>
                                                         
                                                              <!-- OPCION ASPECTOS PERSONALES -->
                                                 <div id="aspectopersonal" class="tab-panel fade in active" >
                                                     <div class="evaluaciondesempeno-container">
                                                         <div class="panel panel-default" > 
                                                             <!-- Fecha de Nacimiento  --> 
                                                                          <div class="form-group">
                                                                              <div class="panel-body"> 
                                                                                <!--  -->
                                                                              </div>                               
                                                                          </div>

                                         
                                                              
                                                                        <div id="educativo" class="tab-panel fade" style="display:none;" >
                                                                              <div class="educativo-container">
                                                                                    <div class="panel panel-default" > 
                                                                                       <!--  -->
                                                                                    </div>
                                                                              </div>
                                                                        </div>
                                                                            <!-- laborales -->
                                                                  <div id="laboral" class="tab-panel fade" style="display:none;">
                                                                        <div class="laboral-container">
                                                                            <div class="panel panel-default" >    
                                                                                         <!--  -->
                                                                            </div>
                                                                        </div>                    
                                                                  </div>                              
                                                          </div>
                                                     </div>   
                                                 </div>
                                                                    <!-- socialespersonalidad -->
                                                         <div id="sociales" class="tab-panel fade" style="display:none;">
                                                             <div class="evaluaciondesempeno-container">
                                                                 <div class="panel panel-default" > 

                                                                            
                                                                                                 <!--  -->
                                                                 </div>
                                                             </div>
                                                       </div>
                    </div>                
                                                  <!-- OPCION 3 -->
                                                 <div id="Habilidades" class="tab-pane fade">
                                                                  
                                                
                                                </div>

                                                             <!--  OOPCION 4 -->
                                               <div id="otraspreguntas" class="tab-pane fade">
                                                
                                                </div>

  </div>
@if(isset($evaluaciondesempeno))
   @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
    @else
      {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
    @endif
@else
    {!!Form::submit('Guardar',["class"=>"btn btn-primary"])!!}
@endif
  <!-- ,"onclick"=>'validarFormulario(event);' -->

 {!! Form::close() !!}
        

<script>

// 
 
</script> 

   
   @stop
