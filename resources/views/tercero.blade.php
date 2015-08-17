@extends('layouts.principal')

@section('titulo')
	<h3 id="titulo">
		<center>Terceros</center>
	</h3>
@stop

@section('content')
	{!!Html::script('js/tercero.js')!!}
	<script>

		var terceroContactos = '<?php echo (isset($tercero) ? json_encode($compania->terceroContacto) : "");?>';
		terceroContactos = (terceroContactos != '' ? JSON.parse(terceroContactos) : '');
		var terceroProductos = '<?php echo (isset($tercero) ? json_encode($compania->terceroProducto) : "");?>';
		terceroProductos = (terceroProductos != '' ? JSON.parse(terceroProductos) : '');
		var valorContactos = [0,'','','','',''];
		var valorProductos = [0,'',''];

		$(document).ready(function(){

			contactos = new Atributos('contactos','contenedor_contactos','contactos_');
			contactos.campos = ['idTerceroContacto','nombreTerceroContacto','cargoTerceroContacto','telefonoTerceroContacto','movilTerceroContacto','correoElectronicoTerceroContacto'];
			contactos.etiqueta = ['input','input','input','input','input','input'];
			contactos.tipo = ['hidden','text','text','text','text','text'];
			contactos.estilo = ['','width: 340px; height:35px;','width: 270px;height:35px;','width: 150px;height:35px;','width: 150px;height:35px;','width: 240px;height:35px;'];
			contactos.clase = ['','','','','',''];
			contactos.sololectura = [false,false,false,false,false,false];

			productos = new Atributos('productos','contenedor_productos','productos_');
			productos.campos = ['idTerceroProducto','nombreTerceroProducto','descripcionTerceroProducto'];
			productos.etiqueta = ['input','input','input'];
			productos.tipo = ['hidden','text','text'];
			productos.estilo = ['','width: 400px; height:35px;','width: 750px;height:35px;'];
			productos.clase = ['','',''];
			productos.sololectura = [false,false,false];

			for(var j=0, k = terceroContactos.length; j < k; j++)
			{
				contactos.agregarCampos(JSON.stringify(terceroContactos[j]),'L');
			}

			for(var j=0, k = terceroProductos.length; j < k; j++)
			{
				productos.agregarCampos(JSON.stringify(terceroProductos[j]),'L');
			}

		});
	</script>
	@if(isset($tercero))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tercero,['route'=>['tercero.destroy',$tercero->idTercero],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tercero,['route'=>['tercero.update',$tercero->idTercero],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tercero.store','method'=>'POST'])!!}
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
										{!!Form::text('nombre1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el primer nombre del tercero','style'=>'width:300px;'])!!}
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
										{!!Form::text('nombre2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el segundo nombre del tercero','style'=>'width:300px;'])!!}
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
										{!!Form::text('apellido1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el primer apellido del tercero','style'=>'width:300px;'])!!}
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
										{!!Form::text('apellido2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el segundo apellido del tercero','style'=>'width:300px;'])!!}
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
										{!!Form::text('nombreCompletoTercero',null,['class'=>'form-control','placeholder'=>'Nombre completo del Tercero','style'=>'width:820px;'])!!}
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
										{!!Form::text('fechaCreacionTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha creaci&oacute;n del tercero','style'=>'width:300px;'])!!}
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
										{!!Form::select('estadoTercero',array('ACTIVO'=>'Activo','INACTIVO'=>'Inactivo'),(isset($tercero) ? $tercero->estadoTercero : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el estado del tercero",'style'=>'width:300px;'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:1000px; display: inline;">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','value',true)!!}Empleado
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','value',true)!!}Proveedor
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','value',true)!!}Cliente
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','value',true)!!}EntidadEstatal
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','value',true)!!}Seguridad Social
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
															{!!Form::select('Ciudad_idCiudad',$ciudad, (isset($tercero) ? $tercero->Ciudad_idCiudad : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la ciudad",'style'=>'width:340;'])!!}

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
															{!!Form::text('direccionTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la direcci&oacute;n','style'=>'width:340;'])!!}
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
															{!!Form::text('telefonoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero de tel&eacute;fono','style'=>'width:340;'])!!}
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
															{!!Form::text('faxTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el fax','style'=>'width:340;'])!!}
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
															{!!Form::text('movil1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 1','style'=>'width:340;'])!!}
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
															{!!Form::text('movil2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 2','style'=>'width:340;'])!!}
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
															(isset($tercero) ? $tercero->estadoTercero : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el sexo del tercero",'style'=>'width:340;'])!!}
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
															{!!Form::text('fechaNacimientoTercero',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de nacimiento', 'style'=>'width:340;'])!!}
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
															{!!Form::text('correoElectronicoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el correo','style'=>'width:340;'])!!}
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
															{!!Form::text('paginaWebTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la p&aacute;gina web','style'=>'width:340;'])!!}
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
															<div class="col-md-1" style="width: 340px;">Nombre</div>
															<div class="col-md-1" style="width: 270px;">Cargo</div>
															<div class="col-md-1" style="width: 150px;">Tel&eacute;fono</div>
															<div class="col-md-1" style="width: 150px;">M&oacute;vil</div>
															<div class="col-md-1" style="width: 240px;">Correo</div>
															<div id="contenedor_contactos">
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
															<div class="col-md-1" style="width: 400px;">Referencia</div>
															<div class="col-md-1" style="width: 750px;">Descripci&oacute;n</div>
															<div id="contenedor_productos">
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
			</fieldset>
			@if(isset($tercero))
				{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
			@else
				{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
			@endif
		</div>
	{!!Form::close()!!}
	<script type="text/javascript">
		document.getElementById('contenedor').style.width = '1350px';
		document.getElementById('contenedor-fin').style.width = '1350px';
        $('#fechaNacimientoTercero').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#imagenTercero').fileinput({
			language: 'es',
			uploadUrl: '#',
			allowedFileExtensions : ['jpg', 'png','gif'],
			dropZoneTitle: 'Arrastre su foto',
			removeLabel: '',
			uploadLabel: '',
			browseLabel: '',
			uploadClass: "",
			uploadLabel: "",
			uploadIcon: "",
		});
    </script>
@stop