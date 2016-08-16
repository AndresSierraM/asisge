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

$camposVista = '';
for($i = 0; $i < count($campos); $i++)
{
    $datos = get_object_vars($campos[$i]); 
    
    $camposVista .= $datos["nombreCampoCRM"].',';
}


?>
@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center><?php echo '('.$datos["codigoDocumentoCRM"].') '.$datos["nombreDocumentoCRM"];?></center></h3>@stop

@section('content')
@include('alerts.request')

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

							if(strpos($camposVista, 'detallesMovimientoCRM') !== false)
							{ 
						?>
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
						<?php
							}

							if(strpos($camposVista, 'solucionMovimientoCRM') !== false)
							{ 
						?>
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
						<?php
							}
						?>


						
                              



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
</script>

@stop