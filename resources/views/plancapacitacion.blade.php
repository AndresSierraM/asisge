@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Plan Capacitaci&oacute;n</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	{!!Html::script('js/plancapacitacion.js')!!}
	<script>
		var planCapacitacionTema = '<?php echo (isset($planCapacitacion) ? json_encode($planCapacitacion->planCapacitacionTemas) : "");?>';
		planCapacitacionTema = (planCapacitacionTema != '' ? JSON.parse(planCapacitacionTema) : '');

		var valor = [0,'',0,'0000-00-00','00:00'];

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
		// var eventos1 = ['onclick','fechaDetalle(this.parentNode.id);'];
		// var eventos2 = ['onclick','horaDetalle(this.parentNode.id);'];

		$(document).ready(function(){

			tema = new Atributos('tema','contenedor_tema','tema_');
			tema.campos = ['idPlanCapacitacionTema', 'nombrePlanCapacitacionTema', 'Tercero_idCapacitador', 'fechaPlanCapacitacionTema', 'horaPlanCapacitacionTema'];
			tema.etiqueta = ['input','input','select','input','input'];
			tema.tipo = ['hidden','text','','date','time'];
			tema.estilo = ['','width: 300px;height:35px;','width: 300px;height:35px;','width: 140px;height:35px;','width: 120px;height:35px;'];
			tema.clase = ['','','','',''];
			tema.sololectura = [false,false,false,false,false];
			tema.completar = ['off','off','off','off','off'];
			tema.opciones = ['','',tercero,'',''];
			tema.funciones  = ['','','','',''];

			for(var j=0, k = planCapacitacionTema.length; j < k; j++)
			{
				tema.agregarCampos(JSON.stringify(planCapacitacionTema[j]),'L');
			}

		});

		// function fechaDetalle(registro)
		// {
		// 	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
		// 	$('#fechaPlanCapacitacionTema'+posicion).datetimepicker(({
		// 		format: "YYYY-MM-DD"
		// 	}));
		// }
		// function horaDetalle(registro)
		// {
		// 	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
		// 	$('#horaPlanCapacitacionTema'+posicion).datetimepicker(({
		// 		format: "hh:mm"
		// 	}));
		// }
	</script>

	

	@if(isset($planCapacitacion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($planCapacitacion,['route'=>['plancapacitacion.destroy',$planCapacitacion->idPlanCapacitacion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($planCapacitacion,['route'=>['plancapacitacion.update',$planCapacitacion->idPlanCapacitacion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'plancapacitacion.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="plancapacitacion-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('tipoPlanCapacitacion', 'Tipo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::select('tipoPlanCapacitacion',
							array('INDUCCION'=>'Inducci&oacute;n', 'REINDUCCION'=>'Reinducci&oacute;n','GENERAL'=>'General'), (isset($planCapacitacion) ? $planCapacitacion->tipoPlanCapacitacion : 0),["class" => "form-control", "placeholder" =>"Seleccione el tipo"])!!}
							{!!Form::hidden('idPlanCapacitacion', 0, array('id' => 'idPlanCapacitacion'))!!}
							{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombrePlanCapacitacion', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombrePlanCapacitacion',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::select('Tercero_idResponsable',
							$tercero, (isset($planCapacitacion) ? $planCapacitacion->Tercero_idResponsable : 0),["class" => "form-control", "placeholder" =>"Seleccione el responsable"])!!}
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Detalles</div>
							<div class="panel-body">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#objetivo">Objetivos</a>
											</h4>
										</div>
										<div id="objetivo" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test' style="width:600px; display: inline; " >
													<div class="col-sm-10" style="width: 100%">
														<div class="input-group">
															{!!Form::textarea('objetivoPlanCapacitacion',null,['class'=>'ckeditor','placeholder'=>'Ingresa los objetivos','style'=>'width:300px;'])!!}
														</div>
													</div>
												</div>
			
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#personal">Personal Involucrado</a>
											</h4>
										</div>
										<div id="personal" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('personalInvolucradoPlanCapacitacion',null,['class'=>'ckeditor','placeholder'=>'Ingresa los objetivos'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#programacion">Programaci&oacute;n</a>
											</h4>
										</div>
										<div id="programacion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::label('fechaInicioPlanCapacitacion', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaInicioPlanCapacitacion',date('Y-m-d'),['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('fechaFinPlanCapacitacion', 'Fecha Fin', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaFinPlanCapacitacion',date('Y-m-d'),['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#metodo">M&eacute;todo de Eficacia</a>
											</h4>
										</div>
										<div id="metodo" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('metodoEficaciaPlanCapacitacion',null,['class'=>'ckeditor','placeholder'=>'Ingresa el m&eacute;todo de eficacia'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default" style="overflow:auto;">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#tema">Temas</a>
											</h4>
										</div>
										<div id="tema" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="tema.agregarCampos(valor,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Descripci&oacute;n</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Capacitador</div>
															<div class="col-md-1" style="width: 140px;display:inline-block;height:60px;">Fecha</div>
															<div class="col-md-1" style="width: 120px;display:inline-block;height:60px;">Hora</div>
															<div id="contenedor_tema">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($planCapacitacion))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
						</br></br></br></br>
					</div>
				</div>
			</fieldset>
		</div>	
	{!!Form::close()!!}
	<script type="text/javascript">

		$('#fechaInicioPlanCapacitacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#fechaFinPlanCapacitacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop