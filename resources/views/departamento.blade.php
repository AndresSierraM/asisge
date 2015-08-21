@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Departamentos</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($departamento))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($departamento,['route'=>['departamento.destroy',$departamento->idDepartamento],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($departamento,['route'=>['departamento.update',$departamento->idDepartamento],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'departamento.store','method'=>'POST'])!!}
	@endif
		<div id='form-section' >
			
				<fieldset id="departamento-form-fieldset">	
					<div class="form-group" id='test'>
						{!!Form::label('codigoDepartamento', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('codigoDepartamento',null,['class'=>'form-control','placeholder'=>'Ingresa el código del departamento'])!!}
						      	{!!Form::hidden('idDepartamento', null, array('id' => 'idDepartamento'))!!}
							</div>
						</div>
					</div>
					<div class="form-group" id='test'>
						{!!Form::label('nombreDepartamento', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-pencil-square-o"></i>
				              	</span>
								{!!Form::text('nombreDepartamento',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del departamento'])!!}
				    		</div>
				    	</div>
				    </div>	
					<div class="form-group" id='test'>
						{!!Form::label('Pais_idPais', 'Pais', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-flag"></i>
				              	</span>
								{!!Form::select('Pais_idPais',$pais, (isset($departamento) ? $departamento->Pais_idPais : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Pais"])!!}
							</div>
						</div>
					</div>
				</fieldset>	
				@if(isset($departamento))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}		
@stop