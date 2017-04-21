@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Tipos de Calidad</center></h3>@stop

@section('content')
  @include('alerts.request')

	@if(isset($tipocalidad))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipocalidad,['route'=>['tipocalidad.destroy',$tipocalidad->idTipoCalidad],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipocalidad,['route'=>['tipocalidad.update',$tipocalidad->idTipoCalidad],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipocalidad.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >
	<fieldset id="tipocalidad-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoTipoCalidad', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoTipoCalidad',null,['class'=>'form-control','placeholder'=>'Ingresa el código del Tipo de Calidad'])!!}
              {!! Form::hidden('idTipoCalidad', null, array('id' => 'idTipoCalidad')) !!}
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
      {!! Form::label('nombreTipoCalidad', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o "></i>
          </span>
		        {!!Form::text('nombreTipoCalidad',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del Tipo de Calidad',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
        </div>
      </div>
    </div>

    <div class="form-group" id='test'>
      {!!Form::label('noConformeTipoCalidad', 'Producto No Conforme', array('class' => 'col-sm-2 control-label'))!!}
      <div class="col-sm-10" >
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar" ></i>
          </span>
          {!!Form::checkbox('noConformeTipoCalidad',(isset($tipocalidad) ? $tipocalidad->noConformeTipoCalidad : 0), null, ['style'=>'width:30px;height: 30px;'])!!}
        </div>
      </div>
    </div>

    <div class="form-group" id='test'>
      {!!Form::label('alertaCorreoTipoCalidad', 'Enviar alerta por correo electrónico', array('class' => 'col-sm-2 control-label'))!!}
      <div class="col-sm-10" >
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar" ></i>
          </span>
          {!!Form::checkbox('alertaCorreoTipoCalidad',(isset($tipocalidad) ? $tipocalidad->alertaCorreoTipoCalidad : 0), null, ['style'=>'width:30px;height: 30px;'])!!}
        </div>
      </div>
    </div>

    <div class="form-group" id='test'>
      {!! Form::label('paraTipoCalidad', 'Para', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o "></i>
          </span>
            {!!Form::text('paraTipoCalidad',null,['class'=>'form-control','placeholder'=>'Ingresa los destinatarios de correo'])!!}
        </div>
      </div>
    </div>

    <div class="form-group" id='test'>
      {!! Form::label('asuntoTipoCalidad', 'Asunto', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o "></i>
          </span>
            {!!Form::text('asuntoTipoCalidad',null,['class'=>'form-control','placeholder'=>'Ingresa el Asunto del correo electrónico',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
        </div>
      </div>
    </div>

    <div class="form-group" id='test'>
      {!!Form::label('mensajeTipoCalidad', 'Mensaje de Correo', array('class' => 'col-sm-2 control-label'))!!}
      <div class="col-sm-10" >
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar" ></i>
          </span>
          {!!Form::textarea('mensajeTipoCalidad',null,['class'=>'ckeditor','placeholder'=>'Mensaje de Correo'])!!}
        </div>
      </div>
    </div>

    </fieldset>
    <br>
	@if(isset($tipocalidad))
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