@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Documentos o Registros</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($documento))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($documento,['route'=>['documento.destroy',$documento->idDocumento],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($documento,['route'=>['documento.update',$documento->idDocumento],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'documento.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="documento-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoDocumento', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoDocumento',null,['class'=>'form-control','placeholder'=>'Ingresa el código del documento'])!!}
              {!!Form::hidden('idDocumento', null, array('id' => 'idDocumento')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!!Form::label('nombreDocumento', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreDocumento',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del documento'])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($documento))
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