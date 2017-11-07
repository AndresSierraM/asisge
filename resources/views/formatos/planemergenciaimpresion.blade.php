@extends('layouts.formato')

@section('contenido')
	{!!Form::model($PlanEmergenciaEncabezado)!!}
	<!-- Se quema el overflow-y auto apra que salga la barra vertical cuando tiene mucha informacion -->
	<html lang="es" style="overflow-y: auto;">
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($PlanEmergenciaEncabezado as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"  style=" background-color:#337ab7; color:white;">Plan de Emergencias</td>
							</tr>
							<tr>
								<td><b>Nombre</b></td>
								<td>{{$encabezado->nombrePlanEmergencia}}</td>
							</tr>
							<tr>
								<td><b>Fecha Elaboraci&oacute;n</b></td>
								<td>{{$encabezado->fechaElaboracionPlanEmergencia}}</td>
								
							</tr>
							<tr>
								<td><b>Centro de Costos</b></td>
								<td>{{$encabezado->nombreCentroCosto}}</td>

							</tr>
							<tr>
								<td><b>Realizada Por</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td><b>Firma</b></td>
								<td><?php echo '<img style="width:20%; height:20%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$encabezado->firmaRepresentantePlanEmergencia.'"';?></td>
							</tr>						 
						</thead>
					</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Justificaci&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->justificacionPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Marco Legal</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->marcoLegalPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
		     	  	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Definiciones</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->definicionesPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Generalidades</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->generalidadesPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Objetivos</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->objetivosPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Alcance</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->alcancePlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
					<table class="table table-striped table-bordered" width="100%">
						<tbody>
							<tr>
					        	<td style=" background-color:#848484; color:white;">Información de la empresa</td>
					       	</tr>
							<tr>
								<td><b>Nit</b></td>
								<td>{{$encabezado->nitPlanEmergencia}}</td>
								<td><b>Dirección</b></td>
								<td>{{$encabezado->direccionPlanEmergencia}}</td>
							</tr>
							<tr>
								<td><b>Teléfono</b></td>
								<td>{{$encabezado->telefonoPlanEmergencia}}</td>
								<td><b>Ubicación</b></td>
								<td>{{$encabezado->ubicacionPlanEmergencia}}</td>
							</tr>
							<tr>
								<td><b>Número de Personal operativo</b></td>
								<td>{{$encabezado->personalOperativoPlanEmergencia}}</td>
								<td><b>Número Personal Administrativo</b></td>
								<td>{{$encabezado->personalAdministrativoPlanEmergencia}}</td>
							</tr>
							<tr>
								<td><b>Turno del Personal Operativo</b></td>
								<td>{{$encabezado->turnoOperativoPlanEmergencia}}</td>
								<td><b>Turno Personal Administrativo</b></td>
								<td>{{$encabezado->turnoAdministrativoPlanEmergencia}}</td>
							</tr>
							<tr>
								<td><b>Número de Visitas Diarias en Promedio</b></td>
								<td>{{$encabezado->visitasDiaPlanEmergencia}}</td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					 <!-- Multiregistro Límites geogr&#225;ficos-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Límites geogr&#225;ficos</td>
			     			</tr>							
							<tr>
								<td><b>Sede</b></td>
								<td><b>Norte</b></td>
								<td><b>Sur</b></td>
								<td><b>Oriente</b></td>
								<td><b>Occidente</b></td>
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($PlanEmergenciaLimie as $limite)
						       <tr>
							        <td>{{$limite->sedePlanEmergenciaLimite}}</td>
							        <td>{{$limite->nortePlanEmergenciaLimite}}</td>
							        <td>{{$limite->surPlanEmergenciaLimite}}</td>
							        <td>{{$limite->orientePlanEmergenciaLimite}}</td>
							        <td>{{$limite->occidentePlanEmergenciaLimite}}</td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
			     	 <!-- Multiregistro Inventario de recursos físicos-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Inventario de recursos físicos</td>
			     			</tr>							
							<tr>
								<td><b>Sede</b></td>
								<td><b>Recurso</b></td>
								<td><b>Cantidad</b></td>
								<td><b>Ubicación</b></td>
								<td><b>Observaciones</b></td>
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($PlanEmergenciaIventario as $inventario)
						       <tr>
							        <td>{{$inventario->sedePlanEmergenciaInventario}}</td>
							        <td>{{$inventario->recursoPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->cantidadPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->ubicacionPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->observacionPlanEmergenciaInventario}}</td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
			     	<!-- Multiregistro Comit&#233;s y grupos que apoyan situaciones de emergencia-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Comit&#233;s y grupos que apoyan situaciones de emergencia</td>
			     			</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="3"><b>Actuaci&oacute;n en caso de Emergencia</b></td>
							</tr>						
							<tr>
								<td><b>Comit&#233; / grupo</b></td>
								<td><b>Integrantes</b></td>
								<td><b>Funciones</b></td>
								<td><b>Antes</b></td>
								<td><b>Durante</b></td>
								<td><b>Despues</b></td>								
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($PlanEmergenciaIventario as $inventario)
						       <tr>
							        <td>{{$inventario->sedePlanEmergenciaInventario}}</td>
							        <td>{{$inventario->recursoPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->cantidadPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->ubicacionPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->observacionPlanEmergenciaInventario}}</td>
							        <td>{{$inventario->observacionPlanEmergenciaInventario}}</td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
			     	 <!-- Multiregistro Niveles de actuaci&oacute;n-->
		       		<table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;">Niveles de actuaci&oacute;n</td>
			     			</tr>							
							<tr>
								<td><b>Nivel</b></td>
								<td><b>Cargo</b></td>
								<td><b>Funci&oacute;n general</b></td>
								<td><b>Papel b&#225;sico</b></td>
							</tr>
					      </thead>
				       	<tbody>
					         @foreach($PlanEmergenciaNivel as $Nivel)
						       <tr>
							        <td>{{$Nivel->nivelPlanEmergenciaNivel}}</td>
							        <td>{{$Nivel->cargoPlanEmergenciaNivel}}</td>
							        <td>{{$Nivel->funcionPlanEmergenciaNivel}}</td>
							        <td>{{$Nivel->papelPlanEmergenciaNivel}}</td>
						       </tr>
						       @endforeach					 	
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Procedimiento general de actuaci&oacute;n en caso de emergencias</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->procedimientoEmergenciaPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Sistema de alerta y alarma</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->sistemaAlertaPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Notificaci&oacute;n interna</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->notificacionInternaPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Rutas de evacuaci&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->rutasEvacuacionPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
	     	    	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Sistemas de comunicación</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->sistemaComunicacionPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Coordinación y notificación a organismos de socorro </td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->coordinacionSocorroPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
		     	 	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Determinación de cese del peligro y reestablecimiento de actividades</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->cesePeligroPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Capacitaciones, prácticas y simulacros</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->capacitacionSimulacroPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Análisis de vulnerabilidad</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->analisisVulnerabilidadPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Listado de anexos</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->listaAnexosPlanEmergencia;?></td>
				       		</tr>
				      	</tbody>
			     	</table>




					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Adjuntos</b></td>
							@foreach($PlanEmergenciaArchivo as $Adjunto)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($Adjunto->rutaPlanEmergenciaArchivo, -4) === ".pdf" or (substr($Adjunto->rutaPlanEmergenciaArchivo, -5)) === ".docx" or (substr($Adjunto->rutaPlanEmergenciaArchivo, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$Adjunto->rutaPlanEmergenciaArchivo.'"';
								 	}							
							?>
							@endforeach
								</td>								
							</tr>	
			     	</thead>
			     </table>


				@endforeach		
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



