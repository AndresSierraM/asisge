@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Conformaci&oacute;n de <br>Grupos de Apoyo</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	<script>

		var conformacionGrupoApoyoComite = '<?php echo (isset($conformacionGrupoApoyo) ? json_encode($conformacionGrupoApoyo->conformacionGrupoApoyoComites) : "");?>';
		conformacionGrupoApoyoComite = (conformacionGrupoApoyoComite != '' ? JSON.parse(conformacionGrupoApoyoComite) : '');
		
		var conformacionGrupoApoyoJurado = '<?php echo (isset($conformacionGrupoApoyo) ? json_encode($conformacionGrupoApoyo->conformacionGrupoApoyoJurados) : "");?>';
		conformacionGrupoApoyoJurado = (conformacionGrupoApoyoJurado != '' ? JSON.parse(conformacionGrupoApoyoJurado) : '');

		var conformacionGrupoApoyoResultado = '<?php echo (isset($conformacionGrupoApoyo) ? json_encode($conformacionGrupoApoyo->conformacionGrupoApoyoResultados) : "");?>';
		conformacionGrupoApoyoResultado = (conformacionGrupoApoyoResultado != '' ? JSON.parse(conformacionGrupoApoyoResultado) : '');

		var valorJurado = [0,''];
		var valorResultado = [0,'',0];
		var valorElemento = [0,''];
		var valorExamen = [0,'',0,0,0,''];

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : 0;?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
		
		var listaTercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
		var valorComite = ['E','T'];
		var nombreComite = ['Empresa','Trabajadores'];
		var listaComite = [valorComite,nombreComite];
		
		$(document).ready(function()
		{
			jurado = new Atributos('jurado','contenedor_jurado','jurado');
			jurado.campos = ['idConformacionGrupoApoyoJurado', 'Tercero_idJurado'];
			jurado.etiqueta = ['input','select'];
			jurado.tipo = ['hidden',''];
			jurado.estilo = ['','width:1000px;height:35px;'];
			jurado.clase = ['',''];
			jurado.sololectura = [false,false];
			jurado.completar = ['off','off'];
			jurado.opciones = ['',listaTercero];
			jurado.funciones  = ['',''];

			resultado = new Atributos('resultado','contenedor_resultado','resultado');
			resultado.campos = ['idConformacionGrupoApoyoResultado', 'Tercero_idCandidato','votosConformacionGrupoApoyoResultado'];
			resultado.etiqueta = ['input','select','input'];
			resultado.tipo = ['hidden','','text'];
			resultado.estilo = ['','width: 800px;height:35px;','width:200px;height:35px;'];
			resultado.clase = ['','',''];
			resultado.sololectura = [false,false,false];
			resultado.completar = ['off','off','off'];
			resultado.opciones = ['',listaTercero,''];
			resultado.funciones  = ['','',''];

			comite = new Atributos('comite','contenedor_comite','comite');
			comite.campos = ['idConformacionGrupoApoyoComite', 'nombradoPorConformacionGrupoApoyoComite','Tercero_idPrincipal','Tercero_idSuplente'];
			comite.etiqueta = ['input','select','select','select'];
			comite.tipo = ['hidden','','',''];
			comite.estilo = ['','width: 200px;height:35px;','width: 400px;height:35px;','width: 400px;height:35px;'];
			comite.clase = ['','','',''];
			comite.sololectura = [false,false,false,false];
			comite.completar = ['off','off','off','off'];
			comite.opciones = ['',listaComite,listaTercero,listaTercero];
			comite.funciones  = ['','','',''];

			
			for(var j=0, k = conformacionGrupoApoyoComite.length; j < k; j++)
			{
				comite.agregarCampos(JSON.stringify(conformacionGrupoApoyoComite[j]),'L');
			}

			for(var j=0, k = conformacionGrupoApoyoJurado.length; j < k; j++)
			{
				jurado.agregarCampos(JSON.stringify(conformacionGrupoApoyoJurado[j]),'L');
			}

			for(var j=0, k = conformacionGrupoApoyoResultado.length; j < k; j++)
			{
				resultado.agregarCampos(JSON.stringify(conformacionGrupoApoyoResultado[j]),'L');
			}

		});

	</script>

	

	@if(isset($conformacionGrupoApoyo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($conformacionGrupoApoyo,['route'=>['conformaciongrupoapoyo.destroy',$conformacionGrupoApoyo->idConformacionGrupoApoyo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($conformacionGrupoApoyo,['route'=>['conformaciongrupoapoyo.update',$conformacionGrupoApoyo->idConformacionGrupoApoyo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'conformaciongrupoapoyo.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="cargo-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('GrupoApoyo_idGrupoApoyo', 'Pais', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
			              	{!!Form::hidden('idConformacionGrupoApoyo', null, array('id' => 'idConformacionGrupoApoyo'))!!}
							{!!Form::select('GrupoApoyo_idGrupoApoyo',$grupoApoyo, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->GrupoApoyo_idGrupoApoyo : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Grupo de Apoyo"])!!}
						</div>
					</div>
					
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombreConformacionGrupoApoyo', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombreConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('fechaConformacionGrupoApoyo', 'Fecha de Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('fechaConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
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
												<a data-toggle="collapse" data-parent="#accordion" href="#convocatoria">Convocatoria</a>
											</h4>
										</div>
										<div id="convocatoria" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::label('fechaConvocatoriaConformacionGrupoApoyo', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaConvocatoriaConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('Tercero_idRepresentante', 'Representante', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
											            <div class="input-group">
											              	<span class="input-group-addon">
											                	<i class="fa fa-flag"></i>
											              	</span>
											              	{!!Form::select('Tercero_idRepresentante',$tercero, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->Tercero_idRepresentante : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Representante"])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('fechaVotacionConformacionGrupoApoyo', 'Fecha de Votaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaVotacionConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('Tercero_idGerente', 'Gerente General', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
											            <div class="input-group">
											              	<span class="input-group-addon">
											                	<i class="fa fa-flag"></i>
											              	</span>
											              	{!!Form::select('Tercero_idGerente',$tercero, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->Tercero_idGerente : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Gerente General"])!!}
														</div>
													</div>
												</div>
												
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#votacion">Actas de Votaci&oacute;n</a>
											</h4>
										</div>
										<div id="votacion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::label('fechaActaConformacionGrupoApoyo', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaActaConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('horaActaConformacionGrupoApoyo', 'Hora', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('horaActaConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('fechaInicioConformacionGrupoApoyo', 'Inicio del Periodo', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaInicioConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('fechaFinConformacionGrupoApoyo', 'Fin del Periodo', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaFinConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 50px;" onclick="jurado.agregarCampos(valorJurado,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 1000px;display:inline-block;height:50px;">Jurado</div>
															<div id="contenedor_jurado">
															</div>
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 1040px;display:inline-block;height:40px;">Resultado de la Votaci&oacute;n</div>
															<div class="col-md-1" style="width: 40px;height: 50px;" onclick="resultado.agregarCampos(valorResultado,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 800px;display:inline-block;height:50px;">Nombre</div>
															<div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Votos</div>
															<div id="contenedor_resultado">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#constitucion">Constituci&oacute;n</a>
											</h4>
										</div>
										<div id="constitucion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::label('fechaConstitucionConformacionGrupoApoyo', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaConstitucionConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('Tercero_idPresidente', 'Presidente', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
											            <div class="input-group">
											              	<span class="input-group-addon">
											                	<i class="fa fa-flag"></i>
											              	</span>
											              	{!!Form::select('Tercero_idPresidente',$tercero, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->Tercero_idPresidente : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Representante"])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('Tercero_idSecretario', 'Secretario', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
											            <div class="input-group">
											              	<span class="input-group-addon">
											                	<i class="fa fa-flag"></i>
											              	</span>
											              	{!!Form::select('Tercero_idSecretario',$tercero, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->Tercero_idSecretario : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Representante"])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 1040px;display:inline-block;height:40px;">Integrantes del Comit&eacute;</div>
															<div class="col-md-1" style="width: 40px;height: 50px;" onclick="comite.agregarCampos(valorComite,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 200px;display:inline-block;height:50px;">Nombrado por</div>
															<div class="col-md-1" style="width: 400px;display:inline-block;height:50px;">Principal</div>
															<div class="col-md-1" style="width: 400px;display:inline-block;height:50px;">Suplentes</div>
															<div id="contenedor_comite">
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
						@if(isset($conformacionGrupoApoyo))
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
	<script>
		$('#fechaConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
		$('#fechaConvocatoriaConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
		$('#fechaActaConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
		$('#fechaVotacionConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
		$('#fechaInicioConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
		$('#fechaFinConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
		$('#fechaConstitucionConformacionGrupoApoyo').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
	</script>
@stop