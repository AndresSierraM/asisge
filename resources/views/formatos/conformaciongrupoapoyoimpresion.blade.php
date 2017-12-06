@extends('layouts.formato')

@section('contenido')
	{!!Form::model($conformaciongrupoapoyoS)!!}
		<!-- Se quema el overflow-y auto apra que salga la barra vertical cuando tiene mucha informacion -->
	<html lang="es" style="overflow-y: auto;">
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($conformaciongrupoapoyoS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center" style=" background-color:#337ab7; color:white;">Conformaci&#243;n de  Grupos Apoyo</td>
							</tr>
							<tr>
								<td>Grupo</td>
								<td>{{$encabezado->nombreGrupoApoyo}}</td>
							</tr>
							<tr>
								<td>Descripci&#243;n</td>
								<td>{{$encabezado->nombreConformacionGrupoApoyo}}</td>
								
							</tr>
							<tr>
								<td>Fecha de Elaboraci&#243;n</td>
								<td>{{$encabezado->fechaConformacionGrupoApoyo}}</td>
							</tr>
						</thead>
					</table>
					  <!-- Pestaña Convocatoria -->
				        <table  class="table table-striped table-bordered" width="70%">
				     <thead>
				     		<tr>
				     			<td><b>Detalles</b></td>
			     			</tr>
			     			<tr>
				     			<td colspan="2" style=" background-color:#848484; color:white;"><b>Convocatoria</b></td>
			     			</tr>
					       	<tr>
								<td><b>Fecha</b></td>
								<td>{{$encabezado->fechaConvocatoriaConformacionGrupoApoyo}}</td>
							</tr>
							<tr>
								<td><b>Representante</b></td>
								<td>{{$encabezado->representante}}</td>
							</tr>
							<tr>
								<td><b>Fecha Votaci&#243;n</b></td>
								<td>{{$encabezado->fechaVotacionConformacionGrupoApoyo}}</td>
							</tr>
							<tr>
								<td><b>Gerente General</b></td>
								<td>{{$encabezado->gerente}}</td>
							</tr>
					      </thead>
				     </table>
				     <!-- Convocatoria de votacion -->
				     <table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Convocatoria votaci&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->convocatoriaVotacionConformacionGrupoApoyo;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	<!-- Acta de escrutinio y votaci&oacute;n</ -->
	     	   		<table class="table table-striped table-bordered" width="100%">
				      	<thead>
					       	<tr>
					        	<td style=" background-color:#848484; color:white;">Acta de escrutinio y votaci&oacute;n</td>
					       	</tr>
				      	</thead>
				      	<tbody>
				       		<tr>
				        		<td><?php echo $encabezado->actaEscrutinioConformacionGrupoApoyo;?></td>
				       		</tr>
				      	</tbody>
			     	</table>
			     	   <!-- Multiregistro Candidatos Inscritos  -->
			       	<table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td style=" background-color:#848484; color:white;"><b>Candidatos Inscritos</b></td>
					     			</tr>
									<tr>
										<td><b>Nombre</b></td>
										<td><b>Cargo</b></td>
										<td><b>Centro de costos</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
							 @foreach($conformacongrupoapooinscrito as $inscrito)
						       <tr>
						        <td>{{$inscrito->nombreCompletoTercero}}</td>
						        <td>{{$inscrito->nombreCargo}}</td>
						        <td>{{$inscrito->nombreCentroCosto}}</td>
						       </tr>
					       	@endforeach						 	
					      </tbody>
				     </table>
				     <!-- Pestaña Actas de votacion-->
				        <table  class="table table-striped table-bordered" width="70%">
					     <thead>				     		
				     			<tr>
					     			<td colspan="2" style=" background-color:#848484; color:white;"><b>Actas de Votaci&#243;n</b></td>
				     			</tr>
						       	<tr>
									<td><b>Fecha</b></td>
									<td>{{$encabezado->fechaActaConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Hora</b></td>
									<td>{{$encabezado->horaActaConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Inicio del Periodo</b></td>
									<td>{{$encabezado->fechaInicioConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Fin del Periodo</b></td>
									<td>{{$encabezado->fechaFinConformacionGrupoApoyo}}</td>
								</tr>
								@endforeach
						      </thead>
				     	</table>
				     			   <!-- Multiregistro Votacion -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
									<tr>
										<td><b>Jurado</b></td>
										<td><b>Firma</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($conformaciongrupoapoyojuradoS as $jurado)
						       <tr>
						        <td>{{$jurado->nombreCompletoTercero}}</td>
						        <td><?php echo '<img style="width:40%; height:40%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$jurado->firmaActaConformacionGrupoApoyoTercero.'"';?></td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				        <!-- Multiregistro Resultado de la votacion  -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td><b>Resultado de la Votaci&#243;n</b></td>
					     			</tr>
									<tr>
										<td><b>Nombre</b></td>
										<td><b>Votos</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($conformaciongrupoapoyoresultadoS as $resultado)
						       <tr>
						        <td>{{$resultado->nombreCompletoTercero}}</td>
						        <td>{{$resultado->votosConformacionGrupoApoyoResultado}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				       <!-- Pestaña Actas de votacion-->
				        <table  class="table table-striped table-bordered" width="70%">
				        @foreach($conformaciongrupoapoyoS as $encabezado)
					     <thead>				     		
				     			<tr>
					     			<td colspan="2" style=" background-color:#848484; color:white;"><b>Constituci&#243;n</b></td>
				     			</tr>
						       	<tr>
									<td><b>Fecha</b></td>
									<td>{{$encabezado->fechaConstitucionConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Presidente</b></td>
									<td>{{$encabezado->presidente}}</td>
								</tr>
								<tr>
									<td><b>Secretario</b></td>
									<td>{{$encabezado->secretario}}</td>
								</tr>
								@endforeach
						      </thead>
								       <!-- Multiregistro Integrantes del Comite  -->
					       	<table  class="table table-striped table-bordered" width="100%">
							     	<thead>
							     			<tr>
							     				<td><b>Integrantes del Comite</b></td>
							     			</tr>
											<tr>
												<td><b>Nombrado Por</b></td>
												<td><b>Principal</b></td>
												<td><b>Suplentes</b></td>
											</tr>
							      	</thead>
							       <tbody>
							         @foreach($conformaciongrupoapoyocomiteS as $integrante)
								       <tr>
								        <td>{{$integrante->nombradoPor}}</td>
								        <td>{{$integrante->principal}}</td>
								        <td>{{$integrante->suplente}}</td>
								       </tr>
								       @endforeach					 	
							      </tbody>
						     </table>

				     	</table>
				     			<!-- Acta de cierre</ -->
	     	   			<table class="table table-striped table-bordered" width="100%">
			      			<thead>
						       	<tr>
						        	<td style=" background-color:#848484; color:white;">Acta de cierre</td>
						       	</tr>
					      	</thead>
					      	<tbody>
					       		<tr>
					        		<td><?php echo $encabezado->actaCierreConformacionGrupoApoyo;?></td>
					       		</tr>
					      	</tbody>
				     	</table>
				     			<!-- Acta de conformaci&oacute;n</ -->
	     	   			<table class="table table-striped table-bordered" width="100%">
			      			<thead>
						       	<tr>
						        	<td style=" background-color:#848484; color:white;">Acta de conformaci&oacute;n</td>
						       	</tr>
					      	</thead>
					      	<tbody>
					       		<tr>
					        		<td><?php echo $encabezado->actaConformacionConformacionGrupoApoyo;?></td>
					       		</tr>
					      	</tbody>
				     	</table>

					<table class="table table-striped table-bordered" width="100%">
				      	<thead>
							<tr>
								<td style=" background-color:#848484; color:white;"><b>Documentos</b></td>
							@foreach($conformaciongrupoapoyoarchivo as $Adjunto)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($Adjunto->rutaConformacionGrupoApoyoArchivo, -4) === ".pdf" or (substr($Adjunto->rutaConformacionGrupoApoyoArchivo, -5)) === ".docx" or (substr($Adjunto->rutaConformacionGrupoApoyoArchivo, -5) === ".pptx"))
									{
										echo' <style="width:50%; height:50%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$Adjunto->rutaConformacionGrupoApoyoArchivo.'"';
								 	}							
							?>
							@endforeach
								</td>								
							</tr>	
			     	</thead>
			     </table>
				     				     		<!-- Funciones el grupo de apoyo -->
	     	   			<table class="table table-striped table-bordered" width="100%">
			      			<thead>
						       	<tr>
						        	<td style=" background-color:#848484; color:white;">Funciones del grupo de apoyo</td>
						       	</tr>
					      	</thead>
					      	<tbody>
					       		<tr>
					        		<td><?php echo $encabezado->funcionesGrupoConformacionGrupoApoyo;?></td>
					       		</tr>
					      	</tbody>
				     	</table>
			     	<!-- Funciones del presidente -->
	     	   			<table class="table table-striped table-bordered" width="100%">
			      			<thead>
						       	<tr>
						        	<td style=" background-color:#848484; color:white;">Funciones del presidente</td>
						       	</tr>
					      	</thead>
					      	<tbody>
					       		<tr>
					        		<td><?php echo $encabezado->funcionesPresidenteConformacionGrupoApoyo;?></td>
					       		</tr>
					      	</tbody>
				     	</table>
				     	<!-- Funciones del secretario -->
	     	   			<table class="table table-striped table-bordered" width="100%">
			      			<thead>
						       	<tr>
						        	<td style=" background-color:#848484; color:white;">Funciones del secretario</td>
						       	</tr>
					      	</thead>
					      	<tbody>
					       		<tr>
					        		<td><?php echo $encabezado->funcionesSecretarioConformacionGrupoApoyo;?></td>
					       		</tr>
					      	</tbody>
				     	</table>

				     	 
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



