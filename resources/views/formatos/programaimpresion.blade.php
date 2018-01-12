@extends('layouts.formato')

@section('contenido')

	{!!Form::model($programa)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					@foreach($programa as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center" style=" background-color:#337ab7; color:white;">Programa</td>
							</tr>
							<tr>
								<td><b>Programa</b></td>
								<td>{{$dato->nombrePrograma}}</td>
							</tr>
							<tr>
								<td><b>Fecha de Elaboracion</b></td>
								<td>{{$dato->fechaElaboracionPrograma}}</td>
							</tr>
							<tr>
								<td><b>Clasificacion de Riesgo</b></td>
								<td>{{$dato->nombreClasificacionRiesgo}}</td>
							</tr>
							<tr>
								<td><b>Alcance</b></td>
								<td>{{$dato->alcancePrograma}}</td>
							</tr>
							<tr>
								<td><b>Objetivo</b></td>
								<td>{{$dato->nombreCompaniaObjetivo}}</td>
							</tr>
							<tr>
								<td><b>Objetivo Especifico</b></td>
								<td><?php echo $dato->objetivoEspecificoPrograma ?></td>
							</tr>
							<tr>
								<td><b>Elaborado Por</b></td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							
						</thead>
					</table>
					@endforeach

									     	<!--  -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Interacci&oacute;n de los procesos</b></td>
							@foreach($ProgramaArchivo as $archivo)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($archivo->rutaProgramaArchivo, -4) === ".pdf" or (substr($archivo->rutaProgramaArchivo, -5)) === ".docx" or (substr($archivo->rutaProgramaArchivo, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$archivo->rutaProgramaArchivo.'"';
								 	}							
							?>
							@endforeach
								</td>								
							</tr>	
			     		</thead>
			     	</table>

		            <table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Actividad</b></td>
								<td style=" background-color:#848484; color:white;"><b>Responsable</b></td>
								<td style=" background-color:#848484; color:white;"><b>Documento</b></td>
								<td style=" background-color:#848484; color:white;"><b>Fecha Planeada</b></td>
								<td style=" background-color:#848484; color:white;"><b>Recurso Planeado</b></td>
								<td style=" background-color:#848484; color:white;"><b>Fecha Ejecutada</b></td>
								<td style=" background-color:#848484; color:white;"><b>Recurso Ejecutado</b></td>
								<td style=" background-color:#848484; color:white;"><b>Observacion</b></td>
							</tr>
						</thead>
						<tbody>
							@foreach($programaDetalle as $dato)
							<tr>
								<td>{{$dato->actividadProgramaDetalle}}</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>{{$dato->nombreDocumentoSoporte}}</td>
								<td>{{$dato->fechaPlaneadaProgramaDetalle}}</td>
								<td>{{$dato->recursoPlaneadoProgramaDetalle}}</td>
								<td>{{$dato->fechaEjecucionProgramaDetalle}}</td>
								<td>{{$dato->recursoEjecutadoProgramaDetalle}}</td>
								<td>{{$dato->observacionProgramaDetalle}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop	