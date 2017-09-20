@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Clasificaci&oacute;n de Riesgos</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($clasificacionRiesgo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($clasificacionRiesgo,['route'=>['clasificacionriesgo.destroy',$clasificacionRiesgo->idClasificacionRiesgo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($clasificacionRiesgo,['route'=>['clasificacionriesgo.update',$clasificacionRiesgo->idClasificacionRiesgo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'clasificacionriesgo.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="clasificacionRiesgo-form-fieldset">	
		<div class="form-group required" id='test'>
          {!!Form::label('codigoClasificacionRiesgo', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoClasificacionRiesgo',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la clasificación de riesgo'])!!}
              {!!Form::hidden('idClasificacionRiesgo', null, array('id' => 'idClasificacionRiesgo')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group required" id='test'>
          {!!Form::label('nombreClasificacionRiesgo', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreClasificacionRiesgo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la clasificación de riesgo',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($clasificacionRiesgo))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif

	{!! Form::close() !!}
	</div>
</div>
@stop