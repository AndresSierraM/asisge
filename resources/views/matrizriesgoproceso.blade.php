@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Matriz de Riesgos por Proceso
	</h3>
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/matrizriesgoproceso.js')!!}
<script>

	//variable para ejecutar funcion de nivel Valor
	// se quema la palabra frecuencia cuando se esta parado en ese campio, para saber la posicion con un replace en el js
	var calcularValorNivelFrecuencia = ['onchange','CalcularNivelValor(this.id,"frecuencia");'];
	// se quema la palabra impacto cuando se esta parado en ese campio, para saber la posicion con un replace en el js
	var calcularValorNivelImpacto = ['onchange','CalcularNivelValor(this.id,"impacto");'];


	// Se recibe la consulta de la multigistro para que muestre los datos de los campos
	 var MatrizDetalle = '<?php echo (isset($MatrizRiesgoProcesoDetalleS) ? json_encode($MatrizRiesgoProcesoDetalleS) : "");?>';
	MatrizDetalle = (MatrizDetalle != '' ? JSON.parse(MatrizDetalle) : '');


	// Se reciben el id de tercero y nombre tercero para enviarlo al campo tipo select de Responsable accion
	var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
	var NombreTercero = '<?php echo isset($NombreTercero) ? $NombreTercero : "";?>';

	var ResponsableAccion = [JSON.parse(idTercero),JSON.parse(NombreTercero)];


	// ---------
	// Variable para el select FRECUENCIA
	valorFrecuencia = Array('3','2','1');
	NombreFrecuencia = Array ("Alta","Media","Baja");

	Frecuencia = [valorFrecuencia,NombreFrecuencia];
	// ---------
	// Variable para el select IMPACTO
	valorImpacto = Array('3','2','1');
	NombreImpacto = Array ("Alta","Media","Baja");

	Impacto = [valorImpacto,NombreImpacto];
	// ---------
	// Variable para el select ACCIONES
	valorAccion = Array("Eliminar","Controlar","Asumir");
	NombreAccion = Array ("Eliminar","Controlar","Asumir");

	Accion = [valorAccion,NombreAccion];



		var valor = [0,0,'','','','','','','','','','','','',''];

    	$(document).ready(function(){

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');
			detalle.altura = '36px;';
			detalle.campoid = 'idMatrizRiesgoProcesoDetalle';
			detalle.campoEliminacion = 'eliminarproceso';
			detalle.botonEliminacion = true;
			detalle.campos = ['idMatrizRiesgoProcesoDetalle','MatrizRiesgoProceso_idMatrizRiesgoProceso', 'descripcionMatrizRiesgoProcesoDetalle', 'efectoMatrizRiesgoProcesoDetalle', 'frecuenciaMatrizRiesgoProcesoDetalle', 'impactoMatrizRiesgoProcesoDetalle', 'nivelValorMatrizRiesgoProcesoDetalle', 'interpretacionValorMatrizRiesgoProcesoDetalle', 'accionesMatrizRiesgoProcesoDetalle', 'descripcionAccionMatrizRiesgoProcesoDetalle', 'Tercero_idResponsableAccion', 'seguimientoMatrizRiesgoProcesoDetalle', 'fechaSeguimientoMatrizRiesgoProcesoDetalle', 'fechaCierreMatrizRiesgoProcesoDetalle', 'eficazMatrizRiesgoProcesoDetalle'];
			detalle.etiqueta = ['input','input','textarea','textarea','select','select','input','input','select','textarea','select','textarea','input','input','checkbox'];
			detalle.tipo = ['hidden','hidden','textarea','textarea','','','text','text','','textarea','','textarea','date','date','checkbox'];
			detalle.estilo = ['','','vertical-align:top; width: 300px;  height:35px;','vertical-align:top; width: 300px;  height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','vertical-align:top; width: 300px;  height:35px;','width: 110px;height:35px;','vertical-align:top; width: 300px;  height:35px;','width: 150px;height:35px;','width: 150px;height:35px;','width: 80px;height:30px;display:inline-block;'];
			detalle.clase = ['','','','','','','','','','','','','',''];
			detalle.sololectura = [false,false,false,false,false,false,true,true,false,false,false,false,false,false,false];
			detalle.opciones = ['','','','',Frecuencia,Impacto,'','',Accion,'',ResponsableAccion,'','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			detalle.funciones = ['','',quitacarac,quitacarac,calcularValorNivelFrecuencia,calcularValorNivelImpacto,'','','',quitacarac,'',quitacarac,'',''];

			for(var j=0, k = MatrizDetalle.length; j < k; j++)
			{
				
				detalle.agregarCampos(JSON.stringify(MatrizDetalle[j]),'L');
				

			}

		});
	</script>
	@if(isset($matrizriesgoproceso))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($matrizriesgoproceso,['route'=>['matrizriesgoproceso.destroy',$matrizriesgoproceso->idMatrizRiesgoProceso],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($matrizriesgoproceso,['route'=>['matrizriesgoproceso.update',$matrizriesgoproceso->idMatrizRiesgoProceso],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'matrizriesgoproceso.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="matrizRiesgoProceso-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaMatrizRiesgoProceso', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaMatrizRiesgoProceso',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idMatrizRiesgoProceso', 0, array('id' => 'idMatrizRiesgoProceso'))!!}
					      	 {!!Form::hidden('eliminarproceso',null, array('id' => 'eliminarproceso'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idRespondable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>							
							{!!Form::select('Tercero_idRespondable',$Tercero, (isset($matrizriesgoproceso) ? $matrizriesgoproceso->Tercero_idRespondable : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Empleado Responsable"])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" >
					{!!Form::label('Proceso_idProceso', 'Procesos', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10" >
					  <div class="input-group">
					    <span class="input-group-addon">
					      <i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
					    </span>
					    {!!Form::select('Proceso_idProceso',$Proceso, (isset($matrizriesgoproceso) ? $matrizriesgoproceso->Proceso_idProceso : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Proceso"])!!}
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
												<div style="width: 2300px; height: 300px; display: inline-block; ">					
													<div class="col-md-1" style="width: 40px;height: 60px;" onclick="detalle.agregarCampos(valor,'A')">
														<span class="glyphicon glyphicon-plus"></span>
													</div>
													<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Descripci&oacute;n del riesgo</div>
													<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Efecto Posible</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Frecuencia</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Impacto</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Nivel Valor</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Interpretaci&oacute;n Valoraci&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Acciones</div>
													<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Descripci&oacute;n Acci&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Responsable Acci&oacute;n</div>
													<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Seguimiento</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha Seguimiento</div>
													<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha Cierre</div>
													<div class="col-md-1" style="width: 80px;display:inline-block;height:60px;">Eficaz</div>													
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
						@if(isset($matrizriesgoproceso))
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

		$('#fechaMatrizRiesgoProceso').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop