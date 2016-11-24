@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Encuesta</center></h3>@stop

@section('content')
  <!-- @include('alerts.request') -->

	@if(isset($encuesta))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($encuesta,['route'=>['encuesta.destroy',$encuesta->idEncuesta],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($encuesta,['route'=>['encuesta.update',$encuesta->idEncuesta],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'encuesta.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="encuesta-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('tituloEncuesta', 'Título', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('tituloEncuesta',null,['class'=>'form-control','placeholder'=>'Ingrese el Título de la Encuesta'])!!}
              {!!Form::hidden('idEncuesta', null, array('id' => 'idEncuesta')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!!Form::label('descripcionEncuesta', 'Descripción', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				      {!!Form::textarea('descripcionEncuesta',null,['class'=>'ckeditor','placeholder'=>'Ingresa la descripción de la Encuesta'])!!}
            </div>
          </div>
    </fieldset>


	@if(isset($encuesta))
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

<script>
    CKEDITOR.replace(('descripcionEncuesta'), {
        fullPage: true,
        allowedContent: true
      }); 
</script>

@stop