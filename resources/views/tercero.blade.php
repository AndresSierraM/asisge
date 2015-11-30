@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Terceros</center>
	</h3>
@stop
@section('content')
@include('alerts.request')
	{!!Html::script('js/tercero.js')!!}
	<script>
		
		var terceroContactos = '<?php echo (isset($tercero) ? json_encode($tercero->terceroContactos) : "");?>';
		terceroContactos = (terceroContactos != '' ? JSON.parse(terceroContactos) : '');
		var terceroProductos = '<?php echo (isset($tercero) ? json_encode($tercero->terceroProductos) : "");?>';
		terceroProductos = (terceroProductos != '' ? JSON.parse(terceroProductos) : '');
		var terceroExamenMedico = '<?php echo (isset($tercero) ? json_encode($tercero->terceroExamenMedicos) : "");?>';
		terceroExamenMedico = (terceroExamenMedico != '' ? JSON.parse(terceroExamenMedico) : '');
		var terceroArchivo = '<?php echo (isset($tercero) ? json_encode($tercero->terceroarchivos) : "");?>';
		terceroArchivo = (terceroArchivo != '' ? JSON.parse(terceroArchivo) : '');
		var valorContactos = [0,'','','','',''];
		var valorProductos = [0,'',''];
		var valorExamen = [0,'',0,0,0,''];
		var valorArchivo = [0,'','',''];


		var idListaTarea = '<?php echo isset($idListaTarea) ? $idListaTarea : 0;?>';
		var nombreListaTarea = '<?php echo isset($nombreListaTarea) ? $nombreListaTarea : "";?>';
		var idFrecuenciaMedicion = '<?php echo isset($idFrecuenciaMedicion) ? $idFrecuenciaMedicion : 0;?>';
		var nombreFrecuenciaMedicion = '<?php echo isset($nombreFrecuenciaMedicion) ? $nombreFrecuenciaMedicion : "";?>';
		
		var listaTarea = [JSON.parse(idListaTarea),JSON.parse(nombreListaTarea)];
		var frencuenciaMedicion = [JSON.parse(idFrecuenciaMedicion),JSON.parse(nombreFrecuenciaMedicion)];

		$(document).ready(function(){

			seleccionarTipoTercero();

			contactos = new Atributos('contactos','contenedor_contactos','contactos_');
			contactos.campos = ['idTerceroContacto','nombreTerceroContacto','cargoTerceroContacto','telefonoTerceroContacto','movilTerceroContacto','correoElectronicoTerceroContacto'];
			contactos.etiqueta = ['input','input','input','input','input','input'];
			contactos.tipo = ['hidden','text','text','text','text','text'];
			contactos.estilo = ['','width: 330px; height:35px;','width: 270px;height:35px;','width: 150px;height:35px;','width: 150px;height:35px;','width: 230px;height:35px;'];
			contactos.clase = ['','','','','',''];
			contactos.sololectura = [false,false,false,false,false,false];

			productos = new Atributos('productos','contenedor_productos','productos_');
			productos.campos = ['idTerceroProducto','codigoTerceroProducto','nombreTerceroProducto'];
			productos.etiqueta = ['input','input','input'];
			productos.tipo = ['hidden','text','text'];
			productos.estilo = ['','width: 380px; height:35px;','width: 750px;height:35px;'];
			productos.clase = ['','',''];
			productos.sololectura = [false,false,false];

			examen = new Atributos('examen','contenedor_examen','examen');
			examen.campos = ['idTerceroExamenMedico', 'ListaGeneral_idExamenMedico','ingresoTerceroExamenMedico','retiroTerceroExamenMedico','periodicoTerceroExamenMedico','FrecuenciaMedicion_idFrecuenciaMedicion'];
			examen.etiqueta = ['input','select','checkbox','checkbox','checkbox','select'];
			examen.tipo = ['hidden','','checkbox','checkbox','checkbox',''];
			examen.estilo = ['','width: 300px;height:35px;','width: 90px;height:33px;display:inline-block;','width: 90px;height:33px;display:inline-block;','width: 90px;height:33px;display:inline-block;','width: 300px;height:35px;'];
			examen.clase = ['','','','','',''];
			examen.sololectura = [false,false,false,false,false,false];
			examen.completar = ['off','off','off','off','off','off'];
			examen.opciones = ['',listaTarea,'','','',frencuenciaMedicion];
			examen.funciones  = ['','','','','',''];

			archivo = new Atributos('archivo','contenedor_archivo','archivo');
			archivo.campos = ['idTerceroArchivo', 'tituloTerceroArchivo','fechaTerceroArchivo','rutaTerceroArchivo'];
			archivo.etiqueta = ['input','input','input','input'];
			archivo.tipo = ['hidden','text','text','text'];
			archivo.estilo = ['','width: 300px;height:35px;','width: 200px;height:35px;','width: 600px;height:35px;'];
			archivo.clase = ['','','','',];
			archivo.sololectura = [false,false,false,false];
			archivo.completar = ['off','off','off','off'];
			archivo.opciones = ['','','',''];
			archivo.funciones  = ['','','',''];


			for(var j=0, k = terceroContactos.length; j < k; j++)
			{
				contactos.agregarCampos(JSON.stringify(terceroContactos[j]),'L');
			}

			for(var j=0, k = terceroProductos.length; j < k; j++)
			{
				productos.agregarCampos(JSON.stringify(terceroProductos[j]),'L');
			}

			for(var j=0, k = terceroExamenMedico.length; j < k; j++)
			{
				examen.agregarCampos(JSON.stringify(terceroExamenMedico[j]),'L');
			}

			for(var j=0, k = terceroArchivo.length; j < k; j++)
			{
				archivo.agregarCampos(JSON.stringify(terceroArchivo[j]),'L');
			}

			

		});
	</script>
	@if(isset($tercero))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tercero,['route'=>['tercero.destroy',$tercero->idTercero],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($tercero,['route'=>['tercero.update',$tercero->idTercero],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tercero.store','method'=>'POST', 'files' => true])!!}
	@endif

		<div id="form_section">
			<fieldset id="tercero-form-fieldset">
				<table width="100%">
					<tr>
						<td>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('TipoIdentificacion_idTipoIdentificacion', 'Tipo de Identificaci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-credit-card" style="width: 14px;"></i>
										</span>
										{!! Form::hidden('idTercero', null, array('id' => 'idTercero')) !!}
										{!! Form::hidden('Compania_idCompania', null, array('id' => 'Compania_idCompania')) !!}
										{!!Form::select('TipoIdentificacion_idTipoIdentificacion',$tipoIdentificacion, (isset($tercero) ? $tercero->TipoIdentificacion_idTipoIdentificacion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de identificaci&oacute;n",'style'=>'width:300px;'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline; " >
								{!!Form::label('documentoTercero', 'Documento No.', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group" >
										<span class="input-group-addon">
											<i class="fa fa-barcode" style="width: 14px;"></i>
										</span>
										{!!Form::text('documentoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero de documento','style'=>'width:300px;'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('nombre1Tercero', 'Primer Nombre', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
										</span>
										{!!Form::text('nombre1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el primer nombre del tercero','style'=>'width:300px;','id'=>'nombre1Tercero', 'onchange'=>'llenaNombreTercero()'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('nombre2Tercero', 'Segundo Nombre', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
										</span>
										{!!Form::text('nombre2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el segundo nombre del tercero','style'=>'width:300px;','id'=>'nombre2Tercero', 'onchange'=>'llenaNombreTercero()'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('apellido1Tercero', 'Primer Apellido', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
										</span>
										{!!Form::text('apellido1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el primer apellido del tercero','style'=>'width:300px;','id'=>'apellido1Tercero', 'onchange'=>'llenaNombreTercero()'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('apellido2Tercero', 'Segundo Apellido', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
										</span>
										{!!Form::text('apellido2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el segundo apellido del tercero','style'=>'width:300px;','id'=>'apellido2Tercero', 'onchange'=>'llenaNombreTercero()'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:1000px; display: inline;">
								{!!Form::label('nombreCompletoTercero', 'Nombre Completo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:820px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-navicon" style="width: 14px;"></i>
										</span>
										{!!Form::text('nombreCompletoTercero',null,['class'=>'form-control','placeholder'=>'Nombre completo del Tercero','style'=>'width:820px;','readonly'=>true])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('fechaCreacionTercero', 'Fecha Creaci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar" style="width: 14px;"></i>
										</span>
										{!!Form::text('fechaCreacionTercero',date('Y-m-d'),['class'=>'form-control','placeholder'=>'Ingresa la fecha creaci&oacute;n del tercero','style'=>'width:300px;','readonly'=>true])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;">
								{!!Form::label('estadoTercero', 'Estado', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-bar-chart-o" style="width: 14px;"></i>
										</span>
										{!!Form::select('estadoTercero',array('ACTIVO'=>'Activo','INACTIVO'=>'Inactivo'),(isset($tercero) ? $tercero->estadoTercero : 0),["class" => "chosen-select form-control",'style'=>'width:300px;'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:1000px; display: inline;">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											{!! Form::hidden('tipoTercero', null, array('id' => 'tipoTercero')) !!}
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','01',false, array('id' => 'tipoTercero1', 'onclick'=>'validarTipoTercero()'))!!}Empleado
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','02',false, array('id' => 'tipoTercero2', 'onclick'=>'validarTipoTercero()'))!!}Proveedor
												</label>
											</div>
											<div class="checkbox-inline" style="display:none;">
												<label>
													{!!Form::hidden('tipoTercero1','03',false, array('id' => 'tipoTercero3', 'onclick'=>'validarTipoTercero()'))!!}Cliente
												</label>
											</div>
											<div class="checkbox-inline" style="display:none;">
												<label>
													{!!Form::hidden('tipoTercero1','04',false, array('id' => 'tipoTercero4', 'onclick'=>'validarTipoTercero()'))!!}Entidad Estatal
												</label>
											</div>
											<div class="checkbox-inline" style="display:none;">
												<label>
													{!!Form::hidden('tipoTercero1','05',false, array('id' => 'tipoTercero5', 'onclick'=>'validarTipoTercero()'))!!}Seguridad Social
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>
							<div class="form-group" style="width:250px; display: inline;" >
								<div class="col-sm-10" style="width:250px;">
									<div class="panel panel-default">
										<input id="imagenTercero" name="imagenTercero" type="file" >
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<div class="form-group">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Detalles</div>
							<div class="panel-body">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Datos Generales</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" style="width:600px; display: inline;" >
													{!!Form::label('Ciudad_idCiudad', 'Ciudad', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group" >
															<span class="input-group-addon">
																<i class="fa fa-flag" style="width: 14px;"></i>
															</span>
															{!!Form::select('Ciudad_idCiudad',$ciudad, (isset($tercero) ? $tercero->Ciudad_idCiudad : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la ciudad",'style'=>'width:340px;'])!!}

														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('direccionTercero', 'Direcci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-home" style="width: 14px;"></i>
															</span>
															{!!Form::text('direccionTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la direcci&oacute;n','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('telefonoTercero', 'Tel&eacute;fono', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-phone" style="width: 14px;"></i>
															</span>
															{!!Form::text('telefonoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero de tel&eacute;fono','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('faxTercero', 'Fax', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-fax" style="width: 14px;"></i>
															</span>
															{!!Form::text('faxTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el fax','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('movil1Tercero', 'M&oacute;vil 1', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile-phone" style="width: 14px;"></i>
															</span>
															{!!Form::text('movil1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 1','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('movil2Tercero', 'M&oacute;vil 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile" style="width: 14px;"></i>
															</span>
															{!!Form::text('movil2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 2','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('sexoTercero', 'Sexo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('sexoTercero',
															array('F'=>'Femenino','M'=>'Masculino'), 
															(isset($tercero) ? $tercero->sexoTercero : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el sexo del tercero",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaNacimientoTercero', 'Fecha Nacimiento', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-calendar" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaNacimientoTercero',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de nacimiento', 'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('correoElectronicoTercero', 'Correo Electr&oacute;nico', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-envelope" style="width: 14px;"></i>
															</span>
															{!!Form::text('correoElectronicoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el correo','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('paginaWebTercero', 'P&aacute;gina Web', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-laptop" style="width: 14px;"></i>
															</span>
															{!!Form::text('paginaWebTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la p&aacute;gina web','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: none;" id="cargo">
													{!!Form::label('Cargo_idCargo', 'Cargo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile" style="width: 14px;"></i>
															</span>
															{!!Form::select('Cargo_idCargo',$cargo, (isset($tercero) ? $tercero->Cargo_idCargo : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el cargo",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default" style="display:none;" id="pestanaLaboral">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#laboral">Informaci&oacute;n Laboral</a>
											</h4>
										</div>
										<div id="laboral" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaNacimientoTerceroInformacion', 'Fecha Nacimiento', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-phone" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaNacimientoTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->fechaNacimientoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero de tel&eacute;fono','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaIngresoTerceroInformacion', 'Fecha Ingreso', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-fax" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaIngresoTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->fechaIngresoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Seleccione la fecha de ingreso','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaRetiroTerceroInformacion', 'Fecha Retiro', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-fax" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaRetiroTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->fechaRetiroTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Seleccione la fecha de retiro','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('tipoContratoTerceroInformacion', 'Tipo de Contrato', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('tipoContratoTerceroInformacion',
															array('C'=>'Contratista','TF'=>'T&eacute;rmino Fijo','I'=>'Indefinido','S'=>'Servicios'),(isset($tercero) ? $tercero->terceroInformaciones->tipoContratoTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el tipo de contrato",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('aniosExperienciaTerceroInformacion', 'A&ntilde;os de Experiencia', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::text('aniosExperienciaTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->aniosExperienciaTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite los a&ntilde;os de experiencia','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default" style="display:none;" id="pestanaEducacion">
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
															{!!Form::textarea('educacionTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->educacionTerceroInformacion : null),['class'=>'ckeditor','placeholder'=>'Ingresa la educaci&oacute;n'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default" style="display:none;" id="pestanaExperiencia">
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
															{!!Form::textarea('experienciaTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->experienciaTerceroInformacion : null),['class'=>'ckeditor','placeholder'=>'Ingresa la experiencia'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default" style="display:none;" id="pestanaFormacion">
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
															{!!Form::textarea('formacionTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->formacionTerceroInformacion : null),['class'=>'ckeditor','placeholder'=>'Ingresa la experiencia'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default" style="display:none;" id="pestanaPersonal">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#personal">Informaci&oacute;n Personal</a>
											</h4>
										</div>
										<div id="personal" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('estadoCivilTerceroInformacion', 'Estado Civil', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('estadoCivilTerceroInformacion',
															array('CASADO'=>'Casado','SOLTERO'=>'Soltero'),(isset($tercero) ? $tercero->terceroInformaciones->estadoCivilTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el estado civil",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('numeroHijosTerceroInformacion', 'N&uacute;mero de Hijos', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::text('numeroHijosTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->numeroHijosTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el n&uacute;mero de hijos','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('composicionFamiliarTerceroInformacion', 'Composici&oacute;n Familiar', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('composicionFamiliarTerceroInformacion',
															array('VS'=>'Vive Solo','SH'=>'Solo con Hijos','EH'=>'Esposo e Hijos','FO'=>'Familia de Origen','A'=>'Amigos'),(isset($tercero) ? $tercero->terceroInformaciones->composicionFamiliarTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione la composici&oacute;n familiar",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('personasACargoTerceroInformacion', 'Personas a Cargo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::text('personasACargoTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->personasACargoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el n&uacute;mero de personas a cargo','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('estratoSocialTerceroInformacion', 'Estrato', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::text('estratoSocialTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->estratoSocialTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el estrato','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('tipoViviendaTerceroInformacion', 'Tipo de Vivienda', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('tipoViviendaTerceroInformacion',
															array('PROPIA'=>'Propia','ARRENDADA'=>'Arrendada','FAMILIAR'=>'Familiar'),(isset($tercero) ? $tercero->terceroInformaciones->tipoViviendaTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el tipo de vivienda",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('tipoTransporteTerceroInformacion', 'Tipo de Transporte', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('tipoTransporteTerceroInformacion',
															array('PIE'=>'A pie','BICICLETA'=>'Bicicleta','PUBLICO'=>'P&uacute;blico','MOTO'=>'Moto','CARRO'=>'Carro'),(isset($tercero) ? $tercero->terceroInformaciones->tipoTransporteTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el tipo de transporte",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('HobbyTerceroInformacion', 'Hobby', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::text('HobbyTerceroInformacion',(isset($tercero) ? $tercero->terceroInformaciones->HobbyTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el hobby','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('actividadFisicaTerceroInformacion', 'Actividad F&iacute;sica', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('actividadFisicaTerceroInformacion',
															array('1'=>'S&iacute;','0'=>'No'),(isset($tercero) ? $tercero->terceroInformaciones->actividadFisicaTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione si realiza actividad f&iacute;sica",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('consumeLicorTerceroInformacion', 'Consume Licor', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('consumeLicorTerceroInformacion',
															array('1'=>'S&iacute;','0'=>'No'),(isset($tercero) ? $tercero->terceroInformaciones->consumeLicorTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione si consume licor",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('FrecuenciaMedicion_idConsumeLicor', 'Frecuencia', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('FrecuenciaMedicion_idConsumeLicor',
															$frecuenciaAlcohol, (isset($tercero) ? $tercero->terceroInformaciones->FrecuenciaMedicion_idConsumeLicor : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione la frencuencia del consumo de licor",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('consumeCigarrilloTerceroInformacion', 'Consume Cigarrillo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('consumeCigarrilloTerceroInformacion',
															array('1'=>'S&iacute;','0'=>'No'),(isset($tercero) ? $tercero->terceroInformaciones->consumeCigarrilloTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione si consume cigarrillo",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Contactos</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;" onclick="contactos.agregarCampos(valorContactos,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 330px;">Nombre</div>
															<div class="col-md-1" style="width: 270px;">Cargo</div>
															<div class="col-md-1" style="width: 150px;">Tel&eacute;fono</div>
															<div class="col-md-1" style="width: 150px;">M&oacute;vil</div>
															<div class="col-md-1" style="width: 230px;">Correo</div>
															<div id="contenedor_contactos">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="pestanaProducto" class="panel panel-default" style="display:none;">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Productos y Servicios</a>
											</h4>
										</div>
										<div id="collapseThree" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;" onclick="productos.agregarCampos(valorProductos,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 380px;">Referencia</div>
															<div class="col-md-1" style="width: 750px;">Descripci&oacute;n</div>
															<div id="contenedor_productos">
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
												<a data-toggle="collapse" data-parent="#archivos" href="#archivos">Archivos</a>
											</h4>
										</div>
										<div id="archivos" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 40px;height: 60px;" onclick="archivo.agregarCampos(valorArchivo,'A')">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">T&iacute;tulo</div>
															<div class="col-md-1" style="width: 200px;display:inline-block;height:60px;">Fecha</div>
															<div class="col-md-1" style="width: 600px;display:inline-block;height:60px;">Ruta</div>
															<div id="contenedor_archivo">
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
						@if(isset($tercero))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
						@endif
					</div>
				</div>
			</fieldset>
		</br></br></br></br>
		</div>
	{!!Form::close()!!}
	
	<script type="text/javascript">
		document.getElementById('contenedor').style.width = '1350px';
		document.getElementById('contenedor-fin').style.width = '1350px';
		 
		//mostrarPestanas();

        $('#fechaNacimientoTercero').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#imagenTercero').fileinput({
			language: 'es',
			uploadUrl: '#',
			allowedFileExtensions : ['jpg', 'png','gif'],
			 initialPreview: [
			 '<?php if(isset($tercero->imagenTercero))
						echo Html::image("images/". $tercero->imagenTercero,"Imagen no encontrada",array("style"=>"width:148px;height:158px;"));
							             ;?>'
            ],
			dropZoneTitle: 'Seleccione su foto',
			removeLabel: '',
			uploadLabel: '',
			browseLabel: '',
			uploadClass: "",
			uploadLabel: "",
			uploadIcon: "",
		});
    </script>
@stop