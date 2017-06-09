@extends('layouts.formato')

@section('contenido')
	{!!Form::model($accidenteS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($accidenteS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Accidentes</td>
							</tr>
							<tr>
								<td>N&#250;mero</td>
								<td>{{$encabezado->numeroAccidente}}</td>
							</tr>
							<tr>
								<td>Descripci&#243;n</td>
								<td>{{$encabezado->nombreAccidente}}</td>
								
							</tr>
							<tr>
								<td>Clase de Accidente</td>
								<td>{{$encabezado->clasificacionAccidente}}</td>

							</tr>
							<tr>
								<td>Coord. Investigaci&#243;n</td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td>Firma</td>
								<td><?php echo '<img style="width:40%; height:40%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$encabezado->firmaCoordinadorAccidente.'"'; ?></td>
							</tr>
						</thead>
					</table>
					  <!-- Pestaña Datos Generales del Trabajador -->
				        <table  class="table table-striped table-bordered" width="70%">
				     <thead>
			     			<tr>
				     			<td><b>Datos Generales del Trabajador</b></td>
			     			</tr>
					       	<tr>
								<td><b>Empleado</b></td>
								<td>{{$encabezado->nombreCompletoEmpleado}}</td>
							</tr>
							<tr>
								<td><b>Edad</b></td>
								<td>{{$encabezado->edadEmpleadoAccidente}}</td>
							</tr>
							<tr>
								<td><b>Ausencia</b></td>
								<td>{{$encabezado->nombreAusentismo}}</td>
							</tr>
							<tr>
								<td><b>Tiempo Servicio</b></td>
								<td>{{$encabezado->tiempoServicioAccidente}}</td>
							</tr>
							<tr>
								<td><b>Area/Secci&#243;n</b></td>
								<td>{{$encabezado->nombreProceso}}</td>
							</tr>
							<tr>
								<td><b>Oficio habitual</b></td>
								<td>{{$encabezado->EnSuLaborAccidenteS}}</td>
							</tr>
							<tr>
								<td><b>Labor Realizada</b></td>
								<td>{{$encabezado->laborAccidente}}</td>
							</tr>
							<tr>
								<td><b>En la Empresa</b></td>
								<td>{{$encabezado->enLaEmpresaAccidenteS}}</td>
							</tr>
							<tr>
								<td><b>Lugar</b></td>
								<td>{{$encabezado->lugarAccidente}}
							</tr>
					      </thead>
				     </table>
				      <!-- Pestaña Datos Generales sobre el Accidente -->
				        <table  class="table table-striped table-bordered" width="70%">
				     <thead>
			     			<tr>
				     			<td><b>Datos Generales Sobre el Accidente</b></td>
			     			</tr>
					       	<tr>
								<td><b>Fecha/Hora</b></td>
								<td>{{$encabezado->fechaOcurrenciaAccidente}}</td>
							</tr>
							<tr>
								<td><b>Tiempo en Labor</b></td>
								<td>{{$encabezado->tiempoEnLaborAccidente}}</td>
							</tr>
							<tr>
								<td><b>Tarea</b></td>
								<td>{{$encabezado->tareaDesarrolladaAccidente}}</td>
							</tr>
							<tr>
								<td><b>Descripcion Ampliada</b></td>
								<td><?php echo $encabezado->descripcionAccidente;?></td>
							</tr>
							<tr>
								<td><b>Observaciones Trabajador</b></td>
								<td><?php echo $encabezado->observacionTrabajadorAccidente;?></td>
							</tr>
							<tr>
								<td><b>Observaciones Empresa</b></td>
								<td><?php echo $encabezado->observacionEmpresaAccidente	;?></td>
							</tr>
					      </thead>
				     </table>
				      <!-- Pestaña Analisis del Accidente o Incidente -->
				        <table  class="table table-striped table-bordered" width="70%">
				     <thead>
			     			<tr>
				     			<td><b>An&#225;lisis del Accidente o Incidente</b></td>
			     			</tr>
					       	<tr>
								<td><b>Agente y Mecanismo</b></td>
								<td><?php echo $encabezado->agenteYMecanismoAccidente;?></td>
							</tr>
							<tr>
								<td><b>Naturalesa de la Lesi&#243;n</b></td>
								<td><?php echo $encabezado->naturalezaLesionAccidente;?></td>
							</tr>
							<tr>
								<td><b>Parte del Cuerpo Afectada</b></td>
								<td><?php echo $encabezado->parteCuerpoAfectadaAccidente;?></td>
							</tr>
							<tr>
								<td><b>Tipo de Accidente</b></td>
								<td><?php echo $encabezado->tipoAccidente;?></td>
							</tr>
					      </thead>
				     </table>
				     @endforeach	
				       <!-- Recomendaciones para la Intervencion de las Causas Encontradas en el Analisis,Evaluacion y Control-->
				        <table  class="table table-striped table-bordered" width="70%">
					     	<thead>
					     			<tr>
						     			<td><b>Recomendaciones para la Intervenci&#243;n de las Causas Encontradas en el Analisis,Evaluaci&#243;n y Control</b></td>
					     			</tr>
							       	<tr>
										<td><b>Controles a Implementar</b></td>
										<td colspan=3><b><center>Tipo de Control</center></b></td>
										<td colspan=3>&nbsp;</td>

									</tr>
									<tr>
										<td><b>Segun Lista de Causas</b></td>
										<td><b>Fuente</b></td>
										<td><b>Medio</b></td>
										<td><b>Persona</b></td>
										<td><b>Fecha de Verificaci&#243;n</b></td>
										<td><b>Medida Efectiva</b></td>
										<td><b>Area Responsable</b></td>
									</tr>
							</thead>
							<tbody>
							@foreach($accidenteRecomendacions as $recomendacion)
								<tr>
									<td>{{$recomendacion->controlAccidenteRecomendacion}}</td>
									<td>{{$recomendacion->fuenteAccidenteRecomendacionR}}</td>
									<td>{{$recomendacion->medioAccidenteRecomendacionR}}</td>
									<td>{{$recomendacion->personaAccidenteRecomendacionR}}</td>
									<td>{{$recomendacion->fechaVerificacionAccidenteRecomendacion}}</td>
									<td>{{$recomendacion->medidaEfectivaAccidenteRecomendacion}}</td>
									<td>{{$recomendacion->nombreProceso}}</td>
								</tr>
							</tbody>
						 	@endforeach				      
				     </table>
				      <!-- Equipo de Investigacion-->
				        <table  class="table table-striped table-bordered" width="70%">
					     	<thead>
					     			<tr>
						     			<td><b>Equipo de Investigación</b></td>
					     			</tr>
							       	<tr>
										<td><b>Nombre Investigador</b></td>
									</tr>
							</thead>
							<tbody>
							@foreach($accidenteEquipoS as $equipo)
								<tr>
									<td>{{$equipo->nombreCompletoTercero}}</td>
								</tr>
							</tbody>
						 	@endforeach				      
				     </table>
				     <!-- Equipo de Investigacion-->
				        <table  class="table table-striped table-bordered" width="70%">
					     	<thead>
					     			<tr>
						     			<td><b>Archivos</b></td>
					     			</tr>							      
							</thead>
							<tbody>
							@foreach($accidenteArchivoS as $archivo)
								<tr>
									<td><?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($archivo->rutaAccidenteArchivo, -4) === ".pdf" or (substr($archivo->rutaAccidenteArchivo, -5)) === ".docx")
									{
										echo'Archivo Adjunto';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:60%; height:60%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$archivo->rutaAccidenteArchivo.'"';
								 	}
							?></td>
								</tr>
							</tbody>
						 	@endforeach				      
				     </table>
				      <!--Notas -->
			        <table  class="table table-striped table-bordered" width="70%">
				     	@foreach($accidenteS as $encabezado)				        
				     	<thead>
			     			<tr>
				     			<td><b>Notas</b></td>
			     			</tr>
					       	<tr>
								<td><?php echo $encabezado->observacionAccidente;?></td>
							</tr>
					      </thead>
				     	@endforeach
				     </table>						    
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



