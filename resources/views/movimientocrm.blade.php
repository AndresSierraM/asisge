<?php 

$id = isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : 0; 
$campos = DB::select(
    'SELECT codigoDocumentoCRM, nombreDocumentoCRM, nombreCampoCRM,descripcionCampoCRM, 
            mostrarGridDocumentoCRMCampo, relacionTablaCampoCRM, relacionNombreCampoCRM, relacionAliasCampoCRM
    FROM documentocrm
    left join documentocrmcampo
    on documentocrm.idDocumentoCRM = documentocrmcampo.DocumentoCRM_idDocumentoCRM
    left join campocrm
    on documentocrmcampo.CampoCRM_idCampoCRM = campocrm.idCampoCRM
    where documentocrm.idDocumentoCRM = '.$id.' and mostrarVistaDocumentoCRMCampo = 1');


$datos = array();
$camposVista = '';
for($i = 0; $i < count($campos); $i++)
{
    $datos = get_object_vars($campos[$i]); 
    
    $camposVista .= $datos["nombreCampoCRM"].',';
}

	$idMovimientoCRMA = (isset($movimientocrm->idMovimientoCRM) ? $movimientocrm->idMovimientoCRM : 0);

?>
@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center><?php echo '('.$datos["codigoDocumentoCRM"].') '.$datos["nombreDocumentoCRM"];?></center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/movimientocrm.js'); !!}

{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->


<script>
	
	var movimientoCRMAsistentes = '<?php echo (isset($movimientocrm) ? json_encode($movimientocrm->movimientoCRMAsistentes) : "");?>';

	movimientoCRMAsistentes = (movimientoCRMAsistentes != '' ? JSON.parse(movimientoCRMAsistentes) : '');

	var movimientoCRMArchivo = '<?php echo (isset($movimientocrm) ? json_encode($movimientocrm->movimientoCRMArchivos) : "");?>';
		movimientoCRMArchivo = (movimientoCRMArchivo != '' ? JSON.parse(movimientoCRMArchivo) : '');

	var valorAsistentes = [0,'','','','',''];
	var valorArchivo = [0,'','',''];

	$(document).ready(function(){

		asistentes = new Atributos('asistentes','contenedor_asistentes','asistentes_');
		asistentes.campos = ['idMovimientoCRMAsistente','nombreMovimientoCRMAsistente','cargoMovimientoCRMAsistente','telefonoMovimientoCRMAsistente','correoElectronicoMovimientoCRMAsistente'];
		asistentes.etiqueta = ['input','input','input','input','input'];
		asistentes.tipo = ['hidden','text','text','text','text'];
		asistentes.estilo = ['','width: 330px; height:35px;','width: 270px;height:35px;','width: 150px;height:35px;','width: 230px;height:35px;'];
		asistentes.clase = ['','','','',''];
		asistentes.sololectura = [false,false,false,false,false];

		
		for(var j=0, k = movimientoCRMAsistentes.length; j < k; j++)
		{
			asistentes.agregarCampos(JSON.stringify(movimientoCRMAsistentes[j]),'L');
		}

		// for(var j=0, k = movimientoCRMArchivo.length; j < k; j++)
		// {
		// 	archivo.agregarCampos(JSON.stringify(movimientoCRMArchivo[j]),'L');
		// }

	});
</script>


	@if(isset($movimientocrm))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($movimientocrm,['route'=>['movimientocrm.destroy',$movimientocrm->idMovimientoCRM],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($movimientocrm,['route'=>['movimientocrm.update',$movimientocrm->idMovimientoCRM],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'movimientocrm.store','method'=>'POST'])!!}
	@endif
		<div id='form-section' >
				<fieldset id="movimientocrm-form-fieldset">	
					<div class="form-group" id='test'>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('numeroMovimientoCRM', 'Número', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-barcode"></i>
					              	</span>
									{!!Form::text('numeroMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el número del caso'])!!}
							      	{!!Form::hidden('idMovimientoCRM', null, array('id' => 'idMovimientoCRM'))!!}
							      	{!!Form::hidden('DocumentoCRM_idDocumentoCRM', $id, array('id' => 'DocumentoCRM_idDocumentoCRM'))!!}
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('asuntoMovimientoCRM', 'Asunto', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('asuntoMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el asunto del caso'])!!}
					    		</div>
					    	</div>
					    </div>
					    <?php
						
							if(strpos($camposVista, 'OrigenCRM_idOrigenCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('OrigenCRM_idOrigenCRM', 'Origen', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('OrigenCRM_idOrigenCRM',$origen, (isset($movimientocrm) ? $movimientocrm->OrigenCRM_idOrigenCRM : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}
						?>
					    <div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaSolicitudMovimientoCRM', 'F. Elaboración', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-barcode"></i>
					              	</span>
									{!!Form::text('fechaSolicitudMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha de Elaboración'])!!}
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$('#fechaSolicitudMovimientoCRM').datetimepicker(({
								format: "YYYY-MM-DD"
							}));
						</script>
						<?php 
							if(strpos($camposVista, 'fechaEstimadaSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaEstimadaSolucionMovimientoCRM', 'Estimada', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-barcode"></i>
					              	</span>
									{!!Form::text('fechaEstimadaSolucionMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha Estimada de Solución'])!!}
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$('#fechaEstimadaSolucionMovimientoCRM').datetimepicker(({
								format: "YYYY-MM-DD"
							}));
						</script>
						<?php
							}

							if(strpos($camposVista, 'fechaVencimientoMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaVencimientoMovimientoCRM', 'F. Vencimiento', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('fechaVencimientoMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la Fecha de Vencimiento'])!!}
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$('#fechaVencimientoMovimientoCRM').datetimepicker(({
								format: "YYYY-MM-DD"
							}));
						</script>
						<?php
							}

							if(strpos($camposVista, 'fechaRealSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('fechaRealSolucionMovimientoCRM', 'F. Real Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('fechaRealSolucionMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa la Fecha Real de Solución', 'readonly'=>'readonly'])!!}
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'AcuerdoServicio_idAcuerdoServicio') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('AcuerdoServicio_idAcuerdoServicio', 'Acuerdo de Servicio', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('AcuerdoServicio_idAcuerdoServicio',$acuerdoservicio, (isset($movimientocrm) ? $movimientocrm->AcuerdoServicio_idAcuerdoServicio : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'diasEstimadosSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('diasEstimadosSolucionMovimientoCRM', 'Días Est. Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('diasEstimadosSolucionMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa los días estimados de solución'])!!}
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'diasRealesSolucionMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('diasRealesSolucionMovimientoCRM', 'Días Reales Solución', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('diasRealesSolucionMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa los días reales de solución'])!!}
								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'prioridadMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('prioridadMovimientoCRM', 'Prioridad', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('prioridadMovimientoCRM',['Alta'=>'Alta','Media'=>'Media','Baja'=>'Baja'], (isset($movimientocrm) ? $movimientocrm->prioridadMovimientoCRM : 'Baja'),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idSolicitante') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idSolicitante', 'Solicitante', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('Tercero_idSolicitante',$solicitante, (isset($movimientocrm) ? $movimientocrm->Tercero_idSolicitante : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idSupervisor') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idSupervisor', 'Supervisor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('Tercero_idSupervisor',$supervisor, (isset($movimientocrm) ? $movimientocrm->Tercero_idSupervisor : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'Tercero_idAsesor') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('Tercero_idAsesor', 'Asesor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('Tercero_idAsesor',$asesor, (isset($movimientocrm) ? $movimientocrm->Tercero_idAsesor : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'CategoriaCRM_idCategoriaCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('CategoriaCRM_idCategoriaCRM', 'Categoría', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('CategoriaCRM_idCategoriaCRM',$categoria, (isset($movimientocrm) ? $movimientocrm->CategoriaCRM_idCategoriaCRM : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'EventoCRM_idEventoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('EventoCRM_idEventoCRM', 'Evento / Campaña', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('EventoCRM_idEventoCRM',$evento, (isset($movimientocrm) ? $movimientocrm->EventoCRM_idEventoCRM : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'LineaNegocio_idLineaNegocio') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('LineaNegocio_idLineaNegocio', 'Línea de Negocio', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('LineaNegocio_idLineaNegocio',$lineanegocio, (isset($movimientocrm) ? $movimientocrm->LineaNegocio_idLineaNegocio : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						<?php
							}

							if(strpos($camposVista, 'valorMovimientoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('valorMovimientoCRM', 'Valor', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
									{!!Form::text('valorMovimientoCRM',null,['class'=>'form-control','placeholder'=>'Ingresa el valor del documento'])!!}

								</div>
							</div>
						</div>
						
						<?php
							}

							if(strpos($camposVista, 'EstadoCRM_idEstadoCRM') !== false)
							{ 
						?>
						<div class="col-sm-6">
							<div class="col-sm-4">
								{!!Form::label('EstadoCRM_idEstadoCRM', 'Estado', array())!!}
							</div>
							<div class="col-sm-8">
					            <div class="input-group">
					              	<span class="input-group-addon">
					                	<i class="fa fa-pencil-square-o"></i>
					              	</span>
					              	{!!Form::select('EstadoCRM_idEstadoCRM',$estado, (isset($movimientocrm) ? $movimientocrm->EstadoCRM_idEstadoCRM : 0),["class" => "chosen-select form-control"])!!}

								</div>
							</div>
						</div>
						
						<?php
							}
						?>

						<div class="col-sm-12">
						<ul class="nav nav-tabs">
						<?php

						if(strpos($camposVista, 'detallesMovimientoCRM') !== false)
						{ 
						?>
							<li class="active"><a data-toggle="tab" href="#detalles">Detalles</a></li>

						<?php
						}
						
						if(strpos($camposVista, 'solucionMovimientoCRM') !== false)
						{ 
						?>
							<li><a data-toggle="tab" href="#solucion">Solución</a></li>
						<?php
						}

						if(strpos($camposVista, 'asistentesMovimientoCRM') !== false)
						{ 
						?>
					  		<li><a data-toggle="tab" href="#asistentes">Asistentes</a></li>
						<?php
						}

						if(strpos($camposVista, 'documentosMovimientoCRM') !== false)
						{ 
						?>
					  		<li><a data-toggle="tab" href="#documentos">Documentos</a></li>
						<?php
						}
						?>
					</ul>
					</div>

					<div class="tab-content">
					<?php
						if(strpos($camposVista, 'detallesMovimientoCRM') !== false)
						{ 
					?>
					  <div id="detalles" class="tab-pane fade in active">
					    <div class="col-sm-12">
							<div class="panel panel-primary">
					            <div class="panel-heading">
					                <i class="fa fa-pencil-square-o"></i> {!!Form::label('detallesMovimientoCRM', 'Detalles', array())!!}
					            </div>
					            <div class="panel-body">
					                
									<div class="col-sm-12">
							              {!!Form::textarea('detallesMovimientoCRM',null,['class'=>'ckeditor','placeholder'=>'Ingresa los detalles del documento'])!!}
									</div>

					            </div>
					        </div>
						</div>
					  </div>
					<?php
						}
					
						if(strpos($camposVista, 'solucionMovimientoCRM') !== false)
						{ 
					?>
					  <div id="solucion" class="tab-pane fade">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('solucionMovimientoCRM', 'Solución', array())!!}
                                </div>
                                <div class="panel-body">
                                    
									<div class="col-sm-12">
							              {!!Form::textarea('solucionMovimientoCRM',null,['class'=>'ckeditor','placeholder'=>'Ingresa la solución del documento'])!!}
									</div>

                                </div>
                            </div>
						</div>
					</div>
					<?php
						}
					if(strpos($camposVista, 'asistentesMovimientoCRM') !== false)
						{ 
					?>
					  <div id="asistentes" class="tab-pane fade">
					    <div class="panel-body">
							<div class="form-group" id='test'>
								<div class="col-sm-12">
									<div class="row show-grid">
										<div class="col-md-1" style="width: 40px;" onclick="asistentes.agregarCampos(valorAsistentes,'A')">
											<span class="glyphicon glyphicon-plus"></span>
										</div>
										<div class="col-md-1" style="width: 330px;">Nombre</div>
										<div class="col-md-1" style="width: 270px;">Cargo</div>
										<div class="col-md-1" style="width: 150px;">Tel&eacute;fono</div>
										<div class="col-md-1" style="width: 230px;">Correo</div>
										<div id="contenedor_asistentes">
										</div>
									</div>
								</div>
							</div>
						</div>

					  </div>
					<?php
						}
					if(strpos($camposVista, 'documentosMovimientoCRM') !== false)
						{ 
					?>
					  <div id="documentos" class="tab-pane fade">
					  	<div class="col-sm-12">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-pencil-square-o"></i> {!!Form::label('', 'Documentos', array())!!}
                                </div>
                                <div class="panel-body">
									<div class="col-sm-12">
										<div id="upload" class="col-md-12">
										    <div class="dropzone dropzone-previews" id="dropzonemovimientoCRMArchivo">
										    </div>  
										</div>	
 									
										
										<div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;">		
										{!!Form::hidden('archivoMovimientoCRMArray', '', array('id' => 'archivoMovimientoCRMArray'))!!}
											<?php
											if ($idMovimientoCRMA != '') 
											{
												$eliminar = '';
												$archivoSave = DB::Select('SELECT * from movimientocrmarchivo where MovimientoCRM_idMovimientoCRM = '.$idMovimientoCRMA);

												for ($i=0; $i <count($archivoSave) ; $i++) 
												{ 
													$archivoS = get_object_vars($archivoSave[$i]);

													echo '<div id="'.$archivoS['idMovimientoCRMArchivo'].'" class="col-lg-4 col-md-4">
									                    <div class="panel panel-yellow" style="border: 1px solid orange;">
									                        <div class="panel-heading">
									                            <div class="row">
									                                <div class="col-xs-3">
									                                    <a target="_blank" 
									                                    	href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaMovimientoCRMArchivo'].'">
									                                    	<i class="fa fa-book fa-5x" style="color: gray;"></i>
									                                    </a>
									                                </div>
									                                <div class="col-xs-9 text-right">
									                                    <div>'.str_replace('/movimientocrm/','',$archivoS['rutaMovimientoCRMArchivo']).'
									                                    </div>
									                                </div>
									                            </div>
									                        </div>
									                        <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idMovimientoCRMArchivo'].');">
									                            <div class="panel-footer">
									                                <span class="pull-left">Eliminar Documento</span>
									                                <span class="pull-right"><i class="fa fa-times"></i></span>
									                                <div class="clearfix"></div>
									                            </div>
									                        </a>
									                    </div>
									                </div>';

													echo '<input type="hidden" id="idMovimientoCRMArchivo[]" name="idMovimientoCRMArchivo[]" value="'.$archivoS['idMovimientoCRMArchivo'].'" >

													<input type="hidden" id="rutaMovimientoCRMArchivo[]" name="rutaMovimientoCRMArchivo[]" value="'.$archivoS['rutaMovimientoCRMArchivo'].'" >';
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

					</div>
					<?php
						}
					?>
					</div>

						
						

						
						
                              



				    </div>	

				</fieldset>	
				@if(isset($movimientocrm))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script>
    CKEDITOR.replace(('detallesMovimientoCRM','solucionMovimientoCRM'), {
        fullPage: true,
        allowedContent: true
      });  


    //--------------------------------- DROPZONE ---------------------------------------
	var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzonemovimientoCRMArchivo", {
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

    document.getElementById('archivoMovimientoCRMArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
    					//abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
						// console.log(fileList);
                        document.getElementById('archivoMovimientoCRMArray').value += file.name+',';
                        // console.log(document.getElementById('archivoMovimientoCRMArray').value);
                        i++;
                    });

</script>

@stop