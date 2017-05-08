@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Matriz Legal</center>
	</h3> 
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/matrizlegal.js')!!}
	<script>

		var matrizLegalDetalle = '<?php echo (isset($matrizLegal) ? json_encode($matrizLegal->matrizLegalDetalles) : "");?>';
		matrizLegalDetalle = (matrizLegalDetalle != '' ? JSON.parse(matrizLegalDetalle) : '');

		var valor = [0,'','','','','','','','','','0000-00-00','',''];

		var idTipoNormaLegal = '<?php echo isset($idTipoNormaLegal) ? $idTipoNormaLegal : "";?>';
    	var nombreTipoNormaLegal = '<?php echo isset($nombreTipoNormaLegal) ? $nombreTipoNormaLegal : "";?>';
    	var tipoNormaLegal = [JSON.parse(idTipoNormaLegal),JSON.parse(nombreTipoNormaLegal)];

    	var idExpideNormaLegal = '<?php echo isset($idExpideNormaLegal) ? $idExpideNormaLegal : "";?>';
    	var nombreExpideNormaLegal = '<?php echo isset($nombreExpideNormaLegal) ? $nombreExpideNormaLegal : "";?>';
    	var expideNormaLegal = [JSON.parse(idExpideNormaLegal),JSON.parse(nombreExpideNormaLegal)];
    	//var eventos1 = ['onclick','fechaDetalle(this.parentNode.id);']
		$(document).ready(function(){

			detalle = new Atributos('detalle','contenedor_detalle','detalle_');

			detalle.altura = '36px;';
			detalle.campos = ['idMatrizLegalDetalle', 'TipoNormaLegal_idTipoNormaLegal', 'articuloAplicableMatrizLegalDetalle', 'ExpideNormaLegal_idExpideNormaLegal', 'exigenciaMatrizLegalDetalle', 'fuenteMatrizLegalDetalle', 'medioMatrizLegalDetalle', 'personaMatrizLegalDetalle', 'herramientaSeguimientoMatrizLegalDetalle', 'cumpleMatrizLegalDetalle', 'fechaVerificacionMatrizLegalDetalle', 'accionEvidenciaMatrizLegalDetalle', 'controlAImplementarMatrizLegalDetalle'];
			detalle.etiqueta = ['input','select','input','select','input','input','input','input','input','checkbox','input','input','input'];
			detalle.tipo = ['hidden','','text','','text','text','text','text','text','checkbox','date','text','text'];
			detalle.estilo = ['','width: 160px;height:35px;','width: 250px;height:35px;','width: 160px;height:35px;','width: 400px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 110px;height:35px;','width: 300px;height:35px;','width: 80px;height:30px;display:inline-block;','width: 150px;height:35px;','width: 120px;height:35px;','width: 350px;height:35px;'];
			detalle.clase = ['','','','','','','','','','','','','',''];
			detalle.sololectura = [false,false,false,false,false,false,false,false,false,false,false,false,false];
			detalle.completar = ['off','off','off','off','off','off','off','off','off','off','off','off','off'];
			detalle.opciones = ['',tipoNormaLegal,'',expideNormaLegal,'','','','','','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			detalle.funciones  = ['','',quitacarac,'',quitacarac,quitacarac,quitacarac,quitacarac,quitacarac,'','',quitacarac,quitacarac];
			for(var j=0, k = matrizLegalDetalle.length; j < k; j++)
			{
				detalle.agregarCampos(JSON.stringify(matrizLegalDetalle[j]),'L');
			}

		});
	
		// function fechaDetalle(registro)
		// {
		// 	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
		// 	$('#fechaVerificacionMatrizLegalDetalle'+posicion).datetimepicker(({
		// 		format: "YYYY-MM-DD"
		// 	}));
		// }
	</script>
	@if(isset($matrizLegal))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($matrizLegal,['route'=>['matrizlegal.destroy',$matrizLegal->idMatrizLegal],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($matrizLegal,['route'=>['matrizlegal.update',$matrizLegal->idMatrizLegal],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'matrizlegal.store','method'=>'POST', 'files' => true])!!}
	@endif
		<div id="form_section">
			<fieldset id="matrizLegal-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaElaboracionMatrizLegal', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaElaboracionMatrizLegal',date('Y-m-d'),['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idMatrizLegal', 0, array('id' => 'idMatrizLegal'))!!}
					      	{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombreMatrizLegal', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>
							{!!Form::text('nombreMatrizLegal',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('origenMatrizLegal', 'Origen', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>
			              	{!!Form::select('origenMatrizLegal',
            				array('AMBIENTAL'=>'Ambiental','SALUD'=>'Salud'), (isset($matrizLegal) ? $matrizLegal->origenMatrizLegal : 0),["class" => "form-control", "placeholder" =>"Seleccione el origen"])!!}
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
					    {!!Form::select('FrecuenciaMedicion_idFrecuenciaMedicion',$frecuenciaMedicion, (isset($matrizLegal) ? $matrizLegal->frecuenciaMedicion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la frecuencia de medici&oacute;n"])!!}
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
						                  <div style="width: 2360px; height: 300px; display: inline-block; ">
						                    <div class="col-md-1" style="width: 1010px;">&nbsp;</div>
						                    <div class="col-md-1" style="width: 330px; text-align:center;">Controles Existentes</div>
						                    <div class="col-md-1" style="width: 1000px;">&nbsp;</div>
						                    
						                    <div class="col-md-1" style="width: 40px;height: 60px;" onclick="detalle.agregarCampos(valor,'A')">
												<span class="glyphicon glyphicon-plus"></span>
											</div>
											<div class="col-md-1" style="width: 160px;display:inline-block;height:60px;">Tipo de norma</div>
											<div class="col-md-1" style="width: 250px;display:inline-block;height:60px;">Art&iacute;culos Aplicables</div>
											<div class="col-md-1" style="width: 160px;display:inline-block;height:60px;">Expedida por</div>
											<div class="col-md-1" style="width: 400px;display:inline-block;height:60px;">Exigencia</div>
											<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Fuente</div>
											<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Medio</div>
											<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Persona</div>
											<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Herramienta de seguimiento</div>
											<div class="col-md-1" style="width: 80px;display:inline-block;height:60px;">Se cumple</div>
											<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha verificaci&oacute;n</div>
											<div class="col-md-1" style="width: 120px;display:inline-block;height:60px;">Acci&oacute;n / Evidencia</div>
											<div class="col-md-1" style="width: 350px;display:inline-block;height:60px;">Control a implementar</div>
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
						@if(isset($matrizLegal))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>"validarFormulario(event);"])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>"validarFormulario(event);"])!!}
						@endif
					</div>
				</div>
			</fieldset>
		</div>

	{!!Form::close()!!}
	<script type="text/javascript">
		// document.getElementById('contenedor').style.width = '1350px';
		// document.getElementById('contenedor-fin').style.width = '1350px';

		$('#fechaElaboracionMatrizLegal').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop	