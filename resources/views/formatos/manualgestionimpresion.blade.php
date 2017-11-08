@extends('layouts.formato')

@section('contenido')
	{!!Form::model($ManualGestionEncabezado)!!}
	<!-- Se quema el overflow-y auto apra que salga la barra vertical cuando tiene mucha informacion -->
	<html lang="es" style="overflow-y: auto;">
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($ManualGestionEncabezado as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"  style=" background-color:#337ab7; color:white;">Manual del sistema de gesti&oacute;n</td>
							</tr>
							<tr>
								<td><b>C&oacute;digo</b></td>
								<td>{{$encabezado->codigoManualGestion}}</td>
							</tr>
							<tr>
								<td><b>Nombre</b></td>
								<td>{{$encabezado->nombreManualGestion}}</td>
								
							</tr>
							<tr>
								<td><b>Fecha Elaboraci&oacute;n</b></td>
								<td>{{$encabezado->fechaManualGestion}}</td>

							</tr>
							<tr>
								<td><b>Empleador</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td><b>Firma</b></td>
								<td><?php echo '<img style="width:20%; height:20%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$encabezado->firmaEmpleadorManualGestion.'"';?></td>
							</tr>						 
						</thead>
					</table>
					<!-- Acordeon generalidades -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Generalidades</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->generalidadesManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<!-- Acordeon Mision -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Misi&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->misionManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     		<!-- Acordeon Vision -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Visi&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->visionManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     		<!-- Acordeon Valores -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Valores</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->valoresManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<!-- Acordeon Politicas -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Pol&#237;ticas</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->politicasManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<!-- Acordeon Principios -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Principios</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->principiosManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<!-- Acordeon Metas -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Metas</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->metasManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<!-- Acordeon Objetivos -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Objetivos</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->objetivosManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     		<!-- Acordeon Objetivo del manual de calidad -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Objetivo del manual de calidad</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->objetivoCalidadManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     		<!-- Acordeon Alcance del sistema de gesti&oacute;n -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Alcance del sistema de gesti&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->alcanceManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     		<!-- Acordeon Exclusiones -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Exclusiones</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->exclusionesManualGestion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>			     	
				@endforeach	
					 <!-- Multiregistro Partes interesadas-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Partes interesadas</td>
			     			</tr>							
							<tr>
								<td><b>Parte interesada</b></td>
								<td><b>Necesidades o requerimientos</b></td>
								<td><b>Cómo se cumplen las necesidades / requerimienos</b></td>
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($ManualGestionInventario as $inventario)
						       <tr>
							        <td>{{$inventario->interesadoManualGestionParte}}</td>
							        <td>{{$inventario->necesidadManualGestionParte}}</td>
							        <td>{{$inventario->cumplimientoManualGestionParte}}</td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
			     					     	<!--adjuntos Interacci&oacute;n de los procesos  -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Interacci&oacute;n de los procesos</b></td>
							@foreach($ManualGestionProceso as $proceso)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($proceso->rutaManualGestionProceso, -4) === ".pdf" or (substr($proceso->rutaManualGestionProceso, -5)) === ".docx" or (substr($proceso->rutaManualGestionProceso, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$proceso->rutaManualGestionProceso.'"';
								 	}							
							?>
							@endforeach
								</td>								
							</tr>	
			     		</thead>
			     	</table>
			     				     					     	<!--adjuntos Estructura organizacional -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Estructura organizacional</b></td>
							@foreach($ManualGestionEstructura as $estructura)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($estructura->rutaManualGestionEstructura, -4) === ".pdf" or (substr($estructura->rutaManualGestionEstructura, -5)) === ".docx" or (substr($estructura->rutaManualGestionEstructura, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$estructura->rutaManualGestionEstructura.'"';
								 	}							
							?>
							@endforeach
								</td>								
							</tr>	
			     		</thead>
			     	</table>
			     		     					     	<!--adjuntos Archivos -->
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Archivos</b></td>
							@foreach($ManualGestionArchivo as $archivo)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($archivo->rutaManualGestionAdjunto, -4) === ".pdf" or (substr($archivo->rutaManualGestionAdjunto, -5)) === ".docx" or (substr($archivo->rutaManualGestionAdjunto, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$archivo->rutaManualGestionAdjunto.'"';
								 	}							
							?>
							@endforeach
								</td>								
							</tr>	
			     		</thead>
			     	</table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



