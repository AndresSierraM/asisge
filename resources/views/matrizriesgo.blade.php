@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Matriz de Riesgos
	</h3>
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/matrizriesgo.js')!!}
	<script>
		
		var matrizRiesgoDetalle = '<?php echo (isset($matrizRiesgo) ? json_encode($matrizRiesgo->matrizRiesgoDetalles) : "");?>';
		matrizRiesgoDetalle = (matrizRiesgoDetalle != '' ? JSON.parse(matrizRiesgoDetalle) : '');

		var valor = [0,'','','','','','',0,0,0,0,'','','','','','','','','','','','','','','',''];

		var idProceso = '<?php echo isset($idProceso) ? $idProceso : "";?>';
    	var nombreProceso = '<?php echo isset($nombreProceso) ? $nombreProceso : "";?>';
    	var proceso = [JSON.parse(idProceso),JSON.parse(nombreProceso)];

    	var idClasificacionRiesgo = '<?php echo isset($idClasificacionRiesgo) ? $idClasificacionRiesgo : "";?>';
    	var nombreClasificacionRiesgo = '<?php echo isset($nombreClasificacionRiesgo) ? $nombreClasificacionRiesgo : "";?>';
    	var clasificacionRiesgo = [JSON.parse(idClasificacionRiesgo),JSON.parse(nombreClasificacionRiesgo)];

    	var eventos1 = ['onchange','buscarTipoRiesgo(this.parentNode.id);'];
    	var eventos2 = ['onchange','buscarDetalleTipoRiesgo(this.parentNode.id);'];
    	var eventos3 = ['onchange','calcularNiveles(this.parentNode.id);']
    	var eventos4 = ['onchange','calcularExpuestos(this.parentNode.id);']
    	var valorND = ['10','6','2','0'];
    	var opcionND = ['10 - Muy alto','6 - Alto','2 - Medio','0 - Bajo'];
    	var nivelDeficiencia = [valorND, opcionND];

    	var valorNE = ['4','3','2','1'];
    	var opcionNE = ['4 - Continua','3 - Frecuente','2 - Ocasional','1 - Esporádica'];
    	var nivelExposicion = [valorNE, opcionNE];

    	var valorNC = ['100','60','25','10'];
    	var opcionNC = ['100 - Mortal','60 - Muy Grave','25 - Grave','10 - Leve'];
    	var nivelConsecuencia = [valorNC, opcionNC];

    	$(document).ready(function(){

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');
			detalle.altura = '36px;';

			detalle.campos = ['idMatrizRiesgoDetalle', 'Proceso_idProceso', 'rutinariaMatrizRiesgoDetalle', 'ClasificacionRiesgo_idClasificacionRiesgo', 'TipoRiesgo_idTipoRiesgo', 'TipoRiesgoDetalle_idTipoRiesgoDetalle', 'TipoRiesgoSalud_idTipoRiesgoSalud', 'vinculadosMatrizRiesgoDetalle', 'temporalesMatrizRiesgoDetalle', 'independientesMatrizRiesgoDetalle', 'totalExpuestosMatrizRiesgoDetalle', 'fuenteMatrizRiesgoDetalle', 'medioMatrizRiesgoDetalle', 'personaMatrizRiesgoDetalle', 'nivelDeficienciaMatrizRiesgoDetalle', 'nivelExposicionMatrizRiesgoDetalle', 'nivelProbabilidadMatrizRiesgoDetalle', 'nombreProbabilidadMatrizRiesgoDetalle', 'nivelConsecuenciaMatrizRiesgoDetalle', 'nivelRiesgoMatrizRiesgoDetalle', 'nombreRiesgoMatrizRiesgoDetalle', 'aceptacionRiesgoMatrizRiesgoDetalle', 'eliminacionMatrizRiesgoDetalle', 'sustitucionMatrizRiesgoDetalle', 'controlMatrizRiesgoDetalle', 'elementoProteccionMatrizRiesgoDetalle', 'observacionMatrizRiesgoDetalle'];
			detalle.etiqueta = ['input','select','checkbox','select','select','select','select','input','input','input','input','input','input','input','select','select','input','input','select','input','input','input','input','input','input','input','input'];
			detalle.tipo = ['hidden','','checkbox','','','','','number','number','hidden','number','text','text','text','','','text','text','','text','text','text','text','text','text','text','text'];
			detalle.estilo = ['','width: 110px;height:35px;','width: 100px;height:32px;display:inline-block;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 90px;height:35px;text-align: right;','width: 90px;height:35px;text-align: right;','','width: 90px;height:35px;text-align: right;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 210px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 340px;height:35px;'];
			detalle.clase = ['','','','','','','','','','','','','','','','','','','','','','','','','','',''];
			detalle.sololectura = [false,false,false,false,false,false,false,false,false,false,true,false,false,false,false,false,true,true,false,true,true,true,false,false,false,false,false];
			detalle.opciones = ['',proceso,'',clasificacionRiesgo,'','','','','','','','','','',nivelDeficiencia, nivelExposicion,'','',nivelConsecuencia,'','','','', '', '', '',''];
			detalle.funciones = ['','','',eventos1,eventos2,'','',eventos4,eventos4,'','','','','',eventos3,eventos3,'','',eventos3,'','','','','','','',''];

			for(var j=0, k = matrizRiesgoDetalle.length; j < k; j++)
			{
				
				detalle.agregarCampos(JSON.stringify(matrizRiesgoDetalle[j]),'L');
				buscarTipoRiesgo('detalle_'+j);
				//buscarDetalleTipoRiesgo('detalle_'+j);
				//calcularNiveles('detalle_'+j);
			}

		});
	</script>
	@if(isset($matrizRiesgo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($matrizRiesgo,['route'=>['matrizriesgo.destroy',$matrizRiesgo->idMatrizRiesgo],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($matrizRiesgo,['route'=>['matrizriesgo.update',$matrizRiesgo->idMatrizRiesgo],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'matrizriesgo.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="matrizRiesgo-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaElaboracionMatrizRiesgo', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaElaboracionMatrizRiesgo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idMatrizRiesgo', 0, array('id' => 'idMatrizRiesgo'))!!}
					      	{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombreMatrizRiesgo', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>
							{!!Form::text('nombreMatrizRiesgo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" >
					{!!Form::label('FrecuenciaMedicion_idFrecuenciaMedicion', 'Frecuencia de Medici&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10" >
					  <div class="input-group">
					    <span class="input-group-addon">
					      <i class="fa fa-caret-square-o-down" ></i>
					    </span>
					    {!!Form::select('FrecuenciaMedicion_idFrecuenciaMedicion',$frecuenciaMedicion, (isset($matrizRiesgo) ? $matrizRiesgo->idFrecuenciaMedicion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la frecuencia de medici&oacute;n"])!!}
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
												<div style="width: 3080px; height: 300px; display: inline-block; ">
													<div class="col-md-1" style="width: 250px;height:40px;">&nbsp;</div>
													<div class="col-md-1" style="width: 440px;height:40px;">Peligro</div>
													<div class="col-md-1" style="width: 270px;height:40px;">Expuestos</div>
													<div class="col-md-1" style="width: 330px;height:40px;">M&eacute;todos de control existentes</div>
													<div class="col-md-1" style="width: 770px;height:40px;">Evaluaci&oacute;n de riesgos</div>
													<div class="col-md-1" style="width: 210px;height:40px;">Valoraci&oacute;n</div>
													<div class="col-md-1" style="width: 440px;height:40px;">Medidas de Intervenci&oacute;n</div>
													<div class="col-md-1" style="width: 340px;height:40px;">&nbsp;</div>
													<div class="col-md-1" style="width: 40px;height: 60px;" onclick="detalle.agregarCampos(valor,'A')">
														<span class="glyphicon glyphicon-plus"></span>
													</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Proceso</div>
													<div class="col-md-1" style="width: 100px;display:inline-block;height:60px;">Rutinaria</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Clasificaci&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Tipo Riesgo</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Descripci&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Efectos salud</div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Planta</div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Temporal</div>
													<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Total</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Fuente</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Medio</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Persona</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Nivel Deficiencia</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Nivel Exposici&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Nivel Probabilidad</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Interpretaci&oacute;n probabilidad</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Nivel consecuencia</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Nivel Riesgo</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Interpretaci&oacute;n riesgo</div>
													<div class="col-md-1" style="width: 210px;display:inline-block;height:60px;">Aceptaci&oacute;n riesgo</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Eliminaci&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Sustituci&oacute;n</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Controles</div>
													<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Protección Personal</div>
													<div class="col-md-1" style="width: 340px;display:inline-block;height:60px;">Observaciones</div>
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
						@if(isset($matrizRiesgo))
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
		// document.getElementById('contenedor').style.width = '1350px';
		// document.getElementById('contenedor-fin').style.width = '1350px';

		$('#fechaElaboracionMatrizRiesgo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop