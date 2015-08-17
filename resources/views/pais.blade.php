@extends('layouts.vista')

@section('content')
@include('alerts.request')
	@if(isset($pais))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($pais,['route'=>['pais.destroy',$pais->idPais],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($pais,['route'=>['pais.update',$pais->idPais],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'pais.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<div class="container">
		<div class="navbar-header pull-left">
	  	<a class="navbar-brand"  >Paises</a>
	</div>
	</div>

  <div class="form-container">
	<fieldset id="pais-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoPais', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoPais',null,['class'=>'form-control','placeholder'=>'Ingresa el código del país'])!!}
              {!!Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!!Form::label('nombrePais', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombrePais',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del país'])!!}
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($pais))
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