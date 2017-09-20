@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Ciudades</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($ciudad))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($ciudad,['route'=>['ciudad.destroy',$ciudad->idCiudad],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($ciudad,['route'=>['ciudad.update',$ciudad->idCiudad],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'ciudad.store','method'=>'POST'])!!}
	@endif
		<div id='form-section' >
				<fieldset id="ciudad-form-fieldset">	
					<div class="form-group required" id='test'>
						{!!Form::label('codigoCiudad', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('codigoCiudad',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la ciudad'])!!}
						      	{!!Form::hidden('idCiudad', null, array('id' => 'idCiudad'))!!}
							</div>
						</div>
					</div>
					<div class="form-group required" id='test'>
						{!!Form::label('nombreCiudad', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-pencil-square-o"></i>
				              	</span>
								{!!Form::text('nombreCiudad',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la ciudad'])!!}
				    		</div>
				    	</div>
				    </div>	
					<div class="form-group required" id='test'>
						{!!Form::label('Departamento_idDepartamento', 'Departamento', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-flag"></i>
				              	</span>
								{!!Form::select('Departamento_idDepartamento',$departamento, (isset($ciudad) ? $ciudad->Departamento_idDepartamento : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el departamento"])!!}
							</div>
						</div>
					</div>
				</fieldset>	
				@if(isset($ciudad))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}		
@stop