@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Grupos de Apoyo</center>
	</h3>
@stop

@section('content')

	@include('alerts.request')
	
	@if(isset($grupoApoyo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($grupoApoyo,['route'=>['grupoapoyo.destroy',$grupoApoyo->idGrupoApoyo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($grupoApoyo,['route'=>['grupoapoyo.update',$grupoApoyo->idGrupoApoyo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'grupoapoyo.store','method'=>'POST'])!!}
	@endif

	{!!Html::script('js/grupoapoyo.js')!!} 


<script>


var GrupoApoyoPermiso = '<?php echo (isset($grupoApoyo) ? json_encode($grupoApoyo->GrupoApoyoPermiso) : "");?>';
    GrupoApoyoPermiso = (GrupoApoyoPermiso != '' ? JSON.parse(GrupoApoyoPermiso) : '');

  $(document).ready(function(){
    protRol = new Atributos('protRol','contenedor_grupoapoyo','grupoapoyoseleccion');

      protRol.altura = '35px';
      protRol.campoid = 'idGrupoApoyoPermiso';
      protRol.campoEliminacion = 'eliminarRol';
      protRol.campos   = [
      'idGrupoApoyoPermiso', 
      'Rol_idRol',
      'nombreRol',  
      'adicionarGrupoApoyoPermiso',
      'modificarGrupoApoyoPermiso',
      'eliminarGrupoApoyoPermiso',
      'consultarGrupoApoyoPermiso'
      ];

      protRol.etiqueta = [
      'input',
      'input', 
      'input',  
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox'
      ];

      protRol.tipo = [
      'hidden',
      'hidden',
      'text',
      'checkbox',
      'checkbox',
      'checkbox',
      'checkbox',

      ];

      protRol.estilo = [
      '',
      '',
      'width: 530px;height:35px;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;',
      'width: 70px;height:35px; display:inline-block;'
      ];

      protRol.clase    = ['','','','','','','']; 
      protRol.sololectura = [true,true,true,true,true,true,true];  
      protRol.funciones = ['','','','','','',''];
      protRol.completar = ['off','off','off','off','off','off','off'];
      protRol.opciones = ['','','','','','','']

      for(var j=0, k = GrupoApoyoPermiso.length; j < k; j++)
      {
        protRol.agregarCampos(JSON.stringify(GrupoApoyoPermiso[j]),'L');
        llenarNombreRol($("#Rol_idRol"+j).val());
        // Llamar la funcion en el for para que por cada registro de la multiregistro el haga el ajax de llenar el nombre del rol
        // enviando el respectivo id del rol 

      }


    });

  </script>

		<div id="form_section">
			<fieldset id="grupoapoyo-form-fieldset">
				<div class="form-group required" id='test'>
					{!!Form::label('codigoGrupoApoyo', 'C&oacute;digo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							<input type="hidden" id="token" value="{{csrf_token()}}"/>
							{!!Form::text('codigoGrupoApoyo', null, ['class'=>'form-control','placeholder'=>'Ingresa el c&oacute;digo','id' => 'codigoGrupoApoyo'])!!}
							{!!Form::hidden('idGrupoApoyo', null, array('id' => 'idGrupoApoyo'))!!}
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('nombreGrupoApoyo', 'Nombre', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
							</span>
							{!!Form::text('nombreGrupoApoyo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
						</div>
					</div>
				</div>
				<div class="form-group required" >
			        {!!Form::label('FrecuenciaMedicion_idFrecuenciaMedicion', 'Frecuencia Reuniones', array('class' => 'col-sm-2 control-label'))!!}
			        <div class="col-sm-10" >
			          <div class="input-group">
			            <span class="input-group-addon">
			              <i class="fa fa-credit-card" ></i>
			            </span>
			            {!!Form::select('FrecuenciaMedicion_idFrecuenciaMedicion',$frecuenciaMedicion, (isset($tipoInspeccion) ? $tipoInspeccion->frecuenciaMedicion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la frecuencia de medici&oacute;n"])!!}
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
												<a data-toggle="collapse" data-parent="#accordion" href="#convocatoria">Convocatoria Votaci&oacute;n</a>
											</h4>
										</div>
										<div id="convocatoria" class="panel-collapse collapse in">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('convocatoriaVotacionGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa la convocatoria'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#acta" href="#acta">Acta de Escrutinio y Votaci&oacute;n</a>
											</h4>
										</div>
										<div id="acta" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('actaEscrutinioGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa el acta'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#constitucion">Acta de Constituci&oacute;n</a>
											</h4>
										</div>
										<div id="constitucion" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="form-group" id='test'>
													<div class="col-sm-10" style="width: 100%;">
														<div class="input-group">
															{!!Form::textarea('actaConstitucionGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa el acta'])!!}
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
										<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#permisos">Permisos</a>
											</h4>
										</div>

										<!-- Nuevo cambio multiregistro con permisos  -->
										<div id="permisos" class="panel-collapse collapse">
									   <div class="panel-body" >
								          <div class="form-group" id='test'>
								            <div class="col-sm-12">
								              <div class="panel-body" >
								                <div class="form-group" id='test'>
								                  <div class="col-sm-12">
								                    <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
								                      <div style="overflow:auto; height:350px;">
								                        <div style="width: 100%; display: inline-block;">
								                          <div class="col-md-1" style="width:40px;height: 42px; cursor:pointer;" onclick="abrirModalRol();">
								                            <span class="glyphicon glyphicon-plus"></span>
								                          </div>
								                          <div class="col-md-1" style="width: 530px;" >Rol</div>
								                          <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Adicionar" class="fa fa-plus"></span></center></div>
								                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Modificar" class="fa fa-pencil"></span></center></div>
								                      <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Eliminar" class="fa fa-trash"></span></center></div>          
								                       <div class="col-md-1" style="width: 70px;height: 42px; cursor:pointer;"><center><span title="Consultar" class="fa fa-search"></span></center></div>
								                          <div id="contenedor_grupoapoyo">
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
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($grupoApoyo))
							{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
						@else
							{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						@endif
						</br></br></br></br>
					</div>
				</div>
			</fieldset>
		</div>	
	{!!Form::close()!!}
@stop


<div id="ModalRoles" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Roles</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="roles" name="roles" src="http://'.$_SERVER["HTTP_HOST"].'/rolgridselect"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>

