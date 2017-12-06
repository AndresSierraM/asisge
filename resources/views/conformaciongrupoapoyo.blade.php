@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Conformaci&oacute;n de <br>Grupos de Apoyo</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')

{!!Html::style('css/signature-pad.css'); !!} 

<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->


<?php

//Se pregunta  si existe el id de conformacion grupo  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
$idConformacionGrupoApoyo = (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->idConformacionGrupoApoyo : 0);


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


		  // Se recibe la consulta de la multigistro para que muestre los datos de los campos en multi Candidatos inscritos
		var conformaciongrupoapoyoInscrito = '<?php echo (isset($ConformacionGrupoApoyoInscrito) ? json_encode($ConformacionGrupoApoyoInscrito) : "");?>';
		conformaciongrupoapoyoInscrito = (conformaciongrupoapoyoInscrito != '' ? JSON.parse(conformaciongrupoapoyoInscrito) : '');



		// Se reciben los datos enviados del controlador
			// Se reciben el id de tercero y nombre tercero para enviarlo al campo tipo select de candidats inscritos
		var idTerceroEmpleados = '<?php echo isset($idTerceroEmpleado) ? $idTerceroEmpleado : "";?>';
		var NombreTerceroEmpleados = '<?php echo isset($NombreTerceroEmpleado) ? $NombreTerceroEmpleado : "";?>';

		var  NombreCandidato = [JSON.parse(idTerceroEmpleados),JSON.parse(NombreTerceroEmpleados)];



		 	// Nombre del evento para llenar multiregistro
	 	var llenarInformacionCandidatos = ['onchange','llenarInformacionCandidato(this)']
	 	var valorInscrito = [0,0,0,'',''];
		


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


			inscrito = new Atributos('inscrito','contenedor_inscrito','inscrito');

			inscrito.altura = '36px;';
			inscrito.campoid = 'idConformacionGrupoApoyoInscrito';
			inscrito.campoEliminacion = 'eliminarInscrito';

			inscrito.campos = ['idConformacionGrupoApoyoInscrito','ConformacionGrupoApoyo_idConformacionGrupoApoyo', 'Tercero_idInscrito', 'nombreCargo','centrocosto'];
			inscrito.etiqueta = ['input','input','select','input','input'];
			inscrito.tipo = ['hidden','hidden','','text','',''];
			inscrito.estilo = ['','','width: 400px;height:35px;','width: 300px;height:35px; background-color:#EEEEEE;','width: 300px;height:35px; background-color:#EEEEEE;'];
			inscrito.clase = ['','','','',''];
			inscrito.sololectura = [false,false,false,true,true];
			inscrito.completar = ['off','off','off','off','off'];
			inscrito.opciones = ['','',NombreCandidato,'', ''];
			inscrito.funciones  = ['','',llenarInformacionCandidatos,'', ''];




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

			for(var j=0, k = conformaciongrupoapoyoInscrito.length; j < k; j++)
			{
				inscrito.agregarCampos(JSON.stringify(conformaciongrupoapoyoInscrito[j]),'L');
				// Se ejecta la funcion para que muestre el cargo y centro de costos 
				llenarInformacionCandidato(document.getElementById('Tercero_idInscrito'+j));
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
			                	<i class="fa fa-flag" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			             	{!!Form::select('GrupoApoyo_idGrupoApoyo',$grupoApoyo, (isset($conformacionGrupoApoyo) ? $conformacionGrupoApoyo->GrupoApoyo_idGrupoApoyo : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el Grupo de Apoyo"])!!}
			              	
			              	{!!Form::hidden('idConformacionGrupoApoyo', null, array('id' => 'idConformacionGrupoApoyo'))!!}
			              	{!!Form::hidden('eliminarJurado', '', array('id' => 'eliminarJurado'))!!}
			              	{!!Form::hidden('eliminarResultado', '', array('id' => 'eliminarResultado'))!!}
			              	{!!Form::hidden('eliminarComite', '', array('id' => 'eliminarComite'))!!}
			              	{!!Form::hidden('eliminarInscrito', '', array('id' => 'eliminarInscrito'))!!}
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
											                	<i class="fa fa-flag" style="width: 14px;"></i>
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
															<div class="col-md-1" style="width: 40px;height: 50px;"  onclick="inscrito.agregarCampos(valorInscrito,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1 requiredMulti" style="width: 400px;display:inline-block;height:50px;">Nombre</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Cargo</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Centro de costos</div>
															<div id="contenedor_inscrito">
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

								                                                              <!-- Nuevo pestaña para adjuntar archivos -->
				                                              <!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
				                      <div class="panel panel-default" style="display:inline-block;width:100%">
				                        <div class="panel-heading">
				                          <h4 class="panel-title">
				                            <a data-toggle="collapse" data-parent="#accordion" href="#archivos">Documentos</a>
				                          </h4>
				                        </div>
				                        <div id="archivos" class="panel-collapse collapse">
				                          <div class="col-sm-12">
				                                        <div class="panel-heading ">
				                                            <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
				                                        </div>
				                                          <div class="panel-body">
				                              <div class="col-sm-12" >
				                                <div id="upload" class="col-md-12">
				                                    <div class="dropzone dropzone-previews" id="dropzoneConformacionGrupoapoyoArchivo" style="overflow: auto;">
				                                    </div>  
				                                </div>  
				                                  <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px; overflow: auto;">   
				                                    {!!Form::hidden('archivoConformaciongrupoApoyoArray', '', array('id' => 'archivoConformaciongrupoApoyoArray'))!!}
				                                    <?php
				                                    
				                                    // Cuando este editando el archivo 
				                                    if ($idConformacionGrupoApoyo != '')  //Se pregunta si el id de acta de capacitacion es diferente de vacio (que es la tabla papá)
				                                    {
				                                      $eliminar = '';
				                                      $archivoSave = DB::Select('SELECT * from conformaciongrupoapoyoarchivo where ConformacionGrupoApoyo_idConformacionGrupoApoyo = '.$idConformacionGrupoApoyo);
				                                      for ($i=0; $i <count($archivoSave) ; $i++) 
				                                      { 
				                                        $archivoS = get_object_vars($archivoSave[$i]);

				                                        echo '<div id="'.$archivoS['idConformacionGrupoApoyoArchivo'].'" class="col-lg-4 col-md-4">
				                                                    <div class="panel panel-yellow" style="border: 1px solid orange;">
				                                                        <div class="panel-heading">
				                                                            <div class="row">
				                                                                <div class="col-xs-3">
				                                                                    <a target="_blank" 
				                                                                      href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaConformacionGrupoApoyoArchivo'].'">
				                                                                      <i class="fa fa-book fa-5x" style="color: gray;"></i>
				                                                                    </a>
				                                                                </div>

				                                                                <div class="col-xs-9 text-right">
				                                                                    <div>'.str_replace('/conformaciongrupoapoyo/','',$archivoS['rutaConformacionGrupoApoyoArchivo']).'
				                                                                    </div>
				                                                                </div>
				                                                            </div>
				                                                        </div>
				                                                        <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idConformacionGrupoApoyoArchivo'].');">
				                                                            <div class="panel-footer">
				                                                                <span class="pull-left">Eliminar Documento</span>
				                                                                <span class="pull-right"><i class="fa fa-times"></i></span>
				                                                                <div class="clearfix"></div>
				                                                            </div>
				                                                        </a>
				                                                    </div>
				                                                </div>';

				                                        echo '<input type="hidden" id="idConformacionGrupoApoyoArchivo[]" name="idConformacionGrupoApoyoArchivo[]" value="'.$archivoS['idConformacionGrupoApoyoArchivo'].'" >

				                                        <input type="hidden" id="rutaConformacionGrupoApoyoArchivo[]" name="rutaConformacionGrupoApoyoArchivo[]" value="'.$archivoS['rutaConformacionGrupoApoyoArchivo'].'" >';
				                                      }

				                                      echo '<input type="hidden" name="eliminarArchivo" id="eliminarArchivo" value="">';
				                                    }
				                                              
				                                    ?>              
				                                  </div>
				                              </div>
				                            </div>                        
				                          </div>
				                        </div>
				                      </div>

				                       <!--  Funciones el grupo de apoyo -->
			                     	<div class="panel panel-default">
				                      	<div class="panel-heading">
					                        <h4 class="panel-title">
					                          <a data-toggle="collapse" data-parent="#accordion" href="#funcionesgrupo">Funciones del grupo de apoyo</a>
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

<script>
    //--------------------------------- DROPZONE ---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneConformacionGrupoapoyoArchivo", {
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

    document.getElementById('archivoConformaciongrupoApoyoArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('archivoConformaciongrupoApoyoArray').value += file.name+',';
                        // console.log(document.getElementById('archivoConformaciongrupoApoyoArray').value);
                        i++;
                    });


// Se hace una funcion para que elimine los archivos que estan subidos en el dropzone y estan siendo mostrados en la preview
function eliminarDiv(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarArchivo").val( $("#eliminarArchivo").val() + idDiv + ",");  
    }
}

</script>
	{!!Html::script('js/signature_pad.js'); !!}
	{!!Html::script('js/app.js'); !!}
@stop