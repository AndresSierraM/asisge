@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Accidentes</center></h3>@stop

@section('content')
@include('alerts.request')

<script>
	
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
		recomendacion.tipo 		= ['hidden','text','checkbox','checkbox','checkbox','text','',''];
		recomendacion.estilo = ['',
				'width: 300px; height:35px;',
				'width: 110px;height:32px;display:inline-block;',
				'width: 110px;height:35px;display:inline-block;',
				'width: 110px;height:35px;display:inline-block;',
				'width: 110px;height:35px;',
				'width: 110px;height:35px;',
				'width: 300px;height:35px;'
				];
		recomendacion.clase = ['','','','','','','',''];
		recomendacion.sololectura = [false,false,false,false,false,false,false,false];
		recomendacion.opciones = ['','','','','','',medida, proceso];
		recomendacion.funciones = ['','','','','','','',''];


		for(var j=0, k = accidenteRecomendacion.length; j < k; j++)
		{
			recomendacion.agregarCampos(JSON.stringify(accidenteRecomendacion[j]),'L');
		}



		equipo = new Atributos('equipo','contenedor_equipo','equipo_');
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

		<div id='form-section' >
				<fieldset id="accidente-form-fieldset">	

				<div class="form-group" id='test'>
					{!!Form::label('numeroAccidente', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('numeroAccidente',null,['class'=>'form-control','placeholder'=>'Ingresa el número del accidente'])!!}
					      	{!!Form::hidden('idAccidente', null, array('id' => 'idAccidente'))!!}
						</div>
					</div>
				</div>

				<div class="form-group" id='test'>
					{!!Form::label('nombreAccidente', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('nombreAccidente',null,['class'=>'form-control','placeholder'=>'Ingresa la descripcion del accidente'])!!}
						</div>
					</div>
				</div>

				<div class="form-group" id='test'>
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




				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idCoordinador', 'Coord. Investigaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
							{!!Form::select('Tercero_idCoordinador',$terceroCoord, (isset($accidente) ? $accidente->Tercero_idCoordinador : 0),["class" => "form-control", "placeholder" =>"Seleccione el Coordinador del equipo de investigaci&oacute;n"])!!}
						</div>
					</div>
				</div>

				<div class="form-group" id='test'>
					{!!Form::label('Ausentismo_idAusentismo', 'Ausencia Relacionada', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
							{!!Form::select('Ausentismo_idAusentismo',$ausentismo, (isset($accidente) ? $accidente->Ausentismo_idAusentismo : 0),["class" => "form-control", "placeholder" =>"Seleccione el Ausentismo Relacionado al Accidente"])!!}
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

							<div class="form-group" id='test'>
								{!!Form::label('Tercero_idEmpleado', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}
								<div class="col-sm-10">
						            <div class="input-group">
						              	<span class="input-group-addon">
						                	<i class="fa fa-flag"></i>
						              	</span>
										{!!Form::select('Tercero_idEmpleado',$terceroEmple, (isset($accidente) ? $accidente->Tercero_idEmpleado : 0),["class" => "form-control", "placeholder" =>"Seleccione el Empleado Accidentado"])!!}
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

							<div class="form-group" id='test'>
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

					        <div class="form-group" id='test'>
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
					          {!!Form::label('tareaDesarrolladaAccidente', 'Lugar', array('class' => 'col-sm-2 control-label'))!!}
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
											<div style="width: 1190px; height: 300px; display: inline-block; ">
												<div class="col-md-1" style="width: 340px;height:40px;">Controles a Implementar</div>
												<div class="col-md-1" style="width: 330px;height:40px; text-align: center;">Tipo de Control</div>
												<div class="col-md-1" style="width: 520px;height:40px;">&nbsp;</div>
												<div class="col-md-1" style="width: 40px;height: 60px;" onclick="recomendacion.agregarCampos(valorRecomendacion,'A')">
													<span class="glyphicon glyphicon-plus"></span>
												</div>
												<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Segun Lista de Causas</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Fuente</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Medio</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Persona</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Fecha Verificaci&oacute;n</div>
												<div class="col-md-1" style="width: 110px;display:inline-block;height:60px;">Medida Efectiva</div>
												<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Area Responsable</div>
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
											<div style="width: 1190px; height: 300px; display: inline-block; ">
												
												<div class="col-md-1" style="width: 40px;height: 60px;" onclick="equipo.agregarCampos(valorRecomendacion,'A')">
													<span class="glyphicon glyphicon-plus"></span>
												</div>
												<div class="col-md-1" style="width: 1150px;display:inline-block;height:60px;">Nombre Investigador</div>
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
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script type="text/javascript">
    $('#fechaOcurrenciaAccidente').datetimepicker(({
      format: "YYYY-MM-DD"
    }));
</script>

@stop