@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>DocumentoSoportes o Registros</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($documentosoporte))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($documentosoporte,['route'=>['documentosoporte.destroy',$documentosoporte->idDocumentoSoporte],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($documentosoporte,['route'=>['documentosoporte.update',$documentosoporte->idDocumentoSoporte],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'documentosoporte.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="documentosoporte-form-fieldset">	
		<div class="form-group required" id='test'>
          {!!Form::label('codigoDocumentoSoporte', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoDocumentoSoporte',null,['class'=>'form-control','placeholder'=>'Ingresa el código del documentosoporte'])!!}
              {!!Form::hidden('idDocumentoSoporte', null, array('id' => 'idDocumentoSoporte')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group required" id='test'>
          {!!Form::label('nombreDocumentoSoporte', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreDocumentoSoporte',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del documentosoporte',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($documentosoporte))
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