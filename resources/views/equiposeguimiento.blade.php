@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Equipos de seguimiento y medici&#243;n
	</h3>
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/equiposeguimiento.js')!!}
<script>

 	// Validacion para los 
 	var CalificarCapacidadInicial = ['onchange','ValidarCapacidad(this.id,"Inicial");']
	var CalificarCapacidadFinal = ['onchange','ValidarCapacidad(this.id,"Final");']
	// Validacion para los rangos 
	var CalificarRangoInicial = ['onchange','ValidarRangos(this.id,"Inicial");']
	var CalificarRangoFinal = ['onchange','ValidarRangos(this.id,"Final");']

	// Se recibe la consulta de la multigistro para que muestre los datos de los campos
	 var EquipoSeguimientoDetalle = '<?php echo (isset($EquipoSeguimientoDetalleE) ? json_encode($EquipoSeguimientoDetalleE) : "");?>';
	EquipoSeguimientoDetalle = (EquipoSeguimientoDetalle != '' ? JSON.parse(EquipoSeguimientoDetalle) : '');

	// Se reciben el id de Frecuencia medeicion  y nombre  para enviarlo al campo tipo select de Frecuencia Calibracion
	var idFrecuenciaMedicion = '<?php echo isset($idFrecuenciaMedicion) ? $idFrecuenciaMedicion : "";?>';
	var nombreFrecuenciaMedicion = '<?php echo isset($nombreFrecuenciaMedicion) ? $nombreFrecuenciaMedicion : "";?>';

	var FrecuenciaCalibracion = [JSON.parse(idFrecuenciaMedicion),JSON.parse(nombreFrecuenciaMedicion)];





	// ---------
	// Variable para el select FRECUENCIA
	ValorTipo = Array("Patron","Planta");
	NombreTipo = Array ("Patrón","Planta");

	TipoSeguimiento = [ValorTipo,NombreTipo];
	



		var valor = [0,0,'','','','','','','','','','','','',''];

    	$(document).ready(function(){

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');
			detalle.altura = '36px;';
			detalle.campoid = 'idEquipoSeguimientoDetalle';
			detalle.campoEliminacion = 'eliminarseguimiento';
			detalle.botonEliminacion = true;
			detalle.campos = ['idEquipoSeguimientoDetalle','EquipoSeguimiento_idEquipoSeguimiento', 'identificacionEquipoSeguimientoDetalle', 'tipoEquipoSeguimientoDetalle', 'FrecuenciaMedicion_idCalibracion', 'fechaInicioCalibracionEquipoSeguimientoDetalle', 'FrecuenciaMedicion_idVerificacion', 'fechaInicioVerificacionEquipoSeguimientoDetalle', 'unidadMedidaCalibracionEquipoSeguimientoDetalle', 'rangoInicialCalibracionEquipoSeguimientoDetalle', 'rangoFinalCalibracionEquipoSeguimientoDetalle', 'escalaCalibracionEquipoSeguimientoDetalle', 'capacidadInicialCalibracionEquipoSeguimientoDetalle', 'capacidadFinalCalibracionEquipoSeguimientoDetalle', 'utilizacionCalibracionEquipoSeguimientoDetalle','toleranciaCalibracionEquipoSeguimientoDetalle','errorPermitidoCalibracionEquipoSeguimientoDetalle'];
			detalle.etiqueta = ['input','input','textarea','select','select','input','select','input','input','input','input','input','input','input','textarea','input','input'];
			detalle.tipo = ['hidden','hidden','textarea','','','date','','date','text','number','number','text','number','number','textarea','text','text'];
			detalle.estilo = ['','','vertical-align:top; width: 220px;height:35px;','width: 150px;height:35px;','width: 220px;height:35px;','width: 220px;height:35px;','width: 220px;height:35px;','width: 220px;height:35px;','width: 300px;height:35px;','width: 90px;height:35px;','width: 90px;height:35px;','width: 150px;height:35px;','width: 90px;height:35px;','width: 90px;height:35px;','vertical-align:top; width: 300px;height:35px;','width: 220px;height:35px;','width: 220px;height:35px;'];
			detalle.clase = ['','','','','','','','','','','','','','','','',''];
			detalle.sololectura = [false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false];
			detalle.opciones = ['','','',TipoSeguimiento,FrecuenciaCalibracion,'',FrecuenciaCalibracion,'','','','','','','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			detalle.funciones = ['','',quitacarac,'','','','','',quitacarac,CalificarRangoInicial,CalificarRangoFinal,'',CalificarCapacidadInicial,CalificarCapacidadFinal,quitacarac,''];


			// For para llenar los registros al momento de modificar el registro
			for(var j=0, k = EquipoSeguimientoDetalle.length; j < k; j++)
			{				
				detalle.agregarCampos(JSON.stringify(EquipoSeguimientoDetalle[j]),'L');				
			}

		});
	</script>
	@if(isset($equiposeguimiento))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($equiposeguimiento,['route'=>['equiposeguimiento.destroy',$equiposeguimiento->idEquipoSeguimiento],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($equiposeguimiento,['route'=>['equiposeguimiento.update',$equiposeguimiento->idEquipoSeguimiento],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'equiposeguimiento.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="equiposeguimiento-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaEquipoSeguimiento', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaEquipoSeguimiento',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idEquipoSeguimiento', 0, array('id' => 'idEquipoSeguimiento'))!!}
					      	 {!!Form::hidden('eliminarseguimiento',null, array('id' => 'eliminarseguimiento'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!! Form::label('nombreEquipoSeguimiento', 'Equipo', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('nombreEquipoSeguimiento',null,['class'=>'form-control','placeholder'=>'Ingresa el Equipo',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}              
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>							
							{!!Form::select('Tercero_idResponsable',$Tercero, (isset($equiposeguimiento) ? $equiposeguimiento->Tercero_idResponsable : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Empleado Responsable"])!!}
					    </div>
					</div>
				</div>			
				<div class="form-group">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Detalles</div>
							<div class="panel-body">
								<div class="form-group" id='test'>
									<div class="col-sm-12">
										<div class="row show-grid">
											<div style="overflow: auto; width: 100%;">
												<div style="width: 2870px; height: 300px; display: inline-block; ">
													<div class="col-md-1" style="width: 1590px;height:40px;">&nbsp;</div>
													<div class="col-md-1" style="width: 180px;height:40px;text-align:center;">Rango</div>
													<div class="col-md-1" style="width: 150px;height:40px;">&nbsp;</div>
													<div class="col-md-1" style="width: 180px;height:40px;">Capacidad de Trabajo</div>
													<div class="col-md-1" style="width: 740px;height:40px;">&nbsp;</div>

													<div class="col-md-1" style="width: 40px;height: 60px;" onclick="detalle.agregarCampos(valor,'A')">
														<span class="glyphicon glyphicon-plus"></span>
													</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Identificaci&oacute;n / C&oacute;digo</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Tipo</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Frecuencia de Calibraci&oacute;n</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Fecha Inicial Calibraci&oacute;n</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Frecuencia Verificaci&oacute;n</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Fecha Inicial Verificac&oacute;on</div>
													<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Unidad Medida</div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;text-align:center;">></div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;text-align:center;"><</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Escala</div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;text-align:center;">></div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;text-align:center;"><</div>
													<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Utilizaci&oacute;n</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Tolerancia (+/-)</div>
													<div class="col-md-1" style="width: 220px;display:inline-block;height:60px;">Error M&#225;ximo permitido</div>												
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
						@if(isset($equiposeguimiento))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
					</div>
				</div>
			</fieldset>
		</div>	

	{!!Form::close()!!}
	<script type="text/javascript">

		$('#fechaEquipoSeguimiento').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop