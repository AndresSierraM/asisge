@extends('layouts.grid')


<?php 
// se crea una variable para tipo Tercero
  $tipoTercero = (isset($tercero) ? $tercero->tipoTercero : $_GET['tipoTercero']);
?>
@section('titulo')
	<h3 id="titulo">
		<center><?php echo ($tipoTercero == '*01*' ? 'Tercero Tipo Empleado' : ($tipoTercero == '*02*' ? 'Proveedor/Contratistas' : ($tipoTercero == '*03*' ? 'Tercero Tipo Cliente' : 'Proveedor/Contratistas'))) ?></center>
	</h3>

@stop
@section('content')
@include('alerts.request')
{!!Html::script('js/tercero.js')!!}

{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->

<?php
	$terceroinformacion = (isset($tercero) ? $tercero->terceroInformaciones : "");
	//Se pregunta  si existe el id tercero  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
	$idTerceroA = (isset($tercero) ? $tercero->idTercero : 0);
	// $idTerceroA = (isset($_GET['accion']) ? $_GET['idTercero'] : '');
?>
	<script>
		
		var terceroContactos = '<?php echo (isset($tercero) ? json_encode($tercero->terceroContactos) : "");?>';
		terceroContactos = (terceroContactos != '' ? JSON.parse(terceroContactos) : '');
		var terceroProductos = '<?php echo (isset($terceroproducto) ? json_encode($terceroproducto) : "");?>';
		terceroProductos = (terceroProductos != '' ? JSON.parse(terceroProductos) : '');

		var terceroProveedor = '<?php echo (isset($proveedorseleccion) ? json_encode($proveedorseleccion) : "");?>';
		terceroProveedor = (terceroProveedor != '' ? JSON.parse(terceroProveedor) : '');

		var terceroExamenMedico = '<?php echo (isset($tercero) ? json_encode($tercero->terceroExamenMedicos) : "");?>';
		terceroExamenMedico = (terceroExamenMedico != '' ? JSON.parse(terceroExamenMedico) : '');
		// var terceroArchivo = '<?php echo (isset($tercero) ? json_encode($tercero->terceroarchivos) : "");?>';
		// terceroArchivo = (terceroArchivo != '' ? JSON.parse(terceroArchivo) : '');

		var valorContactos = [0,'','','','',''];
		var valorProductos = [0,'',''];
		var valorExamen = [0,0,0,0,0,0];
		var valorArchivo = [0,'','',''];


		var idTipoExamen = '<?php echo isset($idTipoExamen) ? $idTipoExamen : 0;?>';
		var nombreTipoExamen = '<?php echo isset($nombreTipoExamen) ? $nombreTipoExamen : "";?>';
		var idFrecuenciaMedicion = '<?php echo isset($idFrecuenciaMedicion) ? $idFrecuenciaMedicion : 0;?>';
		var nombreFrecuenciaMedicion = '<?php echo isset($nombreFrecuenciaMedicion) ? $nombreFrecuenciaMedicion : "";?>';
		
		var listaTarea = [JSON.parse(idTipoExamen),JSON.parse(nombreTipoExamen)];
		var frencuenciaMedicion = [JSON.parse(idFrecuenciaMedicion),JSON.parse(nombreFrecuenciaMedicion)];

		$(document).ready(function(){
			// Se eecuta la funcion modificada para que muestre las pestañas
			mostrarPestanas();
			// Se ejecuta nuevamente la funcion del chulo contratista
   			validarconstratista();
			// seleccionarTipoTercero();

			contactos = new Atributos('contactos','contenedor_contactos','contactos_');
			contactos.campos = ['idTerceroContacto','nombreTerceroContacto','cargoTerceroContacto','telefonoTerceroContacto','movilTerceroContacto','correoElectronicoTerceroContacto'];
			contactos.etiqueta = ['input','input','input','input','input','input'];
			contactos.tipo = ['hidden','text','text','text','text','text'];
			contactos.estilo = ['','width: 330px; height:35px;','width: 270px;height:35px;','width: 150px;height:35px;','width: 150px;height:35px;','width: 230px;height:35px;'];
			contactos.clase = ['','','','','',''];
			contactos.sololectura = [false,false,false,false,false,false];

			// productos = new Atributos('productos','contenedor_productos','productos_');
			// productos.campos = ['idTerceroProducto','codigoTerceroProducto','nombreTerceroProducto'];
			// productos.etiqueta = ['input','input','input'];
			// productos.tipo = ['hidden','text','text'];
			// productos.estilo = ['','width: 380px; height:35px;','width: 750px;height:35px;'];
			// productos.clase = ['','',''];
			// productos.sololectura = [false,false,false];

			productos = new Atributos('productos','contenedor_productos','productos_');
			productos.campos = ['idTerceroProducto','FichaTecnica_idFichaTecnica','referenciaTerceroProducto', 'descripcionProducto'];
			productos.etiqueta = ['input','input','input','input'];
			productos.tipo = ['hidden','hidden','text','text'];
			productos.estilo = ['','','width: 200px;height:35px;','width: 800px;height:35px;'];
			productos.clase = ['','','',''];
			productos.sololectura = [false,false,true,true];

			proveedor = new Atributos('proveedor','contenedor_proveedorseleccion','proveedor_');
			proveedor.altura = '35px';
		    proveedor.campoid = 'idTipoProveedorSeleccionTercero';
		    proveedor.botonEliminacion = false;
		    proveedor.campos   = ['descripcionTerceroTipoProveedorSeleccion', 'cumpleTerceroTipoProveedorSeleccion', 'TipoProveedorSeleccion_idTipoProveedorSeleccion', 'Tercero_idTercero',  'idTerceroTipoProveedorSeleccion'];
		    proveedor.etiqueta = ['input', 'checkbox', 'input', 'input', 'input'];
		    proveedor.tipo     = ['text', 'checkbox', 'hidden', 'hidden', 'hidden'];
		    proveedor.estilo   = ['width: 900px;height:35px;', 'width: 100px;height:35px; display:inline-block' ,'', '', ''];
		    proveedor.clase    = ['','', '', '', ''];
		    proveedor.sololectura = [true,false,true,true,true];

			// examen = new Atributos('examen','contenedor_examen','examen');
			// examen.campos = ['idTerceroExamenMedico', 'TipoExamenMedico_idTipoExamenMedico','ingresoTerceroExamenMedico','retiroTerceroExamenMedico','periodicoTerceroExamenMedico','FrecuenciaMedicion_idFrecuenciaMedicion'];
			// examen.etiqueta = ['input','select','checkbox','checkbox','checkbox','select'];
			// examen.tipo = ['hidden','','checkbox','checkbox','checkbox',''];
			// examen.estilo = ['','width: 300px;height:35px;','width: 90px;height:33px;display:inline-block;','width: 90px;height:33px;display:inline-block;','width: 90px;height:33px;display:inline-block;','width: 300px;height:35px;'];
			// examen.clase = ['','','','','',''];
			// examen.sololectura = [false,false,false,false,false,false];
			// examen.completar = ['off','off','off','off','off','off'];
			// examen.opciones = ['',listaTarea,'','','',frencuenciaMedicion];
			// examen.funciones  = ['','','','','',''];

			// archivo = new Atributos('archivo','contenedor_archivo','archivo');
			// archivo.campos = ['idTerceroArchivo', 'tituloTerceroArchivo','fechaTerceroArchivo','rutaTerceroArchivo'];
			// archivo.etiqueta = ['input','input','input','input'];
			// archivo.tipo = ['hidden','text','text','text'];
			// archivo.estilo = ['','width: 300px;height:35px;','width: 200px;height:35px;','width: 600px;height:35px;'];
			// archivo.clase = ['','','','',];
			// archivo.sololectura = [false,false,false,false];
			// archivo.completar = ['off','off','off','off'];
			// archivo.opciones = ['','','',''];
			// archivo.funciones  = ['','','',''];


			for(var j=0, k = terceroContactos.length; j < k; j++)
			{
				contactos.agregarCampos(JSON.stringify(terceroContactos[j]),'L');
			}

			for(var j=0, k = terceroProductos.length; j < k; j++)
			{
				productos.agregarCampos(JSON.stringify(terceroProductos[j]),'L');
			}

			for(var j=0, k = terceroProveedor.length; j < k; j++)
			{
				proveedor.agregarCampos(JSON.stringify(terceroProveedor[j]),'L');
			}

			for(var j=0, k = terceroExamenMedico.length; j < k; j++)
			{
				examen.agregarCampos(JSON.stringify(terceroExamenMedico[j]),'L');
			}

			// for(var j=0, k = terceroArchivo.length; j < k; j++)
			// {
			// 	archivo.agregarCampos(JSON.stringify(terceroArchivo[j]),'L');
			// }

			

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
										{!! Form::hidden('idTerceroInformacion', (isset($tercero->idTerceroInformacion) ? $tercero->idTerceroInformacion->idTerceroInformacion : null), array('id' => 'idTerceroInformacion')) !!}
										<!-- Se oculta el Tipo de Tercero que llega -->
										 {!!Form::hidden('tipoTercero',$tipoTercero,['id'=>'tipoTercero'])!!}
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
							<br/><br/><br/>
							<div class="form-group" style="width:565px; display: none;" id="nombre1">
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
							<div class="form-group" style="width:565px; display: none;" id="nombre2">
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
							<div class="form-group" style="width:565px; display: none;" id="apellido1">
								{!!Form::label('apellido1Tercero', 'Primer Apellido', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
										</span>
										{!!Form::text('apellido1Tercero',(isset($tercero) ? $tercero->apellido1Tercero : ''),['class'=>'form-control','placeholder'=>'Ingresa el primer apellido del tercero','style'=>'width:300px;','id'=>'apellido1Tercero', 'onchange'=>'llenaNombreTercero()'])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: none;" id="apellido2">
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
							<!-- Se hace un if para volver dinamico el nombre de Nombre completo Tercero y su place holder -->
							<?php 
							if (isset($tipoTercero)) 
							{								
								//Variable que contiene  el Label con su mensaje personalizado depndiendo que tipo de tercero es 
								 $NombreDinamicoLabel = ($tipoTercero == '*01*' ? 'Nombre Completo' : ($tipoTercero == '*02*' ? 'Nombre-Raz&oacute;n Social' : ($tipoTercero == '*03*' ? 'Nombre-Raz&oacute;n Social' : 'Nombre-Raz&oacute;n Social')));

								 //Variable que contiene  el place holder con su mensaje personalizado depndiendo que tipo de tercero es 
								 $NombreDinamicoPlace = ($tipoTercero == '*01*' ? 'Nombre completo del Tercero' : ($tipoTercero == '*02*' ? 'Nombre o Raz&oacute;n Social' : ($tipoTercero == '*03*' ? 'Nombre o Raz&oacute;n Social' : 'Nombre o Raz&oacute;n Social')));


							}
							?>
							<div class="form-group" style="width:1000px; display: inline;">
								{!!Form::label('nombreCompletoTercero', $NombreDinamicoLabel, array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:820px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-navicon" style="width: 14px;"></i>
										</span>
										{!!Form::text('nombreCompletoTercero',null,['class'=>'form-control','placeholder'=>$NombreDinamicoPlace,'style'=>'width:820px;','readonly'=>true])!!}
									</div>
								</div>
							</div>
							<div class="form-group" style="width:565px; display: inline;" id="fechacreacion">
								{!!Form::label('fechaCreacionTercero', 'Fecha Creaci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar" style="width: 14px;"></i>
										</span>
										{!!Form::text('fechaCreacionTercero',(isset($tercero) ? $tercero->fechaCreacionTercero : date('Y-m-d')),['class'=>'form-control','placeholder'=>'Ingresa la fecha creaci&oacute;n del tercero','style'=>'width:300px;','readonly'=>true])!!}
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
							<div class="form-group" style="width:565px; display: none;" id="tipoproveedor">						
								{!!Form::label('TipoProveedor_idTipoProveedor', 'Proveedor', array('class' => 'col-sm-2 control-label','style' => 'width:180px;'))!!}
								<div class="col-sm-10" style="width:340px;">
									<div class="input-group" >
										<span class="input-group-addon">
											<i class="fa fa-tasks" style="width: 14px;"></i>
										</span>
										{!!Form::select('TipoProveedor_idTipoProveedor',$tipoproveedor, (isset($tercero) ? $tercero->TipoProveedor_idTipoProveedor : 0),["class" => " form-control", "placeholder" =>"Seleccione el tipo de proveedor",'style'=>'width:300px;', 'onchange' => 'llenarSeleccionProveedor(this.value)'])!!}

									</div>
								</div>
							</div>
																		
							<!-- Se pone en comentario los chulos de los tipos de tercero -->	
													<!--  Se deja este div para que cuando salga el proveedor salga bien centrado-->
							<div class="form-group" style="width:1000px; display: inline;" id="contenedorproveedor">
								<div class="col-lg-12">
									<!-- <div class="panel panel-default"> -->
										<div class="panel-body">
											<!-- {!! Form::hidden('tipoTercero', null, array('id' => 'tipoTercero')) !!} -->
										<!-- 	<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero1','01',false, array('id' => 'tipoTercero1', 'onclick'=>'validarTipoTercero()'))!!}Empleado
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero2','02',false, array('id' => 'tipoTercero2', 'onclick'=>'validarTipoTercero()'))!!}Proveedor
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero3','03',false, array('id' => 'tipoTercero3', 'onclick'=>'validarTipoTercero()'))!!}Cliente
												</label>
											</div>
											<div class="checkbox-inline">
												<label>
													{!!Form::checkbox('tipoTercero4','04',false, array('id' => 'tipoTercero4', 'onclick'=>'validarTipoTercero()'))!!}Contratista
												</label>
											</div>
											<div class="checkbox-inline" style="display:none;">
												<label>
													{!!Form::hidden('tipoTercero1','05',false, array('id' => 'tipoTercero5', 'onclick'=>'validarTipoTercero()'))!!}Seguridad Social
												</label>
											</div> -->
											
										</div>
									</div>
								<!-- </div> -->
							</div>
						</td>
						<td>	
							<!--DIv que se va a ocultar para que no se desarme  el encabezado  -->
							<div class="form-group" style="width:250px; display: none;" id="imagentercerooculta"></div>	
								<!-- Imagen de tercero  -->
							<div class="form-group" style="width:250px; display: none;" id="imagentercero">
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
													{!!Form::label('direccionTercero', 'Direcci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
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
												<div class="form-group" style="width:600px; display: inline;" id="fax">
													{!!Form::label('faxTercero', 'Fax', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
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
													{!!Form::label('movil2Tercero', 'M&oacute;vil 2', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile" style="width: 14px;"></i>
															</span>
															{!!Form::text('movil2Tercero',null,['class'=>'form-control','placeholder'=>'Ingresa el n&uacute;mero del m&oacute;vil 2','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;" id="sexo">
													{!!Form::label('sexoTercero', 'Sexo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('sexoTercero',
															array('F'=>'Femenino','M'=>'Masculino'), 
															(isset($tercero) ? $tercero->sexoTercero : 0),["class" => "form-control", "placeholder" =>"Seleccione el sexo del tercero",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('correoElectronicoTercero', 'E-Mail', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-envelope" style="width: 14px;"></i>
															</span>
															{!!Form::text('correoElectronicoTercero',null,['class'=>'form-control','placeholder'=>'Ingresa el correo','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;" id="pagina">
													{!!Form::label('paginaWebTercero', 'P&aacute;gina Web', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
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
													{!!Form::label('Cargo_idCargo', 'Cargo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile" style="width: 14px;"></i>
															</span>
															{!!Form::select('Cargo_idCargo',$cargo, (isset($tercero) ? $tercero->Cargo_idCargo : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el cargo",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>

												<div class="form-group" style="width:600px; display: none;" id="zona">
													{!!Form::label('Zona_idZona', 'Zona', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile" style="width: 14px;"></i>
															</span>
															{!!Form::select('Zona_idZona',$zona, (isset($tercero) ? $tercero->Zona_idZona : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione la zona",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>		

												<div class="form-group" style="width:600px; display: none;" id="sector">
													{!!Form::label('SectorEmpresa_idSectorEmpresa', 'Sector Empresa', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-left:auto;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-mobile" style="width: 14px;"></i>
															</span>
															{!!Form::select('SectorEmpresa_idSectorEmpresa',$sectorempresa, (isset($tercero) ? $tercero->SectorEmpresa_idSectorEmpresa : 0),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el sector empresarial",'style'=>'width:340px;'])!!}
														</div>
													</div>													
												</div>
													

												<div class="form-group" style="width:600px; display: none;" id="contratista">
													{!!Form::label('Tercero_idEmpleadorContratista', 'Empleador', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('Tercero_idEmpleadorContratista',$empleadorcontratista, (isset($tercero) ? $tercero->empleadorcontratista : 0),["class" => "select form-control","placeholder" =>"Seleccione un empleado",'style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<!-- Chekbox para contratista  con funcion para desaparecer el tipoproveedor-->
												<div class="form-group" style="width:600px; display: inline;" id="checkboxcontratista">
													{!!Form::label('contratistaTercero', 'Contratista', array('class' => 'col-sm-2 control-label','style'=>'width:180px;padding-right:100px '))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">											
															{!!Form::checkbox('contratistaTercero',1,null, array('id' => 'contratistaTercero','style'=>'width:40px;height:30px','onchange' => 'validarconstratista()'))!!}
														</div>
													</div>
												</div>
											</div>											
										</div>
									</div>
									<?php 
									// Se hace una validacion depndiendo del tipo de tercero para el acordeoon llamado infomracion laboral cambie su titulo dependiendo si es 01 = laboral o los demas  Contratactual
									if (isset($tipoTercero)) 
									{
									 $tipolaboral = ($tipoTercero == '*01*' ? 'Informaci&oacute;n Laboral' : ($tipoTercero == '*02*' ? 'Informaci&oacute;n Contractual' : $tipoTercero == '*03*' ? 'Informaci&oacute;n Contractual' : 'Informaci&oacute;n Contractual'));
									
									}
									?>
									<div class="panel panel-default" style="display:none;" id="pestanaLaboral">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#laboral"><?php echo $tipolaboral ?></a>
											</h4>
										</div>
										<div id="laboral" class="panel-collapse collapse">
											<div class="panel-body">
												
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaIngresoTerceroInformacion', 'Fecha Ingreso', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-fax" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaIngresoTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->fechaIngresoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Seleccione la fecha de ingreso','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaRetiroTerceroInformacion', 'Fecha Retiro', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-fax" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaRetiroTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->fechaRetiroTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Seleccione la fecha de retiro','style'=>'width:340px;'])!!}
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
															array('C'=>'Contratista','TF'=>'T&eacute;rmino Fijo','I'=>'Indefinido','S'=>'Servicios','CL'=>'Contrato por obra o labor','CA'=>'Contrato de aprendizaje','CT'=>'Contrato temporal, ocasional o accidental'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->tipoContratoTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el tipo de contrato",'style'=>'width:340px;'])!!}
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
															{!!Form::text('aniosExperienciaTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->aniosExperienciaTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite los a&ntilde;os de experiencia','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<!-- Pestaña Centro Costos -->
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('CentroCosto_idCentroCosto', 'Centro de Costos', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-university" style="width: 14px;"></i>
															</span>
															{!!Form::select('CentroCosto_idCentroCosto',$centrocosto, (isset($tercero) ? $tercero->CentroCosto_idCentroCosto : 0),["class" => "select form-control", "placeholder" =>"Seleccione",'style'=>'width:340px;'])!!}

															
														</div>
													</div>
												</div>

												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('fechaInicioExamenMedicoTerceroInformacion', 'Fecha Inicio Exámenes Médicos', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-fax" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaInicioExamenMedicoTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->fechaInicioExamenMedicoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Seleccione la fecha de inicio Exámenes','style'=>'width:340px;'])!!}
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
															{!!Form::textarea('educacionTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->educacionTerceroInformacion : null),['class'=>'ckeditor','placeholder'=>'Ingresa la educaci&oacute;n'])!!}
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
															{!!Form::textarea('experienciaTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->experienciaTerceroInformacion : null),['class'=>'ckeditor','placeholder'=>'Ingresa la experiencia'])!!}
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
															{!!Form::textarea('formacionTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->formacionTerceroInformacion : null),['class'=>'ckeditor','placeholder'=>'Ingresa la experiencia'])!!}
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
													{!!Form::label('fechaNacimientoTerceroInformacion', 'Fecha Nacimiento', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-phone" style="width: 14px;"></i>
															</span>
															{!!Form::text('fechaNacimientoTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->fechaNacimientoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Ingrese la fecha de nacimiento','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('estadoCivilTerceroInformacion', 'Estado Civil', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('estadoCivilTerceroInformacion',
															array('CASADO'=>'Casado','SOLTERO'=>'Soltero(a)','ULIBRE'=>'Unión libre','DIVORCIADO'=>'Divorciado(a)','VIUDO'=>'Viudo(a)'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->estadoCivilTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el estado civil",'style'=>'width:340px;'])!!}
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
															{!!Form::text('numeroHijosTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->numeroHijosTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el n&uacute;mero de hijos','style'=>'width:340px;'])!!}
														</div>
													</div>
												</div>
												<div class="form-group" style="width:600px; display: inline;">
													{!!Form::label('composicionFamiliarTerceroInformacion', 'Composici&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
													<div class="col-sm-10" style="width:400px;">
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-user" style="width: 14px;"></i>
															</span>
															{!!Form::select('composicionFamiliarTerceroInformacion',
															array('VS'=>'Vive Solo','SH'=>'Solo con Hijos','EH'=>'Esposo e Hijos','FO'=>'Familia de Origen','A'=>'Amigos'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->composicionFamiliarTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione la composici&oacute;n familiar",'style'=>'width:340px;'])!!}
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
															{!!Form::text('personasACargoTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->personasACargoTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el n&uacute;mero de personas a cargo','style'=>'width:340px;'])!!}
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
															{!!Form::text('estratoSocialTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->estratoSocialTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el estrato','style'=>'width:340px;'])!!}
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
															array('PROPIA'=>'Propia','ARRENDADA'=>'Arrendada','FAMILIAR'=>'Familiar'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->tipoViviendaTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el tipo de vivienda",'style'=>'width:340px;'])!!}
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
															array('PIE'=>'A pie','BICICLETA'=>'Bicicleta','PUBLICO'=>'P&uacute;blico','MOTO'=>'Moto','CARRO'=>'Carro'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->tipoTransporteTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el tipo de transporte",'style'=>'width:340px;'])!!}
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
															{!!Form::text('HobbyTerceroInformacion',(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->HobbyTerceroInformacion : null),['class'=>'form-control','placeholder'=>'Digite el hobby','style'=>'width:340px;'])!!}
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
															array('1'=>'S&iacute;','0'=>'No'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->actividadFisicaTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione si realiza actividad f&iacute;sica",'style'=>'width:340px;'])!!}
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
															array('1'=>'S&iacute;','0'=>'No'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->consumeLicorTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione si consume licor",'style'=>'width:340px;'])!!}
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
															$frecuenciaAlcohol, (isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->FrecuenciaMedicion_idConsumeLicor : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione la frencuencia del consumo de licor",'style'=>'width:340px;'])!!}
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
															array('1'=>'S&iacute;','0'=>'No'),(isset($tercero->terceroInformaciones) ? $tercero->terceroInformaciones->consumeCigarrilloTerceroInformacion : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione si consume cigarrillo",'style'=>'width:340px;'])!!}
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
															<div class="col-md-1" style="width: 40px;height:40px;" onclick="contactos.agregarCampos(valorContactos,'A')">
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

									<div id="pestanaCriterioSeleccion" class="panel panel-default" style="display:none;">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#criterioseleccion">Criterios de selección</a>
											</h4>
										</div>
										<div id="criterioseleccion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-12">
														<div class="row show-grid">
															<div class="col-md-1" style="width: 900px;">Descripción del criterio</div>
															<div class="col-md-1" style="width: 100px;">Cumple</div>
															<div id="contenedor_proveedorseleccion">
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
															<div class="col-md-1" style="width: 40px; height:42px; cursor: pointer;" onclick="abrirModalFichaTecnica()">
																<span class="glyphicon glyphicon-plus"></span>
															</div>
															<div class="col-md-1" style="width: 200px;">Referencia</div>
															<div class="col-md-1" style="width: 800px;">Descripci&oacute;n</div>
															<div id="contenedor_productos">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Nuevo Div Notas OBSERVACIONES -->
									<div id="pestanaobservacion" class="panel panel-default" style="display:none;">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#notas">Notas/Observaciones</a>
											</h4>
										</div>
										
										<div id="notas" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													{!!Form::textarea('observacionTercero',(isset($tercero) ? $tercero->observacionTercero : null),['class'=>'ckeditor','placeholder'=>'Ingresa la experiencia'])!!}
												</div>
											</div>
										</div>										
									</div>
									<!-- Se quita esta multiregistro  ya que es un campo que ya están en cargos / perfiles -->
									<!-- <div id="pestanaExamenes" class="panel panel-default">
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
									</div> -->
																			<!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
									<div class="panel panel-default" style="display:inline-block;width:100%">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#archivos">Archivos</a>
											</h4>
										</div>
										<div id="archivos" class="panel-collapse collapse">
											<div class="col-sm-12">
												<!-- <div class="panel panel-default">  SE QUITA POR PETICION DE ANDRES-->  <!--se cambia la clase panel-primary AZUL por default para que salga gris   -->
					                                <div class="panel-heading ">
					                                    <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
					                                </div>
					                                <div class="panel-body">
														<div class="col-sm-12">
															<div id="upload" class="col-md-12">
															    <div class="dropzone dropzone-previews" id="dropzoneTerceroArchivo" style="overflow: auto;">
															    </div>  
															</div>	
					 									
															
															<div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;overflow: auto;">		
															{!!Form::hidden('archivoTerceroArray', null, array('id' => 'archivoTerceroArray'))!!}
																<?php
																
																// Cuando este editando el archivo 
																if ($idTerceroA != '')  //Se pregunta si el id de acta de capacitacion es diferente de vacio (que es la tabla papá)
																{
																	$eliminar = '';
																	$archivoSave = DB::Select('SELECT * from terceroarchivo where Tercero_idTercero = '.$idTerceroA);
																	for ($i=0; $i <count($archivoSave) ; $i++) 
																	{ 
																		$archivoS = get_object_vars($archivoSave[$i]);

																		echo '<div id="'.$archivoS['idTerceroArchivo'].'" class="col-lg-4 col-md-4">
														                    <div class="panel panel-yellow" style="border: 1px solid orange;">
														                        <div class="panel-heading">
														                            <div class="row">
														                                <div class="col-xs-3">
														                                    <a target="_blank" 
														                                    	href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaTerceroArchivo'].'">
														                                    	<i class="fa fa-book fa-5x" style="color: gray;"></i>
														                                    </a>
														                                </div>

														                                <div class="col-xs-9 text-right">
														                                    <div>'.str_replace('/tercero/','',$archivoS['rutaTerceroArchivo']).'
														                                    </div>
														                                </div>
														                            </div>
														                        </div>
														                        <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idTerceroArchivo'].');">
														                            <div class="panel-footer">
														                                <span class="pull-left">Eliminar Documento</span>
														                                <span class="pull-right"><i class="fa fa-times"></i></span>
														                                <div class="clearfix"></div>
														                            </div>
														                        </a>
														                    </div>
														                </div>';

																		echo '<input type="hidden" id="idTerceroArchivo[]" name="idTerceroArchivo[]" value="'.$archivoS['idTerceroArchivo'].'" >

																		<input type="hidden" id="rutaTerceroArchivo[]" name="rutaTerceroArchivo[]" value="'.$archivoS['rutaTerceroArchivo'].'" >';
																	}

																	echo '<input type="hidden" name="eliminarArchivo" id="eliminarArchivo" value="">';
																}
																
																 ?>							
															</div>
														</div>
													</div>
												<!-- </div> -->
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
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
					</div>
				</div>			
			</fieldset>
		</br></br></br></br>
		</div>
		<input type="hidden" id="token" value="{{csrf_token()}}"/>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
      	<div class="form-group" style="width:565px; display: inline;">
			{!!Form::label('tituloTerceroArchivo', 'Titulo', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
			<div class="col-sm-10" style="width:340px;">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
					</span>
					{!!Form::text('tituloTerceroArchivo',null,['class'=>'form-control','placeholder'=>'Ingresa el titulo del archivo','style'=>'width:300px;','id'=>'tituloTerceroArchivo'])!!}
				</div>
			</div>
		</div>
		<?php $fechahoy = Carbon\Carbon::now();?>
		<div class="form-group" style="width:565px; display: inline;">
			{!!Form::label('fechaTerceroArchivo', 'Fecha', array('class' => 'col-sm-2 control-label','style'=>'width:180px;'))!!}
			<div class="col-sm-10" style="width:340px;">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
					</span>
					{!!Form::text('fechaTerceroArchivo',$fechahoy->toDateTimeString() ,['class'=>'form-control','readonly','style'=>'width:300px;','id'=>'fechaTerceroArchivo'])!!}
				</div>
			</div>
		</div>

		
		{!!Form::hidden('archivoTercero', 0, array('id' => 'archivoTercero'))!!}

        <div id="preview">
       		<center><img id="viewer" frameborder="0" scrolling="no" width="60%" height="60%"></center>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>			
	{!!Form::close()!!}
	
	<script type="text/javascript">
		document.getElementById('contenedor').style.width = '1350px';
		document.getElementById('contenedor-fin').style.width = '1350px';
		 
		//mostrarPestanas();

        $('#fechaNacimientoTerceroInformacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#fechaIngresoTerceroInformacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#fechaRetiroTerceroInformacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		$('#fechaInicioExamenMedicoTerceroInformacion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

		
		$('#imagenTercero').fileinput({
			language: 'es',
			uploadUrl: '#',
			allowedFileExtensions : ['jpg', 'png','gif'],
			 initialPreview: [
			 '<?php if(isset($tercero->imagenTercero))
						echo Html::image("imagenes/". $tercero->imagenTercero,"Imagen no encontrada",array("style"=>"width:148px;height:158px;"));
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

	 //--------------------------------- DROPZONE ---------------------------------------
	var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneTerceroArchivo", {
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

    document.getElementById('archivoTerceroArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
    	// alert('hola');
    					//abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
						// console.log(fileList);
						
                        document.getElementById('archivoTerceroArray').value += file.name+',';
                        // console.log(document.getElementById('archivoTerceroArray').value);
                        i++;
                    });
    </script>

<style>
#dropzoneTerceroArchivo {
width: 1150px;
height: 200px;
min-height: 0px !important;
}   
</style>    
@stop

<div id="modalFichaTecnica" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ficha técnica</h4>
      </div>
      <div class="modal-body">
      	<div class="container">
            <div class="row" style="width:90%;">
                <div class="container" style="width:100%;">
                    <table id="tfichatecnica" name="tfichatecnica" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>Referencia</b></th>
                                <th><b>Descripción</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>Referencia</th>
                                <th>Descripción</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="modal-footer">
                        <button id="botonFichaTecnica" name="botonFichaTecnica" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>
				</div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>