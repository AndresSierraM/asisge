@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Reporte ACPM</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	{!!Html::script('js/reporteacpm.js')!!}
	<script>
		var reporteACPMDetalle = '<?php echo (isset($reporteACPM) ? json_encode($reporteACPM->reporteACPMDetalles) : "");?>';
		reporteACPMDetalle = (reporteACPMDetalle != '' ? JSON.parse(reporteACPMDetalle) : '');


		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

		var idProceso = '<?php echo isset($idProceso) ? $idProceso : "";?>';
		var nombreProceso = '<?php echo isset($nombreProceso) ? $nombreProceso : "";?>';
		var proceso = [JSON.parse(idProceso),JSON.parse(nombreProceso)];

		var idModulo = '<?php echo isset($idModulo) ? $idModulo : "";?>';
		var nombreModulo = '<?php echo isset($nombreModulo) ? $nombreModulo : "";?>';
		var modulo = [JSON.parse(idModulo),JSON.parse(nombreModulo)];

		var eventos1 = ['onclick','fechaReporte(this.parentNode.id);'];
		var eventos2 = ['onclick','fechaEstimadaCierre(this.parentNode.id);','onblur','restarFechas(this.parentNode.id,"A");'];
		var eventos3 = ['onclick','fechaCierre(this.parentNode.id);','onblur','restarFechas(this.parentNode.id,"A");'];

		var valorT = ['Correctiva','Preventiva','Mejora'];
    	var opcionT = ['Correctiva','Preventiva','Mejora'];
    	var tipo = [valorT, opcionT];

		var valorDetalle = [0,0,'0000-00-00',0,0,'','','','',0,'',0,'0000-00-00','','0000-00-00',0,0];
		$(document).ready(function(){

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');


		    detalle.altura = '35px';
		    detalle.campoid = 'idReporteACPMDetalle';
	      	detalle.campoEliminacion = 'eliminarReporteACPMDetalle';

			detalle.campos = ['idReporteACPMDetalle', 'ordenReporteACPMDetalle', 'fechaReporteACPMDetalle', 'Proceso_idProceso', 'Modulo_idModulo', 'tipoReporteACPMDetalle', 'descripcionReporteACPMDetalle', 'analisisReporteACPMDetalle', 'correccionReporteACPMDetalle', 'Tercero_idResponsableCorrecion', 'planAccionReporteACPMDetalle', 'Tercero_idResponsablePlanAccion', 'fechaEstimadaCierreReporteACPMDetalle', 'estadoActualReporteACPMDetalle', 'fechaCierreReporteACPMDetalle', 'eficazReporteACPMDetalle','diasAtrasoReporteACPMDetalle'];
			detalle.etiqueta = ['input','input','input','select','select','select','input','input','input','select','input','select','input','input','input','checkbox','input'];
			detalle.tipo = ['hidden','text','text','','','','text','text','text','','text','','text','text','text','checkbox','text'];
			detalle.estilo = ['','width: 50px;height:35px;','width: 100px;height:35px;','width: 150px;height:35px;','width: 150px;height:35px;','width: 150px;height:35px;','width: 400px;height:35px;','width: 400px;height:35px;','width: 400px;height:35px;','width: 150px;height:35px;','width: 400px;height:35px;','width: 150px;height:35px;','width: 100px;height:35px;','width: 400px;height:35px;','width: 100px;height:35px;','width: 100px;height:30px;display:inline-block;','width: 100px;height:35px;'];
			detalle.clase = ['','','','','','','','','','','','','','','','',''];
			detalle.sololectura = [false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,true];
			detalle.completar = ['off','off','off','off','off','off','off','off','off','off','off','off','off','off','off','off','off'];
			detalle.opciones = ['','','',proceso,modulo,tipo,'','','',tercero,'',tercero,'','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			detalle.funciones  = ['','',eventos1,'','','',quitacarac,quitacarac,quitacarac,'',quitacarac,'',eventos2,quitacarac,eventos3,'',''];

			for(var j=0, k = reporteACPMDetalle.length; j < k; j++)
			{
				detalle.agregarCampos(JSON.stringify(reporteACPMDetalle[j]),'L');
				restarFechas(j,'B');
			}

		});

	</script>
	@if(isset($reporteACPM))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($reporteACPM,['route'=>['reporteacpm.destroy',$reporteACPM->idReporteACPM],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($reporteACPM,['route'=>['reporteacpm.update',$reporteACPM->idReporteACPM],'method'=>'PUT'])!!}
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
							{!!Form::hidden('idReporteACPM', null, array('id' => 'idReporteACPM'))!!}
							{!!Form::hidden('eliminarReporteACPMDetalle', null, array('id' => 'eliminarReporteACPMDetalle'))!!}
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
					{!!Form::label('descripcionReporteACPM', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('descripcionReporteACPM',null,['class'=>'form-control','placeholder'=>'Digite la descripci&oacute;n'])!!}
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Detalle de Acciones Correctivas, Preventivas y de Mejora</div>
							<div class="panel-body">
								
								<div class="form-group" id='test'>
									<div class="col-sm-12">
										<div class="row show-grid">
											<div style="overflow: auto; width: 100%; height: 600px;">
												<div style="width: 3350px; height: 300px; display: inline-block; ">
													<div class="col-md-1" style="width: 1040px;height:40px;">Reporte</div>
													<div class="col-md-1" style="width: 400px;height:40px;">An&aacute;lisis</div>
													<div class="col-md-1" style="width: 1200px;height:40px;">Acci&oacute;n a seguir</div>
													<div class="col-md-1" style="width: 400px;height:40px;">Seguimiento</div>
													<div class="col-md-1" style="width: 100px;height:40px;">Cierre</div>
													<div class="col-md-1" style="width: 200px;height:40px;">Verificaci&oacute;n</div>
													<div class="col-md-1" style="width: 40px;height: 70px;" onclick="detalle.agregarCampos(valorDetalle,'A')">
														<span class="glyphicon glyphicon-plus"></span>
													</div>
													<div class="col-md-1" style="width: 50px;display:inline-block;height:70px;">N°</div>
													<div class="col-md-1" style="width: 100px;display:inline-block;height:70px;">Fecha reporte</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:70px;">Proceso</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:70px;">Fuente</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:70px;">Tipo</div>
													<div class="col-md-1" style="width: 400px;display:inline-block;height:70px;">Descripci&oacute;n no conformidad</div>
													<div class="col-md-1" style="width: 400px;display:inline-block;height:70px;">An&aacute;lisis causa</div>
													<div class="col-md-1" style="width: 400px;display:inline-block;height:70px;">Correcci&oacute;n</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:70px;">Responsable</div>
													<div class="col-md-1" style="width: 400px;display:inline-block;height:70px;">Plan de acci&oacute;n</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:70px;">Responsable</div>
													<div class="col-md-1" style="width: 100px;display:inline-block;height:70px;">Fecha estimada cierre</div>
													<div class="col-md-1" style="width: 400px;display:inline-block;height:70px;">Estado Actual</div>
													<div class="col-md-1" style="width: 100px;display:inline-block;height:70px;">Fecha Cierre</div>
													<div class="col-md-1" style="width: 100px;display:inline-block;height:70px;">Eficaz</div>
													<div class="col-md-1" style="width: 100px;display:inline-block;height:70px;">D&iacute;as Atraso</div>
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
				<div class="form-group">
					<div class="col-sm-12">
                @if(isset($reporteACPM))
				   @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
				      {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
				    @else
				      {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
				    @endif
				  @else
				    {!!Form::submit('Guardar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
				  @endif

 				{!! Form::close() !!}
						</br></br></br></br>
					</div>
				</div>
			</fieldset>
		</div>
	{!!Form::close()!!}
	<script type="text/javascript">

		$('#fechaElaboracionReporteACPM').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop