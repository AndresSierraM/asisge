@extends('layouts.vista')
@section('titulo')
	<h3 id="titulo">
		<center>Listas Generales</center>
	</h3>
@stop

@section('content')
@include('alerts.request')

	@if(isset($listaGeneral))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($listaGeneral,['route'=>['listageneral.destroy',$listaGeneral->idListaGeneral],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($listaGeneral,['route'=>['listageneral.update',$listaGeneral->idListaGeneral],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'listageneral.store','method'=>'POST'])!!}
	@endif
		<div id='form-section' >
			
				<fieldset id="listaGeneral-form-fieldset">	
					<div class="form-group" id='test'>
						{!!Form::label('codigoListaGeneral', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('codigoListaGeneral',null,['class'=>'form-control','placeholder'=>'Ingresa el código'])!!}
						      	{!!Form::hidden('idListaGeneral', null, array('id' => 'idListaGeneral'))!!}
							</div>
						</div>
					</div>
					<div class="form-group" id='test'>
						{!!Form::label('nombreListaGeneral', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-pencil-square-o"></i>
				              	</span>
								{!!Form::text('nombreListaGeneral',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
				    		</div>
				    	</div>
				    </div>
				    <div class="form-group" id='test'>
						{!!Form::label('tipoListaGeneral', 'Tipo', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-pencil-square-o"></i>
				              	</span>
				              	{!!Form::select('tipoListaGeneral',
            					array('EliminacionRiesgo'=>'Eliminaci&oacute;n de Riesgo',
            					'ControlAdministrativo'=>'Control Administrativo',
            					'ExamenMedico'=>'Examen M&eacute;dico',
            					'TareaAltoRiesgo'=>'Tarea de Alto Riesgo',
            					'Vacuna'=>'Vacuna',
            					'ElementoProteccion'=>'Elemento de Protecci&oacute;n Personal'), (isset($listaGeneral) ? $listaGeneral->tipoListaGeneral : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo"])!!}
							</div>
				    	</div>
				    </div>
				    <div class="form-group" id='test'>
						{!!Form::label('observacionListaGeneral', 'Observaciones', array('class' => 'col-sm-2 control-label'))!!}
						<div class="col-sm-10">
				            <div class="input-group">
				              	<span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('observacionListaGeneral',null,['class'=>'form-control','placeholder'=>'Ingrese las observavciones'])!!}
				            </div>
				    	</div>
				    </div>
					
				</fieldset>	
				@if(isset($listaGeneral))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}		
@stop