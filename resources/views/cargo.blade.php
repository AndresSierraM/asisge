@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Cargos</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	{!!Html::script('js/cargo.js')!!}
	<script>
		var cargoTareaRiesgo = '<?php echo (isset($cargo) ? json_encode($cargo->cargoTareaRiesgos) : "");?>';
		cargoTareaRiesgo = (cargoTareaRiesgo != '' ? JSON.parse(cargoTareaRiesgo) : '');
		
		var cargoVacuna = '<?php echo (isset($cargo) ? json_encode($cargo->cargoVacunas) : "");?>';
		cargoVacuna = (cargoVacuna != '' ? JSON.parse(cargoVacuna) : '');

		var cargoElementoProteccion = '<?php echo (isset($cargo) ? json_encode($cargo->cargoElementoProtecciones) : "");?>';
		cargoElementoProteccion = (cargoElementoProteccion != '' ? JSON.parse(cargoElementoProteccion) : '');

		var cargoExamenMedico = '<?php echo (isset($cargo) ? json_encode($cargo->cargoExamenMedicos) : "");?>';
		cargoExamenMedico = (cargoExamenMedico != '' ? JSON.parse(cargoExamenMedico) : '');

		var valorTarea = [0,''];
		var valorVacuna = [0,''];
		var valorElemento = [0,''];
		var valorExamen = [0,'',0,0,0,''];

		var idListaTarea = '<?php echo isset($idListaTarea) ? $idListaTarea : 0;?>';
		var nombreListaTarea = '<?php echo isset($nombreListaTarea) ? $nombreListaTarea : "";?>';
		var idTipoExamen = '<?php echo isset($idTipoExamen) ? $idTipoExamen : 0;?>';
		var nombreTipoExamen = '<?php echo isset($nombreTipoExamen) ? $nombreTipoExamen : "";?>';
		var idListaElemento = '<?php echo isset($idListaElemento) ? $idListaElemento : 0;?>';
		var nombreListaElemento = '<?php echo isset($nombreListaElemento) ? $nombreListaElemento : "";?>';
		var idListaVacuna = '<?php echo isset($idListaVacuna) ? $idListaVacuna : 0;?>';
		var nombreListaVacuna = '<?php echo isset($nombreListaVacuna) ? $nombreListaVacuna : "";?>';
		
		var idFrecuenciaMedicion = '<?php echo isset($idFrecuenciaMedicion) ? $idFrecuenciaMedicion : 0;?>';
		var nombreFrecuenciaMedicion = '<?php echo isset($nombreFrecuenciaMedicion) ? $nombreFrecuenciaMedicion : "";?>';
		
		var listaTarea = [JSON.parse(idListaTarea),JSON.parse(nombreListaTarea)];
		var listaExamen = [JSON.parse(idTipoExamen),JSON.parse(nombreTipoExamen)];
		var listaElemento = [JSON.parse(idListaElemento),JSON.parse(nombreListaElemento)];
		var listaVacuna = [JSON.parse(idListaVacuna),JSON.parse(nombreListaVacuna)];
		var frecuenciaMedicion = [JSON.parse(idFrecuenciaMedicion),JSON.parse(nombreFrecuenciaMedicion)];
		
		$(document).ready(function()
		{
			tarea = new Atributos('tarea','contenedor_tarea','tarea');

			tarea.altura = '35px;';
			tarea.campoid = 'idCargoTareaRiesgo';
			tarea.campoEliminacion = 'eliminarTarea';

			tarea.campos = ['idCargoTareaRiesgo', 'ListaGeneral_idTareaAltoRiesgo'];
			tarea.etiqueta = ['input','select'];
			tarea.tipo = ['hidden',''];
			tarea.estilo = ['','width: 900px;height:35px;'];
			tarea.clase = ['',''];
			tarea.sololectura = [false,false];
			tarea.completar = ['off','off'];
			tarea.opciones = ['',listaTarea];
			tarea.funciones  = ['',''];

			vacuna = new Atributos('vacuna','contenedor_vacuna','vacuna');
			
			vacuna.altura = '35px;';
			vacuna.campoid = 'idCargoVacuna';
			vacuna.campoEliminacion = 'eliminarVacuna';

			vacuna.campos = ['idCargoVacuna', 'ListaGeneral_idVacuna'];
			vacuna.etiqueta = ['input','select'];
			vacuna.tipo = ['hidden',''];
			vacuna.estilo = ['','width: 900px;height:35px;'];
			vacuna.clase = ['',''];
			vacuna.sololectura = [false,false];
			vacuna.completar = ['off','off'];
			vacuna.opciones = ['',listaVacuna];
			vacuna.funciones  = ['',''];

			elemento = new Atributos('elemento','contenedor_elemento','elemento');

			elemento.altura = '35px;';
			elemento.campoid = 'idCargoElementoProteccion';
			elemento.campoEliminacion = 'eliminarElemento';

			elemento.campos = ['idCargoElementoProteccion', 'ElementoProteccion_idElementoProteccion'];
			elemento.etiqueta = ['input','select'];
			elemento.tipo = ['hidden',''];
			elemento.estilo = ['','width: 900px;height:35px;'];
			elemento.clase = ['',''];
			elemento.sololectura = [false,false];
			elemento.completar = ['off','off'];
			elemento.opciones = ['',listaElemento];
			elemento.funciones  = ['',''];

			examen = new Atributos('examen','contenedor_examen','examen');

			examen.altura = '36px;';
			examen.campoid = 'idCargoExamenMedico';
			examen.campoEliminacion = 'eliminarExamen';

			examen.campos = ['idCargoExamenMedico', 'TipoExamenMedico_idTipoExamenMedico','ingresoCargoExamenMedico','retiroCargoExamenMedico','periodicoCargoExamenMedico','FrecuenciaMedicion_idFrecuenciaMedicion'];
			examen.etiqueta = ['input','select','checkbox','checkbox','checkbox','select'];
			examen.tipo = ['hidden','','checkbox','checkbox','checkbox',''];
			examen.estilo = ['','width: 300px;height:35px;','width: 90px;height:30px;display:inline-block;','width: 90px;height:30px;display:inline-block;','width: 90px;height:30px;display:inline-block;','width: 300px;height:35px;'];
			examen.clase = ['','','','','',''];
			examen.sololectura = [false,false,false,false,false,false];
			examen.completar = ['off','off','off','off','off','off'];
			examen.opciones = ['',listaExamen,'','','',frecuenciaMedicion];
			examen.funciones  = ['','','','','',''];


			for(var j=0, k = cargoTareaRiesgo.length; j < k; j++)
			{
				tarea.agregarCampos(JSON.stringify(cargoTareaRiesgo[j]),'L');
			}

			for(var j=0, k = cargoVacuna.length; j < k; j++)
			{
				vacuna.agregarCampos(JSON.stringify(cargoVacuna[j]),'L');
			}

			for(var j=0, k = cargoElementoProteccion.length; j < k; j++)
			{
				elemento.agregarCampos(JSON.stringify(cargoElementoProteccion[j]),'L');
			}

			for(var j=0, k = cargoExamenMedico.length; j < k; j++)
			{
				examen.agregarCampos(JSON.stringify(cargoExamenMedico[j]),'L');
			}

		});

	</script>

	

	@if(isset($cargo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($cargo,['route'=>['cargo.destroy',$cargo->idCargo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($cargo,['route'=>['cargo.update',$cargo->idCargo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'cargo.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="cargo-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('codigoCargo', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('codigoCargo', null, ['class'=>'form-control','placeholder'=>'Ingresa el c&oacute;digo','id' => 'codigoCargo'])!!}
							{!!Form::hidden('idCargo', null, array('id' => 'idCargo'))!!}
							{!!Form::hidden('eliminarTarea', '', array('id' => 'eliminarTarea'))!!}
					      	{!!Form::hidden('eliminarVacuna', '', array('id' => 'eliminarVacuna'))!!}
					      	{!!Form::hidden('eliminarElemento', '', array('id' => 'eliminarElemento'))!!}
					      	{!!Form::hidden('eliminarExamen', '', array('id' => 'eliminarExamen'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombreCargo', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombreCargo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('salarioBaseCargo', 'Salario Base', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('salarioBaseCargo',null,['class'=>'form-control','placeholder'=>'Ingresa el salario'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nivelRiesgoCargo', 'Nivel Riesgo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::select('nivelRiesgoCargo',
							array('I'=>'Riesgo I', 'II'=>'Riesgo II', 'III'=>'Riesgo III', 'IV'=>'Riesgo IV', 'V'=>'Riesgo V',), (isset($cargo) ? $cargo->nivelRiesgoCargo : ''),["class" => "form-control", "placeholder" =>"Seleccione el nivel de riesgo"])!!}
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
												<a data-toggle="collapse" data-parent="#accordion" href="#objetivo">Objetivos</a>
											</h4>
										</div>
										<div id="objetivo" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('objetivoCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa los objetivos'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#educacion">Educaci&oacute;n</a>
											</h4>
										</div>
										<div id="educacion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('educacionCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa la educaci&oacute;n'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#experiencia">Experiencia</a>
											</h4>
										</div>
										<div id="experiencia" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('experienciaCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa la experiencia'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#formacion">Formaci&oacute;n</a>
											</h4>
										</div>
										<div id="formacion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('formacionCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa la formaci&oacute;n'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#tema">Tareas de Alto Riesgo</a>
											</h4>
										</div>
										<div id="tema" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="tarea.agregarCampos(valorTarea,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 900px;display:inline-block;height:60px;">Descripci&oacute;n</div>
															<div id="contenedor_tarea">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#examen">Examenes M&eacute;dicos Requeridos</a>
											</h4>
										</div>
										<div id="examen" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="examen.agregarCampos(valorExamen,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Examen</div>
															<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Ingreso</div>
															<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Retiro</div>
															<div class="col-md-1" style="width: 90px;display:inline-block;height:60px;">Peri&oacute;dico</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Periodicidad</div>
															<div id="contenedor_examen">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#vacuna">Vacunas Requeridas</a>
											</h4>
										</div>
										<div id="vacuna" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="vacuna.agregarCampos(valorVacuna,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 900px;display:inline-block;height:60px;">Descripci&oacute;n</div>
															<div id="contenedor_vacuna">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#posicion">Posici&oacute;n Predominante (m&aacute;s del 60% de la jornada)</a>
											</h4>
										</div>
										<div id="posicion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('posicionPredominanteCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa la posici&oacute;n predominante'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#restriccion">Restricciones para el cargo</a>
											</h4>
										</div>
										<div id="restriccion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('restriccionesCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa las restricciones'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#elemento">Elementos de Protecci&oacute;n Personal</a>
											</h4>
										</div>
										<div id="elemento" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="elemento.agregarCampos(valorElemento,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 900px;display:inline-block;height:60px;">Descripci&oacute;n</div>
															<div id="contenedor_elemento">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#habilidad">Habilidades</a>
											</h4>
										</div>
										<div id="habilidad" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('habilidadesCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa las habilidades'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#responsabilidad">Responsabilidades</a>
											</h4>
										</div>
										<div id="responsabilidad" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('responsabilidadesCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa las responsabilidades'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#autoridad">Autoridades</a>
											</h4>
										</div>
										<div id="autoridad" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('autoridadesCargo',null,['class'=>'ckeditor','placeholder'=>'Ingresa las autoridades'])!!}
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
						@if(isset($cargo))
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
@stop