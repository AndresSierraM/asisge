@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Acta Capacitaci&oacute;n</center>
	</h3>
@stop

@section('content')
	@include('alerts.request')

{!!Html::script('js/actacapacitacion.js')!!}

{!!Html::style('css/signature-pad.css'); !!} 


<?php

$firmas = isset($actaCapacitacion->actaCapacitacionAsistentes) ? $actaCapacitacion->actaCapacitacionAsistentes : null;

for ($i=0; $i < count($firmas); $i++) 
{ 

  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  
  // al array de la consulta, le adicionamos 2 valores mas que representan la firma como imagen y como dato base 64, este array lo usamos para llenar el detalle de terceros participantes

  $firmas[$i]["firma"] = ''; 
  $firmas[$i]["firmabase64"] = ''; 
  if(isset($firmas))
  {
    $path = 'imagenes/'.$firmas[$i]["firmaActaCapacitacionAsistente"];
  
    if($firmas[$i]["firmaActaCapacitacionAsistente"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $firmas[$i]["firma"] = 'data:image/' . $type . ';base64,' . base64_encode($data);
      $firmas[$i]["firmabase64"] = 'data:image/' . $type . ';base64,' . base64_encode($data);
      
    }
  }

}



?>


	<script>
		var actaCapacitacionAsistente = '<?php echo (isset($firmas) ? json_encode($firmas) : "");?>';
		actaCapacitacionAsistente = (actaCapacitacionAsistente != '' ? JSON.parse(actaCapacitacionAsistente) : '');

		var actaCapacitacionTema = '<?php echo (isset($firmas) ? json_encode($actaCapacitacion->actaCapacitacionTemas) : "");?>';
		actaCapacitacionTema = (actaCapacitacionTema != '' ? JSON.parse(actaCapacitacionTema) : '');

		
		var valorTema = [0,'',0,'0000-00-00','00:00',0];
		var valorAsistente = [0,0,'','',''];

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
		var eventos1 = ['onclick','fechaDetalle(this.parentNode.id);'];
		var eventos2 = ['onchange','llenarCargo(this);'];

		$(document).ready(function(){


			tema = new Atributos('tema','contenedor_tema','tema');

			tema.altura = '36px;';
			tema.campoid = 'idActaCapacitacionTema';
			tema.campoEliminacion = 'eliminarTema';

			tema.campos = ['PlanCapacitacionTema_idPlanCapacitacionTema', 'idActaCapacitacionTema', 'nombrePlanCapacitacionTema', 'Tercero_idCapacitador', 'fechaActaCapacitacionTema', 'horaActaCapacitacionTema','dictadaActaCapacitacionTema','cumpleObjetivoActaCapacitacionTema'];
			tema.etiqueta = ['input', 'input','input','select','input','input','checkbox','checkbox'];
			tema.tipo = ['hidden', 'hidden','text','','date','time','checkbox','checkbox'];
			tema.estilo = ['', '','width: 250px;height:35px;','width: 250px;height:35px;','width: 130px;height:35px;','width: 110px;height:35px;','width: 70px;height:33px;display:inline-block;','width: 70px;height:33px;display:inline-block;'];
			tema.clase = ['', '','','','','',''];
			tema.sololectura = [false, false,true,false,false,false,false,false];
			tema.completar = ['off', 'off','off','off','off','off','off','off'];
			tema.opciones = ['', '','',tercero,'','','',''];
			tema.funciones  = ['', '','','',eventos1,'','',''];

			asistente = new Atributos('asistente','contenedor_asistente','asistente');

			asistente.altura = '65px;';
			asistente.campoid = 'idActaCapacitacionAsistente';
			asistente.campoEliminacion = 'eliminarAsistente';

			asistente.campos = ['idActaCapacitacionAsistente', 'Tercero_idAsistente', 'nombreCargo','firma','firmabase64'];
			asistente.etiqueta = ['input','select','input','firma','input'];
			asistente.tipo = ['hidden','','text','','hidden'];
			asistente.estilo = ['','width: 400px;height:35px;','width: 300px;height:35px; background-color:rgb(238, 238, 238);', 'width:80px; height: 60px; border: 1px solid; display: inline-block', ''];
			asistente.clase = ['','','','',''];
			asistente.sololectura = [false,false,true,false,false];
			asistente.completar = ['off','off','off','off','off'];
			asistente.opciones = ['',tercero,'', '' ,''];
			asistente.funciones  = ['',eventos2,'', '' ,''];

			for(var j=0, k = actaCapacitacionTema.length; j < k; j++)
			{

				tema.agregarCampos(JSON.stringify(actaCapacitacionTema[j]),'L');
				llenarPlanCapacitacionTema(document.getElementById('PlanCapacitacionTema_idPlanCapacitacionTema'+j));
			}

			for(var j=0, k = actaCapacitacionAsistente.length; j < k; j++)
			{
				asistente.agregarCampos(JSON.stringify(actaCapacitacionAsistente[j]),'L');
				llenarCargo(document.getElementById('Tercero_idAsistente'+j));
			}

			// solo consulta los datos de encabezados, no los temas
			consultarPlanCapacitacion('Basico');

		});

		function fechaDetalle(registro)
		{
			var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
			$('#fechaActaCapacitacionTema'+posicion).datetimepicker(({
				format: "YYYY-MM-DD"
			}));
		}
	</script>
	@if(isset($actaCapacitacion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($actaCapacitacion,['route'=>['actacapacitacion.destroy',$actaCapacitacion->idActaCapacitacion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($actaCapacitacion,['route'=>['actacapacitacion.update',$actaCapacitacion->idActaCapacitacion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'actacapacitacion.store','method'=>'POST'])!!}
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
			<fieldset id="matrizLegal-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('numeroActaCapacitacion', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('numeroActaCapacitacion',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero'])!!}
							{!!Form::hidden('idActaCapacitacion', null, array('id' => 'idActaCapacitacion'))!!}
							{!!Form::hidden('Users_id', 1, array('id' => 'Users_id'))!!}
							{!!Form::hidden('eliminarTema', '', array('id' => 'eliminarTema'))!!}
					      	{!!Form::hidden('eliminarAsistente', '', array('id' => 'eliminarAsistente'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('fechaElaboracionActaCapacitacion', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('fechaElaboracionActaCapacitacion',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('PlanCapacitacion_idPlanCapacitacion', 'Plan Capacitaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::select('PlanCapacitacion_idPlanCapacitacion',
							$planCapacitacion, (isset($actaCapacitacion) ? $actaCapacitacion->PlanCapacitacion_idPlanCapacitacion : 0),["class" => "form-control", "placeholder" =>"Seleccione el plan", 'onchange'=>'consultarPlanCapacitacion(\'Completo\');'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('tipoPlanCapacitacion', 'Tipo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('tipoPlanCapacitacion',null,['class'=>'form-control','placeholder'=>'Tipo','readonly'=>'readonly'])!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('nombreResponsable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombreResponsable',null,['class'=>'form-control','placeholder'=>'Responsable','readonly'=>'readonly'])!!}
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
															<p id="objetivoPlanCapacitacion"></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#personal">Personal Involucrado</a>
											</h4>
										</div>
										<div id="personal" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															<p id="personalInvolucradoPlanCapacitacion"></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#programacion">Programaci&oacute;n</a>
											</h4>
										</div>
										<div id="programacion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::label('fechaInicioPlanCapacitacion', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaInicioPlanCapacitacion',date('Y-m-d'),['class'=>'form-control','placeholder'=>'Fecha Inicio','readonly'=>'readonly'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" id='test'>
													{!!Form::label('fechaFinPlanCapacitacion', 'Fecha Fin', array('class' => 'col-sm-2 control-label'))!!}
													<div class="col-sm-10">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaFinPlanCapacitacion',date('Y-m-d'),['class'=>'form-control','placeholder'=>'Fecha Fin','readonly'=>'readonly'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#metodo">M&eacute;todo de Eficacia</a>
											</h4>
										</div>
										<div id="metodo" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															<p id="metodoEficaciaPlanCapacitacion"></p>
															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#tema">Temas</a>
											</h4>
										</div>
										<div id="tema" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 50px;" >
																<span >&nbsp;</span>
															</div>
															<div class="col-md-1" style="width: 250px;display:inline-block;height:50px;">Descripci&oacute;n</div>
															<div class="col-md-1" style="width: 250px;display:inline-block;height:50px;">Capacitador</div>
															<div class="col-md-1" style="width: 130px;display:inline-block;height:50px;">Fecha</div>
															<div class="col-md-1" style="width: 110px;display:inline-block;height:50px;">Hora</div>
															<div class="col-md-1" style="width: 70px;display:inline-block;height:50px;">Dictado</div>
															<div class="col-md-1" style="width: 70px;display:inline-block;height:50px;">Cumple Objetivo</div>
															<div id="contenedor_tema">
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
												<a data-toggle="collapse" data-parent="#accordion" href="#asistentes">Asistentes</a>
											</h4>
										</div>
										<div id="asistentes" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12" >
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 50px;"  onclick="asistente.agregarCampos(valorAsistente,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 400px;display:inline-block;height:50px;">Nombre</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Cargo</div>
															<div class="col-md-1" style="width: 80px;display:inline-block;height:50px;">Firma</div>
															<div id="contenedor_asistente">
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
						@if(isset($actaCapacitacion))
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
	<script type="text/javascript">

		$('#fechaElaboracionActaCapacitacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));


	  $(document).ready(function()
	  {
	    mostrarFirma();
	  });
		    

	</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}



@stop