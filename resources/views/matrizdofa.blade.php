@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Matriz DOFA
	</h3>
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/matrizdofa.js')!!}
<script>





		// Se recibe la consulta de la multigistro oportunidad para que muestre los datos de los campos
	 	var MatrizDofaOportunidad = '<?php echo (isset($MatrizDofaoportunidad) ? json_encode($MatrizDofaoportunidad) : "");?>';
		MatrizDofaOportunidad = (MatrizDofaOportunidad != '' ? JSON.parse(MatrizDofaOportunidad) : '');

		// Se recibe la consulta de la multigistro oportunidad para que muestre los datos de los campos
	 	var MatrizFortaleza = '<?php echo (isset($MatrizDofafortaleza) ? json_encode($MatrizDofafortaleza) : "");?>';
		MatrizFortaleza = (MatrizFortaleza != '' ? JSON.parse(MatrizFortaleza) : '');

		// Se recibe la consulta de la multigistro oportunidad para que muestre los datos de los campos
	 	var MatrizDofaAmenaza = '<?php echo (isset($MatrizDofaamenaza) ? json_encode($MatrizDofaamenaza) : "");?>';
		MatrizDofaAmenaza = (MatrizDofaAmenaza != '' ? JSON.parse(MatrizDofaAmenaza) : '');

		// Se recibe la consulta de la multigistro oportunidad para que muestre los datos de los campos
	 	var MatrizDofaDebilidad = '<?php echo (isset($MatrizDofadebilidad) ? json_encode($MatrizDofadebilidad) : "");?>';
		MatrizDofaDebilidad = (MatrizDofaDebilidad != '' ? JSON.parse(MatrizDofaDebilidad) : '');



		// En el respectivo campo de tipoMatrizDOFADetalle Se quema la palabra de la multi en la que esta parado, para cando guarde sepa en cual esta parado
		var valoroportunidad = [0,'','Oportunidad','',''];
		var valorfortaleza = [0,'','Fortaleza','',''];
		var valoramenaza = [0,'','Amenaza','',''];
		var valordebilidad = [0,'','Debilidad','',''];

    	$(document).ready(function(){
    		// Detalle oportunidad
			oportunidad = new Atributos('oportunidad','oportunidad_detalle','detalleOportunidad_');
			oportunidad.altura = '36px;';
			oportunidad.campoid = 'idMatrizDOFADetalle_Oportunidad';
			oportunidad.campoEliminacion = 'eliminardetalle';
			oportunidad.botonEliminacion = true;
			oportunidad.campos = ['idMatrizDOFADetalle_Oportunidad','MatrizDOFA_idMatrizDOFA_Oportunidad', 'tipoMatrizDOFADetalle_Oportunidad', 'descripcionMatrizDOFADetalle_Oportunidad', 'matrizRiesgoMatrizDOFADetalle_Oportunidad'];
			oportunidad.etiqueta = ['input','input','input','input','checkbox'];
			oportunidad.tipo = ['hidden','hidden','hidden','text','checkbox'];
			oportunidad.estilo = ['','','','width: 900px;height:35px;','width: 200px;height:30px;display:inline-block;'];
			oportunidad.clase = ['','','','',''];
			oportunidad.sololectura = [false,false,false,false,false];
			oportunidad.opciones = ['','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			oportunidad.funciones = ['','','',quitacarac,''];

    		// Detalle Fortaleza
			fortaleza = new Atributos('fortaleza','fortaleza_detalle','detalleFortaleza_');
			fortaleza.altura = '36px;';
			fortaleza.campoid = 'idMatrizDOFADetalle_Fortaleza';
			fortaleza.campoEliminacion = 'eliminarFortaleza';
			fortaleza.botonEliminacion = true;
			fortaleza.campos = ['idMatrizDOFADetalle_Fortaleza','MatrizDOFA_idMatrizDOFA_Fortaleza', 'tipoMatrizDOFADetalle_Fortaleza', 'descripcionMatrizDOFADetalle_Fortaleza', 'matrizRiesgoMatrizDOFADetalle_Fortaleza'];
			fortaleza.etiqueta = ['input','input','input','input','checkbox'];
			fortaleza.tipo = ['hidden','hidden','hidden','text','checkbox'];
			fortaleza.estilo = ['','','','width: 900px;height:35px;','width: 200px;height:30px;display:inline-block;'];
			fortaleza.clase = ['','','','',''];
			fortaleza.sololectura = [false,false,false,false,false];
			fortaleza.opciones = ['','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			fortaleza.funciones = ['','','',quitacarac,''];

			// Detalle Amenaza
			amenaza = new Atributos('oportunidad','amenaza_detalle','detalleAmenaza_');
			amenaza.altura = '36px;';
			amenaza.campoid = 'idMatrizDOFADetalle_Amenaza';
			amenaza.campoEliminacion = 'eliminarAmenaza';
			amenaza.botonEliminacion = true;
			amenaza.campos = ['idMatrizDOFADetalle_Amenaza','MatrizDOFA_idMatrizDOFA_Amenaza', 'tipoMatrizDOFADetalle_Amenaza', 'descripcionMatrizDOFADetalle_Amenaza', 'matrizRiesgoMatrizDOFADetalle_Amenaza'];
			amenaza.etiqueta = ['input','input','input','input','checkbox'];
			amenaza.tipo = ['hidden','hidden','hidden','text','checkbox'];
			amenaza.estilo = ['','','','width: 900px;height:35px;','width: 200px;height:30px;display:inline-block;'];
			amenaza.clase = ['','','','',''];
			amenaza.sololectura = [false,false,false,false,false];
			amenaza.opciones = ['','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			amenaza.funciones = ['','','',quitacarac,''];

			// Detalle Debilidad
			debilidad = new Atributos('debilidad','debilidad_detalle','detalleDebilidad_');
			debilidad.altura = '36px;';
			debilidad.campoid = 'idMatrizDOFADetalle_Debilidad';
			debilidad.campoEliminacion = 'eliminarDebilidad';
			debilidad.botonEliminacion = true;
			debilidad.campos = ['idMatrizDOFADetalle_Debilidad','MatrizDOFA_idMatrizDOFA_Debilidad', 'tipoMatrizDOFADetalle_Debilidad', 'descripcionMatrizDOFADetalle_Debilidad', 'matrizRiesgoMatrizDOFADetalle_Debilidad'];
			debilidad.etiqueta = ['input','input','input','input','checkbox'];
			debilidad.tipo = ['hidden','hidden','hidden','text','checkbox'];
			debilidad.estilo = ['','','','width: 900px;height:35px;','width: 200px;height:30px;display:inline-block;'];
			debilidad.clase = ['','','','',''];
			debilidad.sololectura = [false,false,false,false,false];
			debilidad.opciones = ['','','','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			debilidad.funciones = ['','','',quitacarac,''];








			// Respectivo for para cargar la informacion de Oportunidad Cuando este editando el registro
			for(var j=0, k = MatrizDofaOportunidad.length; j < k; j++)
			{
				
				oportunidad.agregarCampos(JSON.stringify(MatrizDofaOportunidad[j]),'L');				
			}

			// Respectivo for para cargar la informacion de fortaleza Cuando este editando el registro
			for(var j=0, k = MatrizFortaleza.length; j < k; j++)
			{
				
				fortaleza.agregarCampos(JSON.stringify(MatrizFortaleza[j]),'L');				
			}

			// Respectivo for para cargar la informacion de amenaza Cuando este editando el registro
			for(var j=0, k = MatrizDofaAmenaza.length; j < k; j++)
			{
				
				amenaza.agregarCampos(JSON.stringify(MatrizDofaAmenaza[j]),'L');				
			}

			// Respectivo for para cargar la informacion de debilidad Cuando este editando el registro
			for(var j=0, k = MatrizDofaDebilidad.length; j < k; j++)
			{
				
				debilidad.agregarCampos(JSON.stringify(MatrizDofaDebilidad[j]),'L');				
			}

		});
	</script>
	@if(isset($matrizdofa))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($matrizdofa,['route'=>['matrizdofa.destroy',$matrizdofa->idMatrizDOFA],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($matrizdofa,['route'=>['matrizdofa.update',$matrizdofa->idMatrizDOFA],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'matrizdofa.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="matrizRiesgoProceso-form-fieldset">
				<div class="form-group" id='test'>
					{!!Form::label('fechaElaboracionMatrizDOFA', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaElaboracionMatrizDOFA',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idMatrizDOFA', 0, array('id' => 'idMatrizDOFA'))!!}
					      	<!-- Se oculta el eliminardetalle para eliminar cada una de las multis -->
					      	 {!!Form::hidden('eliminardetalle',null, array('id' => 'eliminardetalle'))!!}
			      	  		 {!!Form::hidden('eliminarFortaleza',null, array('id' => 'eliminarFortaleza'))!!}
					      	 {!!Form::hidden('eliminarAmenaza',null, array('id' => 'eliminarAmenaza'))!!}
					      	 {!!Form::hidden('eliminarDebilidad',null, array('id' => 'eliminarDebilidad'))!!}
						</div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>							
							{!!Form::select('Tercero_idResponsable',$Tercero, (isset($matrizdofa) ? $matrizdofa->Tercero_idResponsable : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Empleado Responsable"])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" >
					{!!Form::label('Proceso_idProceso', 'Procesos', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10" >
					  <div class="input-group">
					    <span class="input-group-addon">
					      <i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
					    </span>
					    {!!Form::select('Proceso_idProceso',$Proceso, (isset($matrizdofa) ? $matrizdofa->Proceso_idProceso : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Proceso"])!!}
					  </div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Detalles</div>
							<div class="panel-body" >
								<div class="panel-group" id="accordion">
								<!--  Detalle Oportunidades-->
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#oportunidad">Oportunidades (Externas)</a>
											</h4>
										</div>
										<div id="oportunidad" class="panel-collapse collapse" >
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group" style="overflow: auto;">																					
															<div class="form-group" id='test'>
														      	<div class="col-sm-12">

														        	<div class="row show-grid">
															         <div class="col-md-1" style="width: 40px;height: 36px;" onclick="oportunidad.agregarCampos(valoroportunidad,'A')">
																		<span class="glyphicon glyphicon-plus"></span>
																	</div>
															          <div class="col-md-1" style="width: 900px;display:inline-block;height:35px;">Oportunidades (Externas)</div>

															         <div class="col-md-1" style="width: 200px;display:inline-block;height:35px;">Matriz Riesgo Proceso</div>
															          <!-- este es el div para donde van insertando los registros --> 
															          <div id="oportunidad_detalle">
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
									<!--  Detalle Fortalezas-->
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#fortalezas">Fortalezas (Internas)</a>
											</h4>
										</div>
										<div id="fortalezas" class="panel-collapse collapse" >
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group" style="overflow: auto;">																					
															<div class="form-group" id='test'>
														      	<div class="col-sm-12">

														        	<div class="row show-grid">
															         <div class="col-md-1" style="width: 40px;height: 36px;" onclick="fortaleza.agregarCampos(valorfortaleza,'A')">
																		<span class="glyphicon glyphicon-plus"></span>
																	</div>
															          <div class="col-md-1" style="width: 900px;display:inline-block;height:35px;">Fortalezas (Internas)</div>

															         <div class="col-md-1" style="width: 200px;display:inline-block;height:35px;">Matriz Riesgo Proceso</div>
															          <!-- este es el div para donde van insertando los registros --> 
															          <div id="fortaleza_detalle">
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
										<!--  Detalle Amenazas-->
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#amenazas">Amenazas (Externas)</a>
											</h4>
										</div>
										<div id="amenazas" class="panel-collapse collapse" >
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group" style="overflow: auto;">																					
															<div class="form-group" id='test'>
														      	<div class="col-sm-12">

														        	<div class="row show-grid">
															         <div class="col-md-1" style="width: 40px;height: 36px;" onclick="amenaza.agregarCampos(valoramenaza,'A')">
																		<span class="glyphicon glyphicon-plus"></span>
																	</div>
															          <div class="col-md-1" style="width: 900px;display:inline-block;height:35px;">Amenazas (Externas)</div>

															         <div class="col-md-1" style="width: 200px;display:inline-block;height:35px;">Matriz Riesgo Proceso</div>
															          <!-- este es el div para donde van insertando los registros --> 
															          <div id="amenaza_detalle">
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
										<!--  Detalle Debilidades-->
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#debilidades">Debilidades (Internas)</a>
											</h4>
										</div>
										<div id="debilidades" class="panel-collapse collapse" >
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group" style="overflow: auto;">																					
															<div class="form-group" id='test'>
														      	<div class="col-sm-12">

														        	<div class="row show-grid">
															         <div class="col-md-1" style="width: 40px;height: 36px;" onclick="debilidad.agregarCampos(valordebilidad,'A')">
																		<span class="glyphicon glyphicon-plus"></span>
																	</div>
															          <div class="col-md-1" style="width: 900px;display:inline-block;height:35px;">Debilidades (Internas)</div>

															         <div class="col-md-1" style="width: 200px;display:inline-block;height:35px;">Matriz Riesgo Proceso</div>
															          <!-- este es el div para donde van insertando los registros --> 
															          <div id="debilidad_detalle">
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
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($matrizdofa))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
					</div>
				</div>
			</fieldset>
		</div>	

	{!!Form::close()!!}
	<script type="text/javascript">

		$('#fechaElaboracionMatrizDOFA').datetimepicker(({
			format: "YYYY-MM-DD"
		}));

    </script>
@stop