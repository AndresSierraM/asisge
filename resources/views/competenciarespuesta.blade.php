@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Respuestas de Parámetros de habilidades actitudinales</center></h3>@stop
@section('content')
@include('alerts.request')



@if(isset($competenciarespuesta))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($competenciarespuesta,['route'=>['competenciarespuesta.destroy',$competenciarespuesta->idCompetenciaRespuesta],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($competenciarespuesta,['route'=>['competenciarespuesta.update',$competenciarespuesta->idCompetenciaRespuesta],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'competenciarespuesta.store','method'=>'POST'])!!}
  @endif

                          
<div class="competenciarespuesta-container">
      <form class="form-horizontal" action="" method="post">
             <legend class="text-center"></legend>    

      <!-- Respuesta --> 
                  <div class="form-group" id='test'>
                             {!!Form::label('respuestaCompetenciaRespuesta', 'Respuesta', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group"> 
                                  <span class="input-group-addon">
                                    <i class="fa fa-font"></i> 
                                  </span>
                     {!!Form::text('respuestaCompetenciaRespuesta',null,['class'=>'form-control','placeholder'=>'Por favor ingrese la Respuesta','style'=>'width:100%;,right'])!!}
                                  {!!Form::hidden('idCompetenciaRespuesta', null, array('id' => 'idCompetenciaRespuesta')) !!}
                                 
                            </div>
                        </div>
                    </div>
              <!--  Porcentaje Normal -->
                    <div tyle="display:inline-block; class="form-group" id='test'>
                                {!!Form::label('porcentajeNormalCompetenciaRespuesta', 'Porcentaje Normal ', array('class' => 'col-sm-1 control-label')) !!}
                            <div class="col-sm-11">
                                <div class="input-group"> 
                                        <span class="input-group-addon">
                                        <i class="fa fa-repeat"></i>
                                        </span>
                                {!!Form::text('porcentajeNormalCompetenciaRespuesta',null,['class'=>'form-control','placeholder'=>'Por favor ingrese el Porcentaje Normal','style'=>'width:100%;,right'])!!}
                                                                        
                              </div>

                         </div>

                    </div>
                        <!--porcentajeInversoCompetenciaRespuesta -->
                      <div style="display:inline-block; class="form-group" id='test'>
                                {!!Form::label('porcentajeInversoCompetenciaRespuesta', 'Porcentaje inverso ', array('class' => 'col-sm-1 control-label')) !!}
                            <div class="col-sm-11">
                                <div class="input-group"> 
                                        <span class="input-group-addon">
                                        <i class="fa fa-undo"></i>
                                        </span>
                                {!!Form::text('porcentajeInversoCompetenciaRespuesta',null,['class'=>'form-control','placeholder'=>'Por favor ingrese el Porcentaje Inverso','style'=>'width:100%;,right'])!!}
                                                                        
                              </div>
                         </div>
                    </div> 
                    </br>  
                               
                                
    </form>
    </br>  
    </br>  
    </br>  
    </br>  
    @if(isset($competenciarespuesta))
                               @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
                                  {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
                                @else
                                  {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
                                @endif
                              @else
                                {!!Form::submit('Guardar',["class"=>"btn btn-primary"])!!}
                              @endif

                             {!! Form::close() !!}
</div>                         
   @stop
   

        

                   