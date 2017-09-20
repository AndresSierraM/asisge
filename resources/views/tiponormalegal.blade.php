@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Normas Legales</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($tiponormalegal))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tiponormalegal,['route'=>['tiponormalegal.destroy',$tiponormalegal->idTipoNormaLegal],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tiponormalegal,['route'=>['tiponormalegal.update',$tiponormalegal->idTipoNormaLegal],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tiponormalegal.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="tiponormalegal-form-fieldset">	
		<div class="form-group required" id='test'>
          {!!Form::label('codigoTipoNormaLegal', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoTipoNormaLegal',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la Norma'])!!}
              {!!Form::hidden('idTipoNormaLegal', null, array('id' => 'idTipoNormaLegal')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group required" id='test'>
          {!!Form::label('nombreTipoNormaLegal', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreTipoNormaLegal',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la Norma'])!!}
            </div>
          </div>
    </fieldset>
	@if(isset($tiponormalegal))
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