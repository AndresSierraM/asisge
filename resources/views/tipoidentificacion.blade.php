@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Tipo de Identificaci&oacute;n</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($tipoidentificacion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoidentificacion,['route'=>['tipoidentificacion.destroy',$tipoidentificacion->idTipoIdentificacion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoidentificacion,['route'=>['tipoidentificacion.update',$tipoidentificacion->idTipoIdentificacion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipoidentificacion.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="tipoidentificacion-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoTipoIdentificacion', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoTipoIdentificacion',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la identificacion'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!! Form::label('nombreTipoIdentificacion', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreTipoIdentificacion',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la identificacion'])!!}
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($tipoidentificacion))
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
@stop