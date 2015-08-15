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
			<div class="container">
				<div class="navbar-header pull-left">
					<a class="navbar-brand">Terceros</a>
				</div>
			</div>
			<div class="form-container">
				<fieldset id="tercero-form-fieldset">
					<div class="form-group" style="width:565px; display: inline;">
						{!!Form::label('TipoIdentificacion_idTipoIdentificacion', 'Tipo de Identificaci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" style="width:340px;">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('TipoIdentificacion_idTipoIdentificacion',null,['class'=>'form-control','placeholder'=>'Ingresa el tipo de identificaci&oacute;n','style'=>'width:300px;'])!!}
						    </div>
						</div>
					</div>
					<div class="form-group" style="width:565px; display: inline;" >
						{!!Form::label('documentoTercero', 'Documento No.', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" style="width:340px;">
				            <div class="input-group" >
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
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
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('nombre1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre 1 del tercero','style'=>'width:300px;'])!!}
						    </div>
						</div>
					</div>
					<div class="form-group" style="width:565px; display: inline;">
						{!!Form::label('nombre2Tercero', 'Nombre 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" style="width:340px;">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
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
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('apellido1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el apellido 1 del tercero','style'=>'width:300px;'])!!}
						    </div>
						</div>
					</div>
					<div class="form-group" style="width:565px; display: inline;">
						{!!Form::label('apellido2Tercero', 'Apellido 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" style="width:340px;">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('apellido2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el apellido 2 del tercero','style'=>'width:300px;'])!!}
						    </div>
						</div>
					</div>
					<div class="form-group" >
						{!!Form::label('nombreCompletoTercero', 'Nombre Completo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" >
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('nombreCompletoTercero',null,['class'=>'form-control','placeholder'=>'Nombre completo del Tercero'])!!}
						    </div>
						</div>
					</div>
					<div class="form-group" style="width:565px; display: inline;">
						{!!Form::label('fechaCreacionTercero', 'Fecha Creaci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" style="width:340px;">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('fechaCreacionTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha creaci&oacute;n del tercero','style'=>'width:300px;'])!!}
						    </div>
						</div>
					</div>
					<div class="form-group" style="width:565px; display: inline;">
						{!!Form::label('estadoTercero', 'Estado', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
						<div class="col-sm-10" style="width:340px;">
				            <div class="input-group">
				              	<span class="input-group-addon">
				                	<i class="fa fa-barcode"></i>
				              	</span>
								{!!Form::text('estadoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el estado del tercero','style'=>'width:300px;'])!!}
						    </div>
						</div>
					</div>
					<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detalles
                        </div>
                        <!-- .panel-heading -->
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
                                            <div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('direccionTercero', 'Direcci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('direccionTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la direcci&oacute;n','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;" >
												{!!Form::label('Ciudad_idCiudad', 'Ciudad', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group" >
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('Ciudad_idCiudad',null,['class'=>'form-control','placeholder'=>'Ingresa la ciudad','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('telefonoTercero', 'Tel&eacute;fono', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('telefonoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero de tel&eacute;fono','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('faxTercero', 'Fax', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('faxTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el fax','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('movil1Tercero', 'M&oacute;vil 1', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('movil1Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 1','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('movil2Tercero', 'M&oacute;vil 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('movil2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 2','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('sexoTercero', 'Sexo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('sexoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el sexo del tercero','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('fechaNacimientoTercero', 'Fecha Nacimiento', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('fechaNacimientoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha de nacimiento','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('correoElectronicoTercero', 'Correo Electr&oacute;nico', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('correoElectronicoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el correo','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('paginaWebTercero', 'P&aacute;gina Web', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('paginaWebTercero',null,['class'=>'form-control','placeholder'=>'Ingresa la p&aacute;gina web','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
											<div class="form-group" style="width:565px; display: inline;">
												{!!Form::label('Cargo_idCargo', 'Cargo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
												<div class="col-sm-10" style="width:340px;">
										            <div class="input-group">
										              	<span class="input-group-addon">
										                	<i class="fa fa-barcode"></i>
										              	</span>
														{!!Form::text('Cargo_idCargo',null,['class'=>'form-control','placeholder'=>'Ingresa el cargo','style'=>'width:300px;'])!!}
												    </div>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Collapsible Group Item #2</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Collapsible Group Item #3</a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
				</fieldset>	
			</div>
		</div>

	{!!Form::close()!!}	

@stop