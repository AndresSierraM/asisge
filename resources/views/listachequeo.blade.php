@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Lista de Chequeo</center>
	</h3>
@stop

@section('content')
	{!!Html::script('js/listachequeo.js')!!}
	@include('alerts.request')
	<script>
		var listaChequeoDetalle = '<?php echo (isset($preguntaListaChequeo) ? json_encode($preguntaListaChequeo) : "");?>';
		listaChequeoDetalle = (listaChequeoDetalle != '' ? JSON.parse(listaChequeoDetalle) : '');

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
		var valorDetalle = [0,0,'','',0,'',0,'',''];
		$(document).ready(function(){

			buscarProceso();

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');
			detalle.campos = ['idListaChequeoDetalle', 'PreguntaListaChequeo_idPreguntaListaChequeo','ordenPreguntaListaChequeo','descripcionPreguntaListaChequeo','Tercero_idTercero','respuestaListaChequeoDetalle','conformeListaChequeoDetalle','hallazgoListaChequeoDetalle','observacionListaChequeoDetalle'];
			detalle.altura = '67px;'; 
			detalle.etiqueta = ['input','input','input','textarea','select','input','checkbox','input','input'];
			detalle.tipo = ['hidden','hidden','text','textarea','','text','checkbox','text','text'];
			detalle.estilo = ['','','width: 50px;height:60px','vertical-align:top; width: 400px;  height:60px;','width: 150px;height:60px;','width: 200px;height:60px;','width: 90px;height:35px;display:inline-block','width: 120px;height:60px;','width: 210px;height:60px;'];
			detalle.clase = ['','','','','','','','',''];
			detalle.sololectura = [false,false,true,true,false,false,true,false,false];
			detalle.completar = ['off','off','off','off','off','off','off','off'];
			detalle.opciones = ['','','','',tercero,'','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			detalle.funciones  = ['','','',quitacarac,'',quitacarac,'',quitacarac,quitacarac];

			for(var j=0, k = listaChequeoDetalle.length; j < k; j++)
			{
				detalle.agregarCampos(JSON.stringify(listaChequeoDetalle[j]),'L');
				
			}

		});

		
	</script>
	@if(isset($listaChequeo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($listaChequeo,['route'=>['listachequeo.destroy',$listaChequeo->idListaChequeo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($listaChequeo,['route'=>['listachequeo.update',$listaChequeo->idListaChequeo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'listachequeo.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="planauditoria-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('numeroListaChequeo', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('numeroListaChequeo',null,["class" => "form-control", "placeholder" =>"Digite el n&uacute;mero"])!!}
							{!!Form::hidden('idListaChequeo', null, array('id' => 'idListaChequeo'))!!}
							{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('fechaElaboracionListaChequeo', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('fechaElaboracionListaChequeo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha de inicio'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('PlanAuditoria_idPlanAuditoria', 'Plan de Auditor&iacute;a', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::select('PlanAuditoria_idPlanAuditoria',
							$planAuditoria, (isset($listaChequeo) ? $listaChequeo->PlanAuditoria_idPlanAuditoria : 0),["class" => "form-control", "onchange"=>"buscarProceso()", "placeholder" =>"Seleccione el plan de auditor&iacute;a"])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Proceso_idProceso', 'Proceso', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::select('Proceso_idProceso',
							array(), null,["class" => "form-control", "placeholder" =>"Seleccione el plan de proceso"])!!}
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
												<a data-toggle="collapse" data-parent="#accordion" href="#detalle">Preguntas</a>
											</h4>
										</div>
										<div id="detalle" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="detalle.agregarCampos(valorDetalle,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 50px;display:inline-block;height:60px;">N°</div>
															<div class="col-md-1" style="width: 400px;display:inline-block;height:60px;">Pregunta</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">A qui&eacute;n</div>
															<div class="col-md-1" style="width: 200px;display:inline-block;height:60px;">Respuesta</div>
															<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Conforme</div>
															<div class="col-md-1" style="width: 120px;display:inline-block;height:60px;">Hallazgo</div>
															<div class="col-md-1" style="width: 210px;display:inline-block;height:60px;">Observaci&oacute;n</div>
															<div id="contenedor_detalle">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#observaciones">Observaciones</a>
											</h4>
										</div>
										<div id="observaciones" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test' >
													<div class="col-sm-10" >
														<div class="input-group">
															{!!Form::textarea('observacionesListaChequeo',null,['class'=>'ckeditor','placeholder'=>'Ingrese las observaciones'])!!}
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
						@if(isset($listaChequeo))
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

		$('#fechaElaboracionListaChequeo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop