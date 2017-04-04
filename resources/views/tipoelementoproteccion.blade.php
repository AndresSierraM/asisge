@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Tipos de Elementos </br> Protección Personal</center></h3>@stop

@section('content')
@include('alerts.request')
	@if(isset($tipoelementoproteccion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoelementoproteccion,['route'=>['tipoelementoproteccion.destroy',$tipoelementoproteccion->idTipoElementoProteccion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoelementoproteccion,['route'=>['tipoelementoproteccion.update',$tipoelementoproteccion->idTipoElementoProteccion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipoelementoproteccion.store','method'=>'POST'])!!}
	@endif


<div id='form-section'>

	<fieldset id="tipoelementoproteccion-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoTipoElementoProteccion', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoTipoElementoProteccion',null,['class'=>'form-control','placeholder'=>'Ingresa el C&oacute;digo'])!!}
              {!!Form::hidden('idTipoElementoProteccion', null, array('id' => 'idTipoElementoProteccion')) !!}
            </div>
          </div>
        </div>


      <div class="form-group" id='test'>
          {!!Form::label('nombreTipoElementoProteccion', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
        {!!Form::text('nombreTipoElementoProteccion',null,['class'=>'form-control','placeholder'=>'Ingresa la descripci&oacute;n',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
  

    
    <div class="form-group" id='test'>
          {!!Form::label('observacionTipoElementoProteccion', 'Notas', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
        {!!Form::textarea('observacionTipoElementoProteccion',null,['class'=>'form-control','style'=>'height:100px','placeholder'=>'',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>

    </fieldset>
	@if(isset($tipoelementoproteccion))
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