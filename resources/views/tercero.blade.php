@extends('layouts.principal')

@section('content')

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
			<div class="container" style="width:1300px">
				<div class="navbar-header pull-left">
					<a class="navbar-brand">Terceros</a>
				</div>
			</div>
			<div class="form-container" style="width:1300px">
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
									{!!Form::label('nombre1Tercero', 'Nombre 1', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
									<div class="col-sm-10" style="width:340px;">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
											</span>
											{!!Form::text('nombre1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre 1 del tercero','style'=>'width:300px;'])!!}
										</div>
									</div>
								</div>
								<div class="form-group" style="width:565px; display: inline;">
									{!!Form::label('nombre2Tercero', 'Nombre 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
									<div class="col-sm-10" style="width:340px;">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
											</span>
											{!!Form::text('nombre2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre 2 del tercero','style'=>'width:300px;'])!!}
										</div>
									</div>
								</div>
								<div class="form-group" style="width:565px; display: inline;">
									{!!Form::label('apellido1Tercero', 'Apellido 1', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
									<div class="col-sm-10" style="width:340px;">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
											</span>
											{!!Form::text('apellido1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el apellido 1 del tercero','style'=>'width:300px;'])!!}
										</div>
									</div>
								</div>
								<div class="form-group" style="width:565px; display: inline;">
									{!!Form::label('apellido2Tercero', 'Apellido 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:30px;'))!!}
									<div class="col-sm-10" style="width:340px;">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
											</span>
											{!!Form::text('apellido2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el apellido 2 del tercero','style'=>'width:300px;'])!!}
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
								<div class="form-group" style="width:200px; display: inline;" >
									<div class="col-sm-10" style="width:200px;">
										<div class="panel panel-default">
											<div class="panel-heading">
											Headings
											</div>
											<div class="panel-body">
											<h3>Heading 1
											<small>Sub-heading</small>
											</h3>
											<h4>Heading 2
											<small>Sub-heading</small>
											</h4>
											<h5>Heading 3
											<small>Sub-heading</small>
											</h5>
											</div>
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
														<div class="col-sm-10">
															<div class="row show-grid">
																<div class="col-md-1" style="width: 400px;">Nombre</div>
																<div class="col-md-1" style="width: 240px;">Cargo</div>
																<div class="col-md-1" style="width: 130px;">Tel&eacute;fono</div>
																<div class="col-md-1" style="width: 130px;">M&oacute;vil</div>
																<div class="col-md-1" style="width: 200px;">Correo</div>
																<div class="col-md-1" style="width: 40px;">
																	<span class="glyphicon glyphicon-plus"></span>
																</div>
																<div id="contenedor_objetivos">
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
														<div class="col-sm-10">
															<div class="row show-grid">
																<div class="col-md-1" style="width: 400px;">Referencia</div>
																<div class="col-md-1" style="width: 700px;">Descripci&oacute;n</div>
																<div class="col-md-1" style="width: 40px;">
																	<span class="glyphicon glyphicon-plus"></span>
																</div>
																<div id="contenedor_objetivos">
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
			</div>
		</div>
	{!!Form::close()!!}
	<script type="text/javascript">
		$(function () {
            $('#fechaNacimientoTercero').datetimepicker(({
				format: "YYYY-MM-DD"
			}));
        });
    </script>
@stop