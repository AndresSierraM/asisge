@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Entrevistas</center></h3>@stop
@section('content')
@include('alerts.request')



@if(isset($entrevista))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($entrevista,['route'=>['entrevista.destroy',$entrevista->idEntrevista],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($entrevista,['route'=>['entrevista.update',$entrevista->idEntrevista],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'entrevista.store','method'=>'POST'])!!}
  @endif
                        
<div id='form-section' >

  <fieldset id="entrevista-form-fieldset">  

                                      <!-- Cedula aspirante -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('documentoAspiranteEntrevista', 'Cedula', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('documentoAspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Cedula', 'autocomplete' => 'off'])!!}
                                                 {!!Form::hidden('idEntrevista', null, array('id' => 'idEntrevista')) !!} 
                                            </div>
                                          </div>
                                      </div>
                                            <!-- Estado Final -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('estadoEntrevista ', 'Estado Final', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-bars "></i>
                                              </span>

                                            {!! Form::select('estadoEntrevista', ['En Proceso' =>'En Proceso','Seleccionado' => 'Seleccionado','Rechazado'=>'Rechazado'],null,['class' => 'form-control',"placeholder"=>"Seleccione el estado"]) !!}                                     

                                            </div>
                                          </div>
                                      </div>

                                           <!-- Nombre aspirante -->
                                    <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('nombreAspiranteEntrevista', 'Aspirante', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('nombreAspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Nombre', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>

                                        
                                       <!-- Fecha Entrevista -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('fechaEntrevista ', 'Fecha Entrevista ', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('fechaEntrevista ',null,['class'=>'form-control','placeholder'=>'Fecha Entrevista', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>



                                             <!--  Entrevistador --> 
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('nombreEntrevistadorEntrevista', 'Entrevistador', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              
                                            </div>
                                          </div>
                                      </div>



                                           <!-- Cargo -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('Cargo_idCargo ', 'Cargo', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-bars "></i>
                                              </span>
                                          {!!Form::select('Cargo_idCargo',$cargo, (isset($entrevista) ? $entrevista->Cargo_idCargo : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                            </div>
                                          </div>
                                      </div>



                                       <!-- Experiencia en Años -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('experienciaAspiranteEntrevista ', 'Experiencia(Años)', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('experienciaAspiranteEntrevista ',null,['class'=>'form-control','placeholder'=>'Ingrese su Nombre', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>


                                           <!-- Requerida -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('experienciaRequeridaEntrevista ', 'Requerida', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-10">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              
                                            </div>
                                          </div>
                                     </div>                          
            </fieldset>                                                 
 </div>
                                              <!-- OPCIONES DEL FORMULARIO  -->  

                                        
                            <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab" href="#1">General</a></li>

                              <li class=""><a data-toggle="tab" href="#2">Competencias</a></li>
                              <li class=""><a data-toggle="tab" href="#3">Habilidades</a></li>
                              <li class=""><a data-toggle="tab" href="#4">Otras Preguntas</a></li>

                              </ul>

                      <div class="tab-content">
                           <div id="1" class="tab-panel fade in active">
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
                                        <div class="panel-body">
                                          
                                        </div>
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
                                        <div class="panel-body">
                                          
                                        </div>
                                      </div>
                                    </div>  
                                                      <!-- HABILIDADES -->
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#Habilidades">Habilidades</a>
                                        </h4>
                                      </div>
                                      <div id="Habilidades" class="panel-collapse collapse">
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

                             <div id="2" class="tab-pane fade ">
                              <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab" href="#aspectospersonales">Aspectos Personales</a></li>

                              <li class=""><a data-toggle="tab" href="#Educativos">Educativos</a></li>
                              <li class=""><a data-toggle="tab" href="#Laborales">Laborales</a></li>
                              <li class=""><a data-toggle="tab" href="#Socialespersonalidad">Sociales/Personalidad</a></li>

                              </ul>

                asdasd

                            </div>

                                                                              <!-- OPCION 3 -->
                             <div id="3" class="tab-pane fade">
                          
                            asdasda
                            </div>

                                         <!--  OOPCION 4 -->
                           <div id="4" class="tab-pane fade">
                             asdasd
                            </div>
                       </div>


                                                      @if(isset($entrevista))
                                                       @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
                                                          {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
                                                        @else
                                                          {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
                                                        @endif
                                                      @else
                                                        {!!Form::submit('Guardar',["class"=>"btn btn-primary"])!!}
                                                      @endif

                                                     {!! Form::close() !!}
<script>
 $(document).ready( function () {

  $("#fechaEntrevista").datetimepicker
  (
    ({
           format: "YYYY-MM-DD"
         })
  );
});
</script> 

   
   @stop
   



                   