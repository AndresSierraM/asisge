@extends('layouts.formato')

@section('contenido')
	{!!Form::model($ActaCapacitaciones)!!}
	{!!Html::script('js/actacapacitacion.js')!!}


	<!-- Se quema el overflow-y auto apra que salga la barra vertical cuando tiene mucha informacion -->
	<html lang="es" style="overflow-y: auto;">
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($ActaCapacitaciones as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"  style=" background-color:#337ab7; color:white;">Acta de Capacitaci&oacute;n</td>
							</tr>
							<tr>
								<td><b>Número</b></td>
								<td>{{$encabezado->numeroActaCapacitacion}}</td>
							</tr>
							<tr>
								<td><b>Fecha</b></td>
								<td>{{$encabezado->fechaElaboracionActaCapacitacion}}</td>								
							</tr>
								<tr>
								<td><b>Plan capacitaci&oacute;n</b></td>
								<td>{{$encabezado->nombrePlanCapacitacion}}</td>								
							</tr>	
							</tr>
								<tr>
								<td><b>Tipo</b></td>
								<td>{{$encabezado->tipoPlanCapacitacion}}</td>								
							</tr>	
							</tr>
								<tr>
								<td><b>Responsable</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>	
							</tr>
								<tr>
								<td><b>Centro de costos</b></td>
								<td>{{$encabezado->nombreCentroCosto}}</td>								
							</tr>												
						</thead>
					</table>
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Objetivos</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->objetivoPlanCapacitacion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
     				<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Personal involucrado</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->personalInvolucradoPlanCapacitacion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
	     			<table class="table" width="100%">
     				  	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Programaci&oacute;n</td>
					       	</tr>
				      	</thead>
						<thead>
							<tr>
								<td><b>Fecha inicio</b></td>
								<td>{{$encabezado->fechaInicioPlanCapacitacion}}</td>
							</tr>
							<tr>
								<td><b>Fecha fin</b></td>
								<td>{{$encabezado->fechaFinPlanCapacitacion}}</td>								
							</tr>
											
						</thead>
					</table>
					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">M&eacute;todo de eficacia</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->metodoEficaciaPlanCapacitacion;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
					@endforeach
						 <!-- Multiregistro Temas-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Temas</td>
			     			</tr>							
							<tr>
								<td><b>Descripci&oacute;</b></td>
								<td><b>Capacitador</b></td>
								<td><b>Fecha</b></td>
								<td><b>Hora</b></td>
								<td><b>Duracion en horas </b></td>
								<td><b>Dictado</b></td>
								<td><b>Cumple objetivo</b></td>
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($ActaCapacitacionTema as $Tema)
						       <tr>
							        <td>{{$Tema->nombrePlanCapacitacionTema}}</td>
							        <td>{{$Tema->nombreCompletoTercero}}</td>
							        <td>{{$Tema->fechaActaCapacitacionTema}}</td>
							        <td>{{$Tema->horaActaCapacitacionTema}}</td>
							        <td>{{$Tema->duracionActaCapacitacionTema}}</td>
							        <td>{{($Tema->dictadaActaCapacitacionTema  == 1 ? 'SI' : 'NO')}}</td>
							        <td>{{($Tema->cumpleObjetivoActaCapacitacionTema  == 1 ? 'SI' : 'NO')}}</td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
			     	 <!-- Multiregistro Asistentes-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Asistentes</td>
			     			</tr>							
							<tr>
								<td><b>Nombre</b></td>
								<td><b>Firma</b></td>
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($ActaCapacitacionAsistentes as $Asistente)
						       <tr>
							        <td>{{$Asistente->nombreCompletoTercero}}</td>

							        <td><?php echo '<img style="width:20%; height:20%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$Asistente->firmaActaCapacitacionAsistente.'"';?></td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
	     			<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Archivos</b></td>
							@foreach($ActaCapacitacionArchivos as $Archivo)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($Archivo->rutaActaCapacitacionArchivo, -4) === ".pdf" or (substr($Archivo->rutaActaCapacitacionArchivo, -5)) === ".docx" or (substr($Archivo->rutaActaCapacitacionArchivo, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$Archivo->rutaActaCapacitacionArchivo.'"';
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



