@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Usuarios</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($usuario))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($usuario,['route'=>['users.destroy',$usuario->id],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($usuario,['route'=>['users.update',$usuario->id],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'users.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="usuario-form-fieldset">	
		<div class="form-group required" id='test'>
          {!! Form::label('name', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-user" style="width: 14px;"></i>
              </span>
              {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del usuario'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>

		
		    <div class="form-group required" id='test'>
          {!! Form::label('email', 'Correo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-at " style="width: 14px;"></i>
              </span>
    				{!!Form::text('email',null,['class'=>'form-control','placeholder'=>'Ingresa el correo electronico'])!!}
            </div>
          </div>
        </div>

        <div class="form-group required" id='test'>
          {!! Form::label('password', 'Contrase&ntilde;a', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-key " style="width: 14px;"></i>
              </span>
            {!!Form::password('password',array('class'=>'form-control','placeholder'=>'Ingresa la contrase&ntilde;a'))!!}
            </div>
          </div>
        </div>

        <div class="form-group required" id='test' style="display:inline-block;">
          {!! Form::label('password_confirmation', 'Confirmar Contrase&ntilde;a', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-key " style="width: 14px;"></i>
                </span>
              {!!Form::password('password_confirmation',array('class'=>'form-control','placeholder'=>'Ingresa de nuevo la contrase&ntilde;a'))!!}
              </div>
            </div>
           <div class="form-group required" style="display:inline-block;">
              {!!Form::label('Tercero_idTercero', 'Tercero Asociado', array('class' => 'col-md-2 control-label'))!!}
              <div class="col-sm-10" >
                <div class="input-group" >
                          <span class="input-group-addon">
                            <i class="fa fa-bank" style="width: 14px;"></i>
                          </span>
                  {!!Form::select('Tercero_idTercero',$tercero, (isset($usuario) ? $usuario->Tercero_idTercero : 0),["class" => "chosen-select form-control"])!!}
                </div>
              </div>
              <div class="form-group " style="display:inline-none;">
                {!!Form::label('Rol_idRol', 'Rol', array('class' => 'col-md-2 control-label'))!!}
                <div class="col-sm-10" >
                  <div class="input-group" >
                    <span class="input-group-addon">
                      <i class="fa fa-credit-card" style="width: 14px;" ></i>
                    </span>
                    {!!Form::select('Rol_idRol',$rol, (isset($usuario) ? $usuario->Rol_idRol : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Rol"])!!}
                  </div>
                </div>
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
@stop