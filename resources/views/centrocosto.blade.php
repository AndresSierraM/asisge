@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Centro de Costo</center></h3>@stop

@section('content')
  @include('alerts.request')

	@if(isset($centrocosto))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($centrocosto,['route'=>['centrocosto.destroy',$centrocosto->idCentroCosto],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($centrocosto,['route'=>['centrocosto.update',$centrocosto->idCentroCosto],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'centrocosto.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >
	<fieldset id="centrocosto-form-fieldset">	
		<div class="form-group required" id='test'>
          {!! Form::label('codigoCentroCosto', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoCentroCosto',null,['class'=>'form-control','placeholder'=>'Ingresa el código del Centro de Costo'])!!}
              {!! Form::hidden('idCentroCosto', null, array('id' => 'idCentroCosto')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group required" id='test'>
          {!! Form::label('nombreCentroCosto', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreCentroCosto',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del Centro de Costo',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
        </div>
    </fieldset>
    <br>
	@if(isset($centrocosto))
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