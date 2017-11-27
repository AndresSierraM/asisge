@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Conformaci&oacute;n de <br>Grupos de Apoyo</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')

{!!Html::style('css/signature-pad.css'); !!} 


<?php

$firmas = isset($actaGrupoApoyo->actaGrupoApoyoTercero) ? $actaGrupoApoyo->actaGrupoApoyoTercero : null;

for ($i=0; $i < count($firmas); $i++) 
{ 

  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  
  // al array de la consulta, le adicionamos 2 valores mas que representan la firma como imagen y como dato base 64, este array lo usamos para llenar el detalle de terceros participantes

  $firmas[$i]["firma"] = ''; 
  $firmas[$i]["firmabase64"] = ''; 
  if(isset($firmas))
  {
    $path = 'imagenes/'.$firmas[$i]["firmaConformacionGrupoApoyoJurado"];
  
    if($firmas[$i]["firmaConformacionGrupoApoyoJurado"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $firmas[$i]["firma"] = 'data:image/' . $type . ';base64,' . base64_encode($data);
      $firmas[$i]["firmabase64"] = 'data:image/' . $type . ';base64,' . base64_encode($data);
      
    }
  }

}

  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
$base64 = ''; 
  if(isset($entregaelementoproteccion))
  {
    $path = 'imagenes/'.$entregaelementoproteccion["firmaTerceroEntregaElementoProteccion"];
    
    if($entregaelementoproteccion["firmaTerceroEntregaElementoProteccion"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
  }

?>


	{!!Html::script('js/conformaciongrupoapoyo.js')!!}

	<script>

		var conformacionGrupoApoyoComite = '<?php echo (isset($conformacionGrupoApoyo) ? json_encode($conformacionGrupoApoyo->conformacionGrupoApoyoComites) : "");?>';
		conformacionGrupoApoyoComite = (conformacionGrupoApoyoComite != '' ? JSON.parse(conformacionGrupoApoyoComite) : '');
		
		var conformacionGrupoApoyoJurado = '<?php echo (isset($conformacionGrupoApoyo) ? json_encode($conformacionGrupoApoyo->conformacionGrupoApoyoJurados) : "");?>';
		conformacionGrupoApoyoJurado = (conformacionGrupoApoyoJurado != '' ? JSON.parse(conformacionGrupoApoyoJurado) : '');

		var conformacionGrupoApoyoResultado = '<?php echo (isset($conformacionGrupoApoyo) ? json_encode($conformacionGrupoApoyo->conformacionGrupoApoyoResultados) : "");?>';
		conformacionGrupoApoyoResultado = (conformacionGrupoApoyoResultado != '' ? JSON.parse(conformacionGrupoApoyoResultado) : '');



		// Se reciben los datos enviados del controlador
			// Se reciben el id de tercero y nombre tercero para enviarlo al campo tipo select de candidats inscritos
		var idTerceroEmpleados = '<?php echo isset($idTerceroEmpleado) ? $idTerceroEmpleado : "";?>';
		var NombreTerceroEmpleados = '<?php echo isset($NombreTerceroEmpleado) ? $NombreTerceroEmpleado : "";?>';

		var  NombreCandidato = [JSON.parse(idTerceroEmpleados),JSON.parse(NombreTerceroEmpleados)];



		 	// Nombre del evento para llenar multiregistro
	 	var llenarInformacionCandidatos = ['onchange','llenarInformacionCandidato(this)']
	 	var valorCandidato = [0,0,'',''];
		


		var valorJurado = [0,'','',''];
		var valorResultado = [0,'',0];
		var valorElemento = [0,''];
		var valorExamen = [0,'',0,0,0,''];


		var idTercero = '<?php echo isset($idTercero) ? $idTercero : 0;?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
		
		var listaTercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
	

 		valorComite = Array('E','T');
 		nombreComite = Array ('Empresa','Trabajadores');

	 	listaComite = [valorComite,nombreComite];




		$(document).ready(function()
		{
			jurado = new Atributos('jurado','contenedor_jurado','jurado');

			jurado.altura = '36px;';
		    jurado.campoid = 'idConformacionGrupoApoyoJurado';
		    jurado.campoEliminacion = 'eliminarJurado';

			jurado.campos = ['idConformacionGrupoApoyoJurado', 'Tercero_idJurado','firma','firmabase64'];
			jurado.etiqueta = ['input','select','firma','input'];
			jurado.tipo = ['hidden','','','hidden'];
			jurado.estilo = ['','width:900px;height:35px;', 'width:100px; height: 35px; border: 1px solid; display: inline-block', ''];
			jurado.clase = ['','','',''];
			jurado.sololectura = [false,false,false,false];
			jurado.completar = ['off','off','off','off'];
			jurado.opciones = ['',listaTercero,'',''];
			jurado.funciones  = ['','','',''];

			resultado = new Atributos('resultado','contenedor_resultado','resultado');

			resultado.altura = '36px;';
    		resultado.campoid = 'idConformacionGrupoApoyoResultado';
    		resultado.campoEliminacion = 'eliminarResultado';

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

			comite.altura = '36px;';
		    comite.campoid = 'idConformacionGrupoApoyoComite';
		    comite.campoEliminacion = 'eliminarComite';

			comite.campos = ['idConformacionGrupoApoyoComite', 'nombradoPorConformacionGrupoApoyoComite','Tercero_idPrincipal','Tercero_idSuplente'];
			comite.etiqueta = ['input','select','select','select'];
			comite.tipo = ['hidden','','',''];
			comite.estilo = ['','width: 260px;height:35px;','width: 380px;height:35px;','width: 380px;height:35px;'];
			comite.clase = ['','','',''];
			comite.sololectura = [false,false,false,false];
			comite.completar = ['off','off','off','off'];
			comite.opciones = ['',listaComite,listaTercero,listaTercero];
			comite.funciones  = ['','','',''];

			// Multiregistro Candidatos Inscritos


			candidato = new Atributos('candidato','contenedor_candidato','i');

			candidato.altura = '36px;';
			candidato.campoid = 'idActaCapacitacionAsistente';
			candidato.campoEliminacion = 'eliminarAsistente';

			candidato.campos = ['idActaCapacitacionAsistente', 'nombreCandidatoConformacionActaGrupoApoyo', 'nombreCargo','centrocosto'];
			candidato.etiqueta = ['input','select','input','input'];
			candidato.tipo = ['hidden','','text','',''];
			candidato.estilo = ['','width: 400px;height:35px;','width: 300px;height:35px; background-color:#EEEEEE;','width: 300px;height:35px; background-color:#EEEEEE;'];
			candidato.clase = ['','','',''];
			candidato.sololectura = [false,false,true,true];
			candidato.completar = ['off','off','off','off'];
			candidato.opciones = ['',NombreCandidato,'', ''];
			candidato.funciones  = ['',llenarInformacionCandidatos,'', ''];




			// Nueva multiregistro Candidatos inscritos

			
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

		<div id="form_section">
			<fieldset id="cargo-form-fieldset">
				<div class="form-group required" id='test'>
					{!!Form::label('GrupoApoyo_idGrupoApoyo', 'Grupo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			             	{!!Form::select('GrupoApoyo_idGrupoApoyo',$grupoApoyo, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->GrupoApoyo_idGrupoApoyo : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Grupo de Apoyo"])!!}
			              	
			              	{!!Form::hidden('idConformacionGrupoApoyo', null, array('id' => 'idConformacionGrupoApoyo'))!!}
			              	{!!Form::hidden('eliminarJurado', '', array('id' => 'eliminarJurado'))!!}
			              	{!!Form::hidden('eliminarResultado', '', array('id' => 'eliminarResultado'))!!}
			              	{!!Form::hidden('eliminarComite', '', array('id' => 'eliminarComite'))!!}
						</div>
					</div>
					
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('nombreConformacionGrupoApoyo', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombreConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
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
												<div class="form-group required" id='test'>
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
													{!!Form::label('fechaVotacionConformacionGrupoApoyo', 'Fecha Votaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaVotacionConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
														</div>
													</div>
												</div>
												<div class="form-group required" id='test'>
													{!!Form::label('Tercero_idGerente', 'Gerente General', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
											            <div class="input-group">
											              	<span class="input-group-addon">
											                	<i class="fa fa-flag" style="width: 14px;"></i>
											              	</span>
											              	{!!Form::select('Tercero_idGerente',$tercero, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->Tercero_idGerente : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Gerente General"])!!}
														</div>
													</div>
												</div>
												
											</div>
										</div>
									</div>
									 <!-- Acordeon Convocatoria votaci&oacute;n -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#convocatoriavotacion">Convocatoria votaci&oacute;n</a>
					                        </h4>
				                      	</div>
				                      	<div id="convocatoriavotacion" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('convocatoriaVotacionConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
					                              </div>
					                            </div>
					                          </div>
					                        </div>
				                      	</div>
				                    </div>
				                     <!--  Acta de escrutinio y votaci&acute;n -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#escrutinio">Acta de escrutinio y votaci&oacute;n</a>
					                        </h4>
				                      	</div>
				                      	<div id="escrutinio" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('actaEscrutinioConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
					                              </div>
					                            </div>
					                          </div>
					                        </div>
				                      	</div>
				                    </div>
				                    <!-- Candidatos Inscritos -->
				                    <div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#candidatoinscrito">Candidatos Inscritos</a>
											</h4>
										</div>
										<div id="candidatoinscrito" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12" >
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 50px;"  onclick="candidato.agregarCampos(valorCandidato,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 400px;display:inline-block;height:50px;">Nombre</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Cargo</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Centro de costos</div>
															<div id="contenedor_candidato">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#votacion">Actas de votaci&oacute;n</a>
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
															<div class="col-md-1 requiredMulti" style="width: 900px;display:inline-block;height:50px;">Jurado</div>
															<div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Firma</div>
															<div id="contenedor_jurado">
															</div>
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-12" style="display:inline-block;height:40px;">Resultado de la Votaci&oacute;n</div>
															<div class="col-md-1" style="width: 40px;height: 50px;" onclick="resultado.agregarCampos(valorResultado,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 800px;display:inline-block;height:50px;">Nombre</div>
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
															<div class="col-md-12" style="display:inline-block;height:40px;">Integrantes del Comit&eacute;</div>
															<div class="col-md-1" style="width: 40px;height: 50px;" onclick="comite.agregarCampos(valorComite,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 260px;display:inline-block;height:50px;">Nombrado por</div>
															<div class="col-md-1" style="width: 380px;display:inline-block;height:50px;">Principal</div>
															<div class="col-md-1" style="width: 380px;display:inline-block;height:50px;">Suplentes</div>
															<div id="contenedor_comite">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									   <!--  Acta Cierre -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#cierreacta">Acta de cierre</a>
					                        </h4>
				                      	</div>
				                      	<div id="cierreacta" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('actaCierreConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
					                              </div>
					                            </div>
					                          </div>
					                        </div>
				                      	</div>
				                    </div>
				                      <!--  Acta conformacion -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#conformacionacta">Acta de conformaci&oacute;n</a>
					                        </h4>
				                      	</div>
				                      	<div id="conformacionacta" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('actaConformacionConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
					                              </div>
					                            </div>
					                          </div>
					                        </div>
				                      	</div>
				                    </div>
				                        <!--  Acta de escrutinio y votaci&acute;n -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#Documentos" style="background-color: red">Documentos(FALTA)</a>
					                        </h4>
				                      	</div>
				                      	<!-- Codigo aquí -->
					     
				                    </div>
				                       <!--  Funciones el grupo de apoyo -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#funcionesgrupo">Funciones el grupo de apoyo</a>
					                        </h4>
				                      	</div>
				                      	<div id="funcionesgrupo" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('funcionesGrupoConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
					                              </div>
					                            </div>
					                          </div>
					                        </div>
				                      	</div>
				                    </div>
				                           <!--  Funciones del presidente -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#presidente">Funciones del presidente</a>
					                        </h4>
				                      	</div>
				                      	<div id="presidente" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('funcionesPresidenteConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
					                              </div>
					                            </div>
					                          </div>
					                        </div>
				                      	</div>
				                    </div>

				                       <!--  Funciones del  secretario -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#funcionessecretario">Funciones del secretario</a>
					                        </h4>
				                      	</div>
				                      	<div id="funcionessecretario" class="panel-collapse collapse">
					                        <div class="panel-body">
					                          <div class="form-group" id='test'>
					                            <div class="col-sm-10">
					                              <div class="input-group">
					                                <span class="input-group-addon">
					                                  <i class="fa fa-pencil-square-o "></i>
					                                </span>
					                                {!!Form::textarea('funcionesSecretarioConformacionGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
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


	 	CKEDITOR.replace(('convocatoriaVotacionConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 


	 	CKEDITOR.replace(('actaEscrutinioConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 


	 	CKEDITOR.replace(('actaCierreConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 



  		CKEDITOR.replace(('actaConformacionConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 


  		CKEDITOR.replace(('funcionesGrupoConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 

  		CKEDITOR.replace(('funcionesPresidenteConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 
  		CKEDITOR.replace(('funcionesSecretarioConformacionGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
  		}); 


	  $(document).ready(function()
	  {
	    mostrarFirma();
	  });
	</script>
	{!!Html::script('js/signature_pad.js'); !!}
	{!!Html::script('js/app.js'); !!}
@stop