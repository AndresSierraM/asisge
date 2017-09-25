@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Accidentes</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/accidente.js')!!}

{!!Html::style('css/signature-pad.css'); !!} 


<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->

<?php

//Se pregunta  si existe el id de acta de capacitacion  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
$idAccidentes = (isset($accidente) ? $accidente->idAccidente : 0);


	// tomamos la imagen de la firma y la convertimos en base 64 para asignarla
	// al cuadro de imagen y al input oculto de firmabase64
	$base64 = '';	
	if(isset($accidente))
	{
		$path = 'imagenes/'.$accidente["firmaCoordinadorAccidente"];
		
		if($accidente["firmaCoordinadorAccidente"] != "" and file_exists($path))
		{
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		}
	}
?>



<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-39365077-1']);
	_gaq.push(['_trackPageview']);

	(function() {
	  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	
	
	var accidenteRecomendacion = '<?php echo (isset($accidente) ? json_encode($accidente->accidenteRecomendacion) : "");?>';
	accidenteRecomendacion = (accidenteRecomendacion != '' ? JSON.parse(accidenteRecomendacion) : '');

	var accidenteEquipo = '<?php echo (isset($accidente) ? json_encode($accidente->accidenteEquipo) : "");?>';
	accidenteEquipo = (accidenteEquipo != '' ? JSON.parse(accidenteEquipo) : '');

	var valorRecomendacion = [0,'',0,0,0,'','',0];
	var valorEquipo = [0,0];

	var idProceso = '<?php echo isset($idProceso) ? $idProceso : "";?>';
	var nombreProceso = '<?php echo isset($nombreProceso) ? $nombreProceso : "";?>';
	var proceso = [JSON.parse(idProceso),JSON.parse(nombreProceso)];

	var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
	var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
	var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

	var valorMed = ['Efectivo','No Efectivo'];
    var opcionMed = ['Efectivo','No Efectivo'];
    var medida = [valorMed, opcionMed];
	
	$(document).ready(function(){

		recomendacion = new Atributos('recomendacion','contenedor_recomendacion','recomendacion_');
		
		recomendacion.altura = '36px;';
		recomendacion.campoid = 'idAccidenteRecomendacion';
		recomendacion.campoEliminacion = 'eliminarRecomendacion';

		recomendacion.campos = [
				'idAccidenteRecomendacion', 
				'controlAccidenteRecomendacion', 
				'fuenteAccidenteRecomendacion',
				'medioAccidenteRecomendacion',
				'personaAccidenteRecomendacion',
				'fechaVerificacionAccidenteRecomendacion',
				'medidaEfectivaAccidenteRecomendacion',
				'Proceso_idResponsable'
				];
		
		recomendacion.etiqueta 	= ['input','input','checkbox','checkbox','checkbox','input','select','select'];
		recomendacion.tipo 		= ['hidden','text','checkbox','checkbox','checkbox','date','',''];
		recomendacion.estilo = ['display:inline-block;',
				'width: 400px;height:35px;display:inline-block;',
				'width: 110px;height:30px;display:inline-block;',
				'width: 110px;height:30px;display:inline-block;',
				'width: 110px;height:30px;display:inline-block;',
				'width: 150px;height:35px;display:inline-block;',
				'width: 110px;height:35px;display:inline-block;',
				'width: 400px;height:35px;display:inline-block;'
				];
		recomendacion.clase = ['','','','','','','',''];
		recomendacion.sololectura = [false,false,false,false,false,false,false,false];
		recomendacion.opciones = ['','','','','','',medida, proceso];
		var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"]; 
		recomendacion.funciones = ['',quitacarac,'','','','','',''];


		for(var j=0, k = accidenteRecomendacion.length; j < k; j++)
		{
			recomendacion.agregarCampos(JSON.stringify(accidenteRecomendacion[j]),'L');
		}



		equipo = new Atributos('equipo','contenedor_equipo','equipo_');
		
		equipo.altura = '36px;';
		equipo.campoid = 'idAccidenteEquipo';
		equipo.campoEliminacion = 'eliminarEquipo';

		equipo.campos = [
				'idAccidenteEquipo', 
				'Tercero_idInvestigador'
				];

		equipo.etiqueta 	= ['input','select'];
		equipo.tipo 		= ['hidden',''];
		equipo.estilo = ['',
				'width: 1150px;height:35px;'
				];
		equipo.clase = ['',''];
		equipo.sololectura = [false,false];
		equipo.opciones = ['',tercero];
		equipo.funciones = ['',''];


		for(var j=0, k = accidenteEquipo.length; j < k; j++)
		{
			equipo.agregarCampos(JSON.stringify(accidenteEquipo[j]),'L');
		}

	});
</script>

	@if(isset($accidente))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($accidente,['route'=>['accidente.destroy',$accidente->idAccidente],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($accidente,['route'=>['accidente.update',$accidente->idAccidente],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'accidente.store','method'=>'POST', 'files' => true])!!}
	@endif

	<?php $mytime = Carbon\Carbon::now();?>
		<div id="signature-pad" class="m-signature-pad">
			<input type="hidden" id="signature-reg" value="">
		    <div class="m-signature-pad--body">
		      <canvas></canvas>
		    </div>
		    <div class="m-signature-pad--footer">
		      <div class="description">Firme sobre el recuadro</div>
		      <button type="button" class="button clear btn btn-danger" data-action="clear">Limpiar</button>
		      <button type="button" class="button save btn btn-success" data-action="save">Guardar Firma</button>
		    </div>
		</div>
		<div id='form-section' >
				<fieldset id="accidente-form-fieldset">	

				<div class="form-group" id='test'>
					{!!Form::label('numeroAccidente', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('numeroAccidente',null,['class'=>'form-control','placeholder'=>'Ingresa el número del accidente'])!!}
					      	{!!Form::hidden('idAccidente', null, array('id' => 'idAccidente'))!!}
					      	{!!Form::hidden('eliminarRecomendacion', '', array('id' => 'eliminarRecomendacion'))!!}
					      	{!!Form::hidden('eliminarEquipo', '', array('id' => 'eliminarEquipo'))!!}
						</div>
					</div>
				</div>

				<div class="form-group required" id='test'>
					{!!Form::label('nombreAccidente', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('nombreAccidente',null,['class'=>'form-control','placeholder'=>'Ingresa la descripcion del accidente',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
						</div>
					</div>
				</div>

				<div class="form-group required" id='test'>
					{!!Form::label('clasificacionAccidente', 'Clase de Accidente', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o"></i>
			              	</span>
							{!!Form::select('clasificacionAccidente',
							array(
							'Accidente Normal' => 'Accidente Normal',
							'Accidente Grave' => 'Accidente Grave',
							'Accidente Mortal' => 'Accidente Mortal',
							'Incidente' => 'Incidente',
							'Incidente No Caracterizado' => 'Incidente No Caracterizado'
							),
							(isset($accidente) ? $accidente->clasificacionAccidente : 0),
							['class'=>'form-control','placeholder'=>'Ingresa la clasificaci&oacute;n del accidente'])!!}
			    		</div>
			    	</div>
			    </div>	




				<div class="form-group required" id='test'>
					{!!Form::label('Tercero_idCoordinador', 'Coord. Investigaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
							{!!Form::select('Tercero_idCoordinador',$terceroCoord, (isset($accidente) ? $accidente->Tercero_idCoordinador : 0),["class" => "form-control", "placeholder" =>"Seleccione el Coordinador del equipo de investigaci&oacute;n"])!!}

							<div class="col-sm-10">
								<img id="firma" style="width:200px; height: 150px; border: 1px solid;" onclick="mostrarFirma();" src="<?php echo $base64;?>">
								{!!Form::hidden('firmabase64', $base64, array('id' => 'firmabase64'))!!}
							</div>
						</div>
					</div>
					
				</div>

				
		<div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#empleado">Datos Generales del Trabajador</a>
                      </h4>
                    </div>
                    <div id="empleado" class="panel-collapse collapse">
						<div class="panel-body">

							<div class="form-group required" id='test'>
								{!!Form::label('Tercero_idEmpleado', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}
								<div class="col-sm-10">
						            <div class="input-group">
						              	<span class="input-group-addon">
						                	<i class="fa fa-flag"></i>
						              	</span>
										{!!Form::select('Tercero_idEmpleado',$terceroEmple, (isset($accidente) ? $accidente->Tercero_idEmpleado : 0),["onchange" => "buscarAusentismo(); consultarFecha(this.value)","class" => "form-control", "placeholder" =>"Seleccione el Empleado Accidentado"])!!}
									</div>
								</div>
							</div>
					        
					        <div class="form-group" id='test'>
					          {!!Form::label('edadEmpleadoAccidente', 'Edad', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('edadEmpleadoAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa la Edad del empleado', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>
					        
					        <div class="form-group required" id='test'>
								{!!Form::label('Ausentismo_idAusentismo', 'Ausencia', array('class' => 'col-sm-2 control-label'))!!}
								<div class="col-sm-10">
						            <div class="input-group">
						              	<span class="input-group-addon">
						                	<i class="fa fa-flag"></i>
						              	</span>
										{!!Form::select('Ausentismo_idAusentismo',$ausentismo, (isset($accidente) ? $accidente->Ausentismo_idAusentismo : 0),["class" => "form-control", "placeholder" =>"Seleccione el Ausentismo Relacionado al Accidente"])!!}
									</div>
								</div>
							</div>
					        <div class="form-group" id='test'>
					          {!!Form::label('tiempoServicioAccidente', 'Tiempo Servicio', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('tiempoServicioAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa el tiempo de servicio', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

							<div class="form-group required" id='test'>
								{!!Form::label('Proceso_idProceso', 'Area/Secci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
								<div class="col-sm-10">
						            <div class="input-group">
						              	<span class="input-group-addon">
						                	<i class="fa fa-flag"></i>
						              	</span>
										{!!Form::select('Proceso_idProceso',$proceso, (isset($accidente) ? $accidente->Proceso_idProceso : 0),["class" => "form-control", "placeholder" =>"Seleccione el &aacute;rea o secci&oacute;n del empleado"])!!}
									</div>
								</div>
							</div>
					        
							<div class="form-group" id='test'>
					          {!!Form::label('enSuLaborAccidente', 'Oficio habitual', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::checkbox('enSuLaborAccidente',(isset($accidente) ? $accidente->enSuLaborAccidente : 0), null, ['style'=>'width:30px;height: 30px;'])!!}
					            </div>
					          </div>
					        </div>
					        
					        <div class="form-group" id='test'>
					          {!!Form::label('laborAccidente', 'Labor Realizada', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('laborAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa la labor que estaba realizando', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('enLaEmpresaAccidente', 'En la Empresa', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::checkbox('enLaEmpresaAccidente',(isset($accidente) ? $accidente->enLaEmpresaAccidente : 0), null, ['style'=>'width:30px;height: 30px;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('lugarAccidente', 'Lugar', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('lugarAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa el lugar del accidente', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

						</div>
			        </div>                           
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#accidente">Datos Generales Sobre el Accidente</a>
                      </h4>
                    </div>
                    <div id="accidente" class="panel-collapse collapse">
						<div class="panel-body">

					        <div class="form-group required" id='test'>
					          {!!Form::label('fechaOcurrenciaAccidente', 'Fecha/Hora', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('fechaOcurrenciaAccidente',(isset($accidente) ? $accidente->fechaOcurrenciaAccidente : $mytime->toDateTimeString()), ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Ocurrencia', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('tiempoEnLaborAccidente', 'Tiempo en Labor', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('tiempoEnLaborAccidente',null,  ['class'=>'form-control', 'placeholder'=>'Ingresa el tiempo desempeñando la labor', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('tareaDesarrolladaAccidente', 'Tarea', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('tareaDesarrolladaAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa la tarea desarrollada al momento del accidente', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('descripcionAccidente', 'Descripcion Ampliada', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('descripcionAccidente',null,['class'=>'ckeditor','placeholder'=>'Ampliación de la descripción del accidente (describa donde, que y cómo ocurrió)'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('observacionTrabajadorAccidente', 'Observaciones Trabajador', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('observacionTrabajadorAccidente',null,['class'=>'ckeditor','placeholder'=>'Observaciones del trabajador y/o testigos'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('observacionEmpresaAccidente', 'Observaciones Empresa', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('observacionEmpresaAccidente',null,['class'=>'ckeditor','placeholder'=>'Observaciones de la empresa (equipo de salud ocupacional, jefe inmediato y copaso)'])!!}
					            </div>
					          </div>
					        </div>

						</div>
			        </div>   
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#analisis">An&aacute;lisis del Accidente o Incidente</a>
                      </h4>
                    </div>
                    <div id="analisis" class="panel-collapse collapse">
						<div class="panel-body">

					        <div class="form-group" id='test'>
					          {!!Form::label('agenteYMecanismoAccidente', 'Agente y Mecanismo', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('agenteYMecanismoAccidente',null,['class'=>'ckeditor','placeholder'=>'Agente y mecanismo del accidente'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('naturalezaLesionAccidente', 'Naturaleza de la Lesi&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('naturalezaLesionAccidente',null,['class'=>'ckeditor','placeholder'=>'Naturaleza de la Lesi&oacute;n'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('parteCuerpoAfectadaAccidente', 'Parte del cuerpo afectada', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('parteCuerpoAfectadaAccidente',null,['class'=>'ckeditor','placeholder'=>'Parte del cuerpo afectada'])!!}
					            </div>
					          </div>
					        </div>


					        <div class="form-group" id='test'>
					          {!!Form::label('tipoAccidente', 'Tipo de Accidente', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('tipoAccidente',null,['class'=>'ckeditor','placeholder'=>'Tipo de Accidente'])!!}
					            </div>
					          </div>
					        </div>
					    </div>
			        </div> 
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#recomendacion">Recomendaciones para la Intervencion de las Causas Encontradas en el Analisis, Evaluación Y Control</a>
                      </h4>
                    </div>
                    <div id="recomendacion" class="panel-collapse collapse">
                      <div class="panel-body">
							<div class="form-group" id='test'>
								<div class="col-sm-12">
									<div class="row show-grid">
										<div style="overflow: auto; width: 100%;">
											<div style="width: 1450px; height: 300px; display: inline-block; ">
												<div class="col-md-1" style="width: 440px;height:40px;">Controles a Implementar</div>
												<div class="col-md-1" style="width: 330px;height:40px; text-align: center;">Tipo de Control</div>
												<div class="col-md-1" style="width: 670px;height:40px;">&nbsp;</div>
												<div class="col-md-1" style="width: 40px;height: 60px;" onclick="recomendacion.agregarCampos(valorRecomendacion,'A')">
													<span class="glyphicon glyphicon-plus"></span>
												</div>
												<div class="col-md-1" style="width: 400px;display:inline-block;height:60px;">Segun Lista de Causas</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Fuente</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Medio</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Persona</div>
												<div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Fecha Verificaci&oacute;n</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Medida Efectiva</div>
												<div class="col-md-1 requiredMulti" style="width: 400px;display:inline-block;height:60px;">Area Responsable</div>
												<div id="contenedor_recomendacion">
												</div>
											</div>
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#equipo">Equipo de Investigaci&oacute;n</a>
                      </h4>
                    </div>
            		<div id="equipo" class="panel-collapse collapse">
                      <div class="panel-body">
							<div class="form-group" id='test'>
								<div class="col-sm-12">
									<div class="row show-grid">
										<div style="overflow: auto; width: 100%;">
											<div style="width: 1450px; height: 300px; display: inline-block; ">
												
												<div class="col-md-1" style="width: 40px;height: 60px;" onclick="equipo.agregarCampos(valorRecomendacion,'A')">
													<span class="glyphicon glyphicon-plus"></span>
												</div>
												<div class="col-md-1 requiredMulti" style="width: 1150px;display:inline-block;height:60px;">Nombre Investigador</div>
												<div id="contenedor_equipo">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                  </div>
                  <!-- Se agrega el Acordeon Archivos -->

															<!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
					<div class="panel panel-default" style="display:inline-block;width:100%">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#archivos">Archivos</a>
							</h4>
						</div>
						<div id="archivos" class="panel-collapse collapse">
							<div class="col-sm-12">
								<!-- <div class="panel panel-default">  SE QUITA POR PETICION DE ANDRES-->  <!--se cambia la clase panel-primary AZUL por default para que salga gris   -->
	                                <div class="panel-heading ">
	                                    <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
	                                </div>
	                                <div class="panel-body">
										<div class="col-sm-12">
											<div id="upload" class="col-md-12">
											    <div class="dropzone dropzone-previews" id="dropzoneAccidenteArchivo" style="overflow: auto;">
											    </div>  
											</div>	
	 									
											
											<div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;overflow: auto;">		
											{!!Form::hidden('archivoAccidenteArray', '', array('id' => 'archivoAccidenteArray'))!!}
												<?php
												
												// Cuando este editando el archivo 
												if ($idAccidentes != '')  //Se pregunta si el id de acta de capacitacion es diferente de vacio (que es la tabla papá)
												{
													$eliminar = '';
													$archivoSave = DB::Select('SELECT * from accidentearchivo where Accidente_idAccidente = '.$idAccidentes);
													for ($i=0; $i <count($archivoSave) ; $i++) 
													{ 
														$archivoS = get_object_vars($archivoSave[$i]);

														echo '<div id="'.$archivoS['idAccidenteArchivo'].'" class="col-lg-4 col-md-4">
										                    <div class="panel panel-yellow" style="border: 1px solid orange;">
										                        <div class="panel-heading">
										                            <div class="row">
										                                <div class="col-xs-3">
										                                    <a target="_blank" 
										                                    	href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaAccidenteArchivo'].'">
										                                    	<i class="fa fa-book fa-5x" style="color: gray;"></i>
										                                    </a>
										                                </div>

										                                <div class="col-xs-9 text-right">
										                                    <div>'.str_replace('/accidente/','',$archivoS['rutaAccidenteArchivo']).'
										                                    </div>
										                                </div>
										                            </div>
										                        </div>
										                        <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idAccidenteArchivo'].');">
										                            <div class="panel-footer">
										                                <span class="pull-left">Eliminar Documento</span>
										                                <span class="pull-right"><i class="fa fa-times"></i></span>
										                                <div class="clearfix"></div>
										                            </div>
										                        </a>
										                    </div>
										                </div>';

														echo '<input type="hidden" id="idAccidenteArchivo[]" name="idAccidenteArchivo[]" value="'.$archivoS['idAccidenteArchivo'].'" >

														<input type="hidden" id="rutaAccidenteArchivo[]" name="rutaAccidenteArchivo[]" value="'.$archivoS['rutaAccidenteArchivo'].'" >';
													}

													echo '<input type="hidden" name="eliminarArchivo" id="eliminarArchivo" value="">';
												}
												
												 ?>							
											</div>
										</div>
									</div>
								<!-- </div> -->
							</div>
						</div>
					</div>
                   <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#metas">Notas</a>
                      </h4>
                    </div>
                    <div id="metas" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('observacionAccidente',null,['class'=>'ckeditor','placeholder'=>'Ingresa otras observaciones del accidente'])!!}
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



				</fieldset>	
				@if(isset($accidente))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script type="text/javascript">
    $('#fechaOcurrenciaAccidente').datetimepicker(({
      format: "YYYY-MM-DD"
    }));


 	$(document).ready(function()
	{
		mostrarFirma();
	});
    

</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}


<script>


    //--------------------------------- DROPZONE ---------------------------------------
	var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneAccidenteArchivo", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

   	 fileList = Array();
   	var i = 0;

    //Configuro el dropzone
    myDropzone.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    accept: function(file, done) {

      }
    };
    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('archivoAccidenteArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
    					//abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
						// console.log(fileList);
                        document.getElementById('archivoAccidenteArray').value += file.name+',';
                        // console.log(document.getElementById('archivoAccidenteArray').value);
                        i++;
                    });

</script>
 

@stop