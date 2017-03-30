@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Líneas de Producto</center></h3>@stop

@section('content')
  @include('alerts.request')

	@if(isset($sublineaproducto))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($sublineaproducto,['route'=>['sublineaproducto.destroy',$sublineaproducto->idSublineaProducto],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($sublineaproducto,['route'=>['sublineaproducto.update',$sublineaproducto->idSublineaProducto],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'sublineaproducto.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >
	<fieldset id="sublineaproducto-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoSublineaProducto', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoSublineaProducto',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la Sublinea'])!!}
              {!! Form::hidden('idSublineaProducto', null, array('id' => 'idSublineaProducto')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!! Form::label('nombreSublineaProducto', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreSublineaProducto',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la Sublinea',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
        </div>
    </fieldset>
    <br>
	@if(isset($sublineaproducto))
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