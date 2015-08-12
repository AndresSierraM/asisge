@extends('layouts.principal')

@section('content')
@include('alerts.request')

	@if(isset($usuario))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($usuario,['route'=>['usuario.destroy',$usuario->idUsuario],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($usuario,['route'=>['usuario.update',$usuario->idUsuario],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'usuario.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<div class="container">
		<div class="navbar-header pull-left">
	  	<a class="navbar-brand"  >Usuarios</a>
	</div>
	</div>

  <div class="form-container">
	<fieldset id="usuario-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('loginUsuario', 'Usuario', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-user"></i>
              </span>
              {!!Form::text('loginUsuario',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de usuario'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('nombreUsuario', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o"></i>
              </span>
            {!!Form::text('nombreUsuario',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre completo'])!!}
            </div>
          </div>
        </div>
		
		    <div class="form-group" id='test'>
          {!! Form::label('correoUsuario', 'Correo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-at "></i>
              </span>
    				{!!Form::text('correoUsuario',null,['class'=>'form-control','placeholder'=>'Ingresa el correo electronico'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!! Form::label('claveUsuario', 'Contrase&ntilde;a', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-key "></i>
              </span>
            {!!Form::password('claveUsuario',null,['class'=>'form-control','placeholder'=>'Ingresa la contrase&ntilde;a'])!!}
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($usuario))
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