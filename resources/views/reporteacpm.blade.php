@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Lista de Chequeo</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	<script>
		var listaChequeoDetalle = '<?php echo (isset($preguntaListaChequeo) ? json_encode($preguntaListaChequeo) : "");?>';
		listaChequeoDetalle = (listaChequeoDetalle != '' ? JSON.parse(listaChequeoDetalle) : '');

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

		var valorDetalle = [0,0,'','',0,'',0,'',''];
		$(document).ready(function(){

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');
			detalle.campos = ['idListaChequeoDetalle', 'PreguntaListaChequeo_idPreguntaListaChequeo','ordenPreguntaListaChequeo','descripcionPreguntaListaChequeo','Tercero_idTercero','respuestaListaChequeoDetalle','conformeListaChequeoDetalle','hallazgoListaChequeoDetalle','observacionListaChequeoDetalle'];
			detalle.etiqueta = ['input','input','input','input','select','input','checkbox','input','input'];
			detalle.tipo = ['hidden','hidden','text','text','','text','checkbox','text','text'];
			detalle.estilo = ['','','width: 50px;height:35px;','width: 250px;height:35px;','width: 150px;height:35px;','width: 200px;height:35px;','width: 90px;height:30px;display:inline-block','width: 120px;height:35px;','width: 150px;height:35px;'];
			detalle.clase = ['','','','','','','','',''];
			detalle.sololectura = [false,false,true,true,false,false,false,false,false];
			detalle.completar = ['off','off','off','off','off','off','off','off'];
			detalle.opciones = ['','','','',tercero,'','','','',''];
			detalle.funciones  = ['','','','','','','','',''];

			for(var j=0, k = listaChequeoDetalle.length; j < k; j++)
			{
				detalle.agregarCampos(JSON.stringify(listaChequeoDetalle[j]),'L');
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
	@if(isset($listaChequeo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($listaChequeo,['route'=>['reporteacpm.destroy',$listaChequeo->idListaChequeo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($listaChequeo,['route'=>['reporteacpm.update',$listaChequeo->idListaChequeo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'reporteacpm.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="reporteacpm-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('numeroReporteACPM', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('numeroReporteACPM',null,["class" => "form-control", "placeholder" =>"Digite el n&uacute;mero"])!!}
							{!!Form::hidden('idReporteACPM', 0, array('id' => 'idListaChequeo'))!!}
							{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('fechaElaboracionReporteACPM', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('fechaElaboracionReporteACPM',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha de inicio'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('descripcionReporteACPM', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('descripcionReporteACPM',null,['class'=>'form-control','placeholder'=>'Digite la descripci&oacute,n'])!!}
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
															<div class="col-md-1" style="width: 250px;display:inline-block;height:60px;">Fecha Reporte</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Proceso Implicado</div>
															<div class="col-md-1" style="width: 200px;display:inline-block;height:60px;">Fuente</div>
															<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Tipo</div>
															<div class="col-md-1" style="width: 120px;display:inline-block;height:60px;">Descripci&oacute;n</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">An&aacute;lisis de Causa</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Correcci&oacute;n</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Responsable</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Plan de Acci&oacute;n</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Responsable</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha Estimada Cierre</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Estado Actual</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha Cierre</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">¿Eficaz?</div>
															<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">D&iacute;s de Atraso</div>
															<div id="contenedor_detalle">
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