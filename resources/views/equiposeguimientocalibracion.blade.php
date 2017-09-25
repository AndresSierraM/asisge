@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		Calibraci&#243;n de Equipos de seguimiento y medici&#243;n
	</h3>
@stop
@section('content')

	@include('alerts.request')
	{!!Html::script('js/equiposeguimientocalibracion.js')!!}

<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->



<?php 
//Se pregunta  si existe el id de Equipo Seguimiento Calibracion  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
$idEquipoSeguimientoCalibracion = (isset($equiposeguimientocalibracion) ? $equiposeguimientocalibracion->idEquipoSeguimientoCalibracion : 0);
?>
<script>
$(document).ready(function(){ 

  codigo = "<?php echo @$equiposeguimientocalibracion->EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle;?>";
  if ($("#EquipoSeguimiento_idEquipoSeguimiento").length > 0  && $("#EquipoSeguimiento_idEquipoSeguimiento").val() !== '') 
  {
      llenarCodigoResponsable($("#EquipoSeguimiento_idEquipoSeguimiento").val(),codigo);
      $("#EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle").trigger("chosen:updated").prop('selected','selected');
      $("#EquipoSeguimiento_idEquipoSeguimiento").trigger("chosen:updated").prop('selected','selected');
  }
  });              

</script>
	@if(isset($equiposeguimientocalibracion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($equiposeguimientocalibracion,['route'=>['equiposeguimientocalibracion.destroy',$equiposeguimientocalibracion->idEquipoSeguimientoCalibracion],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($equiposeguimientocalibracion,['route'=>['equiposeguimientocalibracion.update',$equiposeguimientocalibracion->idEquipoSeguimientoCalibracion],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'equiposeguimientocalibracion.store','method'=>'POST', 'files' => true])!!}
	@endif
		
		<div id="form_section">
			<fieldset id="equiposeguimientocalibracion-form-fieldset">
				<div class="form-group required" id='test'>
					{!!Form::label('fechaEquipoSeguimientoCalibracion', 'Fecha', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-calendar" style="width: 14px;"></i>
			              	</span>
			              	<input type="hidden" id="token" value="{{csrf_token()}}"/>
			              	{!!Form::text('fechaEquipoSeguimientoCalibracion',null,['class'=>'form-control','placeholder'=>'Seleccione la fecha'])!!}
					      	{!!Form::hidden('idEquipoSeguimientoCalibracion', 0, array('id' => 'idEquipoSeguimientoCalibracion'))!!}
					      	<!-- Se oculta el ID de detalle de Seguimiento Detalle -->					
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!! Form::label('EquipoSeguimiento_idEquipoSeguimiento', 'Equipo', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>
			              								<!-- Se ejecuta un onchange para llenar la lista de Codigo y Responsable -->
							{!!Form::select('EquipoSeguimiento_idEquipoSeguimiento',$EquipoSeguimientoE, (isset($equiposeguimientocalibracion) ? $equiposeguimientocalibracion->EquipoSeguimiento_idEquipoSeguimiento : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Equipo",'onchange'=>"llenarCodigoResponsable(this.value,codigo);"])!!}  
					    </div>
					</div>
				</div>
				<div class="form-group " id='test'>
					{!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>							
						    {!!Form::text('Tercero_idResponsable',null,['class'=>'form-control','readonly','placeholder'=>'Debe seleccionar el Equipo', 'autocomplete' => 'off'])!!}      
					    </div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle', 'C&#243;digo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>
			              	{!!Form::select('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle',[],null,['id'=>'EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle','class' => 'form-control','style'=>'padding-left:2px;','placeholder'=>'Seleccione el C&#243;digo','onchange'=>"CompararErrorEquipo(this.value)"])!!}
					    </div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!! Form::label('Tercero_idProveedor', 'Proveedor', array('class' => 'col-sm-2 control-label')) !!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-caret-square-o-down" style="width: 14px;"></i>
			              	</span>
							{!!Form::select('Tercero_idProveedor',$TerceroProveedor, (isset($equiposeguimientocalibracion) ? $equiposeguimientocalibracion->Tercero_idProveedor : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Proveedor"])!!}  
					    </div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('errorEncontradoEquipoSeguimientoCalibracion', 'Error Encontrado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('errorEncontradoEquipoSeguimientoCalibracion',null,['class'=>'form-control','placeholder'=>'Ingresa el Error Encontrado','onchange'=>"CompararErrorEquipo($('#EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle').val())"])!!}
					    </div>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br>
				<div class="form-group" id='test'>
					{!!Form::label('resultadoEquipoSeguimientoCalibracion', 'Resultado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-spinner" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('resultadoEquipoSeguimientoCalibracion',null,['class'=>'form-control','readonly','placeholder'=>'Debe seleccionar el Equipo'])!!}
					    </div>
					</div>
				</div>
				<div class="form-group" id='test'>
					{!!Form::label('accionEquipoSeguimientoCalibracion', 'Acci&#243;n a tomar', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o" style="width: 14px;"></i>
			              	</span>							
							{!!Form::text('accionEquipoSeguimientoCalibracion',null,['class'=>'form-control','placeholder'=>'Ingresa la Acci&#243;n a tomar'])!!}
					    </div>
					</div>
				</div>
				<br><br><br><br>
		                            <!-- Nuevo pestaña para adjuntar archivos -->
		                            							<!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
				<div class="panel panel-default" style="display:inline-block;width:100%">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#archivos">Archivos</a>
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
									    <div class="dropzone dropzone-previews" id="dropzoneActaGrupoApoyoArchivo" style="overflow: auto;">
									    </div>  
									</div>	
										<div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px; overflow: auto;">		
															{!!Form::hidden('archivoEquipoSeguimientoCalibracionArray', '', array('id' => 'archivoEquipoSeguimientoCalibracionArray'))!!}
											<?php
											
											// Cuando este editando el archivo 
											if ($idEquipoSeguimientoCalibracion != '')  //Se pregunta si el id de acta de capacitacion es diferente de vacio (que es la tabla papá)
											{
												$eliminar = '';
												$archivoSave = DB::Select('SELECT * from equiposeguimientocalibracionarchivo where EquipoSeguimientoCalibracion_idEquipoSeguimientoCalibracion = '.$idEquipoSeguimientoCalibracion);
												for ($i=0; $i <count($archivoSave) ; $i++) 
												{ 
													$archivoS = get_object_vars($archivoSave[$i]);

													echo '<div id="'.$archivoS['idEquipoSeguimientoCalibracionArchivo'].'" class="col-lg-4 col-md-4">
									                    <div class="panel panel-yellow" style="border: 1px solid orange;">
									                        <div class="panel-heading">
									                            <div class="row">
									                                <div class="col-xs-3">
									                                    <a target="_blank" 
									                                    	href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaEquipoSeguimientoCalibracionArchivo'].'">
									                                    	<i class="fa fa-book fa-5x" style="color: gray;"></i>
									                                    </a>
									                                </div>

									                                <div class="col-xs-9 text-right">
									                                    <div>'.str_replace('/equiposeguimientocalibracion/','',$archivoS['rutaEquipoSeguimientoCalibracionArchivo']).'
									                                    </div>
									                                </div>
									                            </div>
									                        </div>
									                        <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idEquipoSeguimientoCalibracionArchivo'].');">
									                            <div class="panel-footer">
									                                <span class="pull-left">Eliminar Documento</span>
									                                <span class="pull-right"><i class="fa fa-times"></i></span>
									                                <div class="clearfix"></div>
									                            </div>
									                        </a>
									                    </div>
									                </div>';

													echo '<input type="hidden" id="idEquipoSeguimientoCalibracionArchivo[]" name="idEquipoSeguimientoCalibracionArchivo[]" value="'.$archivoS['idEquipoSeguimientoCalibracionArchivo'].'" >

													<input type="hidden" id="rutaEquipoSeguimientoCalibracionArchivo[]" name="rutaEquipoSeguimientoCalibracionArchivo[]" value="'.$archivoS['rutaEquipoSeguimientoCalibracionArchivo'].'" >';
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
				<br><br>
				<div class="form-group">
					<div class="col-sm-12">
						@if(isset($equiposeguimientocalibracion))
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

		$('#fechaEquipoSeguimientoCalibracion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));





    //--------------------------------- DROPZONE ---------------------------------------
	var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneActaGrupoApoyoArchivo", {
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

    document.getElementById('archivoEquipoSeguimientoCalibracionArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
    					//abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
						// console.log(fileList);
                        document.getElementById('archivoEquipoSeguimientoCalibracionArray').value += file.name+',';
                        // console.log(document.getElementById('archivoEquipoSeguimientoCalibracionArray').value);
                        i++;
                    });


    </script>
@stop