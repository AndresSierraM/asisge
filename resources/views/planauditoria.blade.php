@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Plan de Auditor&iacute;a</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	{!!Html::script('js/planauditoria.js')!!}
	<script>
		var planAuditoriaAcompanante = '<?php echo (isset($planAuditoria) ? json_encode($planAuditoria->planAuditoriaAcompanantes) : "");?>';
		planAuditoriaAcompanante = (planAuditoriaAcompanante != '' ? JSON.parse(planAuditoriaAcompanante) : '');

		var planAuditoriaNotificado = '<?php echo (isset($planAuditoria) ? json_encode($planAuditoria->planAuditoriaNotificados) : "");?>';
		planAuditoriaNotificado = (planAuditoriaNotificado != '' ? JSON.parse(planAuditoriaNotificado) : '');

		var planAuditoriaAgenda = '<?php echo (isset($planAuditoria) ? json_encode($planAuditoria->planAuditoriaAgendas) : "");?>';
		planAuditoriaAgenda = (planAuditoriaAgenda != '' ? JSON.parse(planAuditoriaAgenda) : '');

		var valorAcompanante = [0,0];
		var valorNotificado = [0,0];
		var valorAgenda = [0,0,0,0,'0000-00-00','00:00','00:00',''];

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
		var idProceso = '<?php echo isset($idProceso) ? $idProceso : "";?>';
		var nombreProceso = '<?php echo isset($nombreProceso) ? $nombreProceso : "";?>';
		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
		var proceso = [JSON.parse(idProceso),JSON.parse(nombreProceso)];
		// var eventos1 = ['onclick','fechaDetalle(this.parentNode.id);'];
		// var eventos2 = ['onclick','horaDetalle(this.parentNode.id);'];

		$(document).ready(function(){

			acompanante = new Atributos('acompanante','contenedor_acompanante','acompanante_');
			acompanante.campos = ['idPlanAuditoriaAcompanante', 'Tercero_idAcompanante'];
			acompanante.etiqueta = ['input','select'];
			acompanante.tipo = ['hidden',''];
			acompanante.estilo = ['','width: 800px;height:35px;'];
			acompanante.clase = ['',''];
			acompanante.sololectura = [false,false];
			acompanante.completar = ['off','off'];
			acompanante.opciones = ['',tercero];
			acompanante.funciones  = ['',''];

			notificado = new Atributos('notificado','contenedor_notificado','notificado_');
			notificado.campos = ['idPlanAuditoriaNotificado', 'Tercero_idNotificado'];
			notificado.etiqueta = ['input','select'];
			notificado.tipo = ['hidden',''];
			notificado.estilo = ['','width: 800px;height:35px;'];
			notificado.clase = ['',''];
			notificado.sololectura = [false,false];
			notificado.completar = ['off','off'];
			notificado.opciones = ['',tercero];
			notificado.funciones  = ['',''];

			agenda = new Atributos('agenda','contenedor_agenda','agenda_');
			agenda.campos = ['idPlanAuditoriaAgenda', 'Proceso_idProceso','Tercero_Auditado','Tercero_Auditor','fechaPlanAuditoriaAgenda','horaInicioPlanAuditoriaAgenda','horaFinPlanAuditoriaAgenda','lugarPlanAuditoriaAgenda'];
			agenda.etiqueta = ['input','select','select','select','input','input','input','input'];
			agenda.tipo = ['hidden','','','','date','time','time','text'];
			agenda.estilo = ['','width: 150px;height:35px;','width: 190px;height:35px;','width: 190px;height:35px;','width: 150px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 150px;height:35px;'];
			agenda.clase = ['','','','','','','',''];
			agenda.sololectura = [false,false,false,false,false,false,false,false];
			agenda.completar = ['off','off','off','off','off','off','off','off'];
			agenda.opciones = ['',proceso,tercero,tercero,'','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"]; 
			agenda.funciones  = ['','','','','','','',quitacarac];

			for(var j=0, k = planAuditoriaAcompanante.length; j < k; j++)
			{
				acompanante.agregarCampos(JSON.stringify(planAuditoriaAcompanante[j]),'L');
			}

			for(var j=0, k = planAuditoriaNotificado.length; j < k; j++)
			{
				notificado.agregarCampos(JSON.stringify(planAuditoriaNotificado[j]),'L');
			}

			for(var j=0, k = planAuditoriaAgenda.length; j < k; j++)
			{
				agenda.agregarCampos(JSON.stringify(planAuditoriaAgenda[j]),'L');
			}

		});

		function fechaDetalle(registro)
		{
			var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
			$('#fechaPlanAuditoriaAgenda'+posicion).datetimepicker(({
				format: "YYYY-MM-DD"
			}));
		}
		function horaDetalleInicio(registro)
		{
			var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
			$('#horaInicioPlanAuditoriaAgenda'+posicion).datetimepicker(({
				format: "hh:mm"
			}));
		}
		function horaDetalleFin(registro)
		{
			var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
			$('#horaFinPlanAuditoriaAgenda'+posicion).datetimepicker(({
				format: "hh:mm"
			}));
		}
	</script>
	@if(isset($planAuditoria))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($planAuditoria,['route'=>['planauditoria.destroy',$planAuditoria->idPlanAuditoria],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($planAuditoria,['route'=>['planauditoria.update',$planAuditoria->idPlanAuditoria],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'planauditoria.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="planauditoria-form-fieldset">
				<div class="form-group required" id='test'>
					{!!Form::label('numeroPlanAuditoria', 'N&uacute;mero Auditor&iacute;a', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('numeroPlanAuditoria',null,["class" => "form-control", "placeholder" =>"Digite el n&uacute;mero"])!!}
							{!!Form::hidden('idPlanAuditoria', 0, array('id' => 'idPlanAuditoria'))!!}
							{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('fechaInicioPlanAuditoria', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('fechaInicioPlanAuditoria',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha de inicio'])!!}
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('fechaFinPlanAuditoria', 'Fecha Finalizaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('fechaFinPlanAuditoria',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha de finalizaci&oacute;n'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('organismoPlanAuditoria', 'Organismo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('organismoPlanAuditoria',null,['class'=>'form-control','placeholder'=>'Digitar el organismo'])!!}
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('Tercero_AuditorLider', 'Auditor L&iacute;der', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::select('Tercero_AuditorLider',
							$tercero, (isset($planAuditoria) ? $planAuditoria->Tercero_AuditorLider : 0),["class" => "form-control", "placeholder" =>"Seleccione el auditor l&iacute;der"])!!}
						</div>
					</div>
				</div>
				<!-- Nuevo Campo Centro de Costos  -->
		          <div class="form-group">
		                  {!!Form::label('CentroCosto_idCentroCosto', 'Centro de Costos', array('class' => 'col-sm-2 control-label'))!!}
		                <div class="col-sm-10" ">
		                  <div class="input-group">
		                    <span class="input-group-addon">
		                      <i class="fa fa-university" style="width: 14px;"></i>
		                    </span>
		                    {!!Form::select('CentroCosto_idCentroCosto',$centrocosto, (isset($planAuditoria) ? $planAuditoria->CentroCosto_idCentroCosto : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}                    
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
												<a data-toggle="collapse" data-parent="#accordion" href="#acompanante">Auditores Acompa&ntilde;antes</a>
											</h4>
										</div>
										<div id="acompanante" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="acompanante.agregarCampos(valorAcompanante,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 800px;display:inline-block;height:60px;">Auditores</div>
															<div id="contenedor_acompanante">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#notificado">Otros Notificados</a>
											</h4>
										</div>
										<div id="notificado" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="notificado.agregarCampos(valorNotificado,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 800px;display:inline-block;height:60px;">Notificados</div>
															<div id="contenedor_notificado">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#objetivo">Objetivos de la Auditor&iacute;a</a>
											</h4>
										</div>
										<div id="objetivo" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test' >
													<div class="col-sm-10" >
														<div class="input-group">
															{!!Form::textarea('objetivoPlanAuditoria',null,['class'=>'ckeditor','placeholder'=>'Ingrese los objetivos'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#alcance">Alcance de la Auditor&iacute;a</a>
											</h4>
										</div>
										<div id="alcance" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test' >
													<div class="col-sm-10" >
														<div class="input-group">
															{!!Form::textarea('alcancePlanAuditoria',null,['class'=>'ckeditor','placeholder'=>'Ingrese el alcance'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#criterio">Criterio de la Auditor&iacute;a</a>
											</h4>
										</div>
										<div id="criterio" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test' >
													<div class="col-sm-10" >
														<div class="input-group">
															{!!Form::textarea('criterioPlanAuditoria',null,['class'=>'ckeditor','placeholder'=>'Ingrese el criterio'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#agenda">Agenda de la Auditor&iacute;a</a>
											</h4>
										</div>
										<div id="agenda" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="agenda.agregarCampos(valorAgenda,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 150px;display:inline-block;height:60px;">Proceso</div>
															<div class="col-md-1 requiredMulti" style="width: 190px;display:inline-block;height:60px;">Auditado</div>
															<div class="col-md-1 requiredMulti" style="width: 190px;display:inline-block;height:60px;">Auditor</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha</div>
															<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Hora Inicio</div>
															<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Hora Fin</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Lugar</div>
															<div id="contenedor_agenda">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#recursos">Recursos Necesarios</a>
											</h4>
										</div>
										<div id="recursos" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test' >
													<div class="col-sm-10" >
														<div class="input-group">
															{!!Form::textarea('recursosPlanAuditoria',null,['class'=>'ckeditor','placeholder'=>'Ingrese los recursos'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#observaciones">Observaciones</a>
											</h4>
										</div>
										<div id="observaciones" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test' >
													<div class="col-sm-10" >
														<div class="input-group">
															{!!Form::textarea('observacionesPlanAuditoria',null,['class'=>'ckeditor','placeholder'=>'Ingrese las observaciones'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#aprobacion">Aprobaci&oacute;n Auditor&iacute;a</a>
											</h4>
										</div>
										<div id="aprobacion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::label('aprobacionPlanAuditoria', 'Aprobaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::checkbox('aprobacionPlanAuditoria',0,true)!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('fechaEntregaPlanAuditoria', 'Fecha Entrega', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaEntregaPlanAuditoria',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha de entrega'])!!}
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
						@if(isset($planAuditoria))
						@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
				   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
				  		@else
				   			{!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
				  		@endif
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

		$('#fechaInicioPlanAuditoria').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#fechaFinPlanAuditoria').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#fechaEntregaPlanAuditoria').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop