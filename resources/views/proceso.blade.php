@extends('layouts.principal')

@section('content')
@include('alerts.request')

	@if(isset($proceso))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($proceso,['route'=>['proceso.destroy',$proceso->idProceso],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($proceso,['route'=>['proceso.update',$proceso->idProceso],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'proceso.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<div class="container">
		<div class="navbar-header pull-left">
	  	<a class="navbar-brand"  >Tipos de Identificacion</a>
	</div>
	</div>

  <div class="form-container">
	<fieldset id="proceso-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoProceso', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoProceso',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la identificacion'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!! Form::label('nombreProceso', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreProceso',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la identificacion'])!!}
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($proceso))
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