@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Líneas de Producto</center></h3>@stop

@section('content')
  @include('alerts.request')

	@if(isset($lineaproducto))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($lineaproducto,['route'=>['lineaproducto.destroy',$lineaproducto->idLineaProducto],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($lineaproducto,['route'=>['lineaproducto.update',$lineaproducto->idLineaProducto],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'lineaproducto.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >
	<fieldset id="lineaproducto-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoLineaProducto', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoLineaProducto',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la Línea'])!!}
              {!! Form::hidden('idLineaProducto', null, array('id' => 'idLineaProducto')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!! Form::label('nombreLineaProducto', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreLineaProducto',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la Línea',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
        </div>
    </fieldset>
    <br>
	@if(isset($lineaproducto))
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