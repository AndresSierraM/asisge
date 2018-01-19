@extends('layouts.formato')

@section('contenido')
	{!!Form::model($Cargo)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($Cargo as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"  style=" background-color:#337ab7; color:white;">Cargos</td>
								<?php echo \Session::get("nombreCompania") ?>
							</tr>
							<tr>
								<td><b>Codigo</b></td>
								<td>{{$dato->codigoCargo}}</td>
							</tr>
							<tr>
								<td><b>Nombre</b></td>
								<td>{{$dato->nombreCargop}}</td>
								
							</tr>
							<tr>
								<td><b>Salario Base</b></td>
								<td>{{$dato->salarioBaseCargo}}</td>

							</tr>
							<tr>
								<td><b>Nivel Riesgo</b></td>
								<td>{{$dato->nivelRiesgoCargo}}</td>
								
							</tr>
						 @endforeach
						 @foreach($Cargodepende as $depende)
							<tr>
								<td><b>Depende De</td>
								<td>{{$depende->nombreCargo}}</td>
							</tr>
						 @endforeach
							<tr>
							<td></td>
							<td></td>
							</tr>

						</thead>
					</table>
				   
				   <tr>
				  
				 <!-- Pestaña Objetivos -->
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Objetivos</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($Cargo as $dato)
						       <tr>
						        <td><?php echo $dato->objetivoCargo;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				     <!-- Pestaña Educacon -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Educaci&#243;n</b></td>

			     			</tr>
			     			<tr>
								<td><b>% Peso</b></td>
								<td>{{$dato->porcentajeEducacionCargo}}</td>
							</tr>
							<!-- Multiregistro Educacion -->
							<tr>
								<td><b>Descripci&#243;n</b></td>
								<td><b>% Peso</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($cargoeducacion as $educacion)
						       <tr>
						        <td>{{$educacion->nombreEducacion}}</td>
						        <td>{{$educacion->porcentajeCargoEducacion}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				     <!-- Pestaña Experiencia -->
				        <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     @foreach($Cargo as $dato)
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Experiencia</b></td>

			     			</tr>
					       	<tr>
								<td><b>Años de Experiencia</b></td>

								<td>{{$dato->aniosExperienciaCargo}}</td>
							</tr>
							<tr>
								<td><b>% Peso</b></td>
								<td>{{$dato->porcentajeExperienciaCargo}}</td>
							</tr>
							<tr>
								<td><b>Observaci&#243;n</b></td>
								<td><?php echo $dato->experienciaCargo;?></td>

							</tr>
						@endforeach
					      </thead>
				     </table>
				
				      <!-- Pestaña Formacion -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Formaci&#243;n</b></td>

			     			</tr>
			     			<tr>
								<td><b>% Peso</b></td>
								<td>{{$dato->porcentajeFormacionCargo}}</td>
							</tr>
							<!-- Multiregistro Formacion -->
							<tr>
								<td><b>Descripci&#243;n</b></td>
								<td><b>% Peso</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($cargoformacion as $formacion)
						       <tr>
						        <td>{{$formacion->nombreFormacion}}</td>
						        <td>{{$formacion->porcentajeCargoFormacion}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>

				      <!-- Pestaña HABILIDADES PROPIAS DEL CARGO  -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Habilidades propias del cargo</b></td>

			     			</tr>
			     			<tr>
								<td><b>% Peso</b></td>
								<td>{{$dato->porcentajeHabilidadCargo}}</td>
							</tr>
							<!-- Multiregistro habilidad propia del cargo -->
							<tr>
								<td><b>Descripci&#243;n</b></td>
								<td><b>% Peso</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($cargohabilidad as $propiacargo)
						       <tr>
						        <td>{{$propiacargo->nombreHabilidad}}</td>
						        <td>{{$propiacargo->porcentajeCargoHabilidad}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>


				      <!-- Pestaña Responsabilidades  -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Responsabilidades</b></td>

			     			</tr>
			     			<tr>
								<td><b>% Peso</b></td>
								<td>{{$dato->porcentajeResponsabilidadCargo}}</td>
							</tr>
							<!-- Multiregistro Responsabilidad  -->
							<tr>
								<td><b>Descripci&#243;n</b></td>
								<td><b>Rendici&#243;n de cuentas</b></td>
								<td><b>% Peso</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($cargoresponsabilidad as $responsabilidad)
						       <tr>
						        <td>{{$responsabilidad->descripcionCargoResponsabilidad}}</td>
						        <td>{{$responsabilidad->rendicionCuentasCargoResponsabilidad}}</td>
						        <td>{{$responsabilidad->porcentajeCargoResponsabilidad}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				       <!-- Pestaña Habilidades Actitudinales  -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Habilidades Actitudinales</b></td>

			     			</tr>
							
							<tr>
								<td><b>Habilidad Actitudinal</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($cargocompetencia as $actitudinal)
						       <tr>
						        <td>{{$actitudinal->nombreCompetencia}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>

				      <!-- Pestaña Tareas de Alto Riesgo-->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Tareas de Alto Riesgo</b></td>

			     			</tr>
							
							<tr>
								<td><b>Descripc&#243;n</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($TareaRiesgo as $altoriesgo)
						       <tr>
						        <td>{{$altoriesgo->nombreListaGeneral}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				        <!-- Pestaña Examenes medicos requeridos-->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Examenes m&#233;dicos Requeridos</b></td>
			     			</tr>
							
							<tr>
								<td><b>Examen</b></td>
								<td><b>Ingreso</b></td>
								<td><b>Retiro</b></td>
								<td><b>Peri&#243;dico</b></td>
								<td><b>Periodicidad</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($ExamenMedico as $examen)
						       <tr>
						        <td>{{$examen->nombreTipoExamenMedico}}</td>
						        <td>{{$examen->ingresoCargoExamenMedicoL}}</td>
						        <td>{{$examen->retiroCargoExamenMedicoL}}</td>
						        <td>{{$examen->periodicoCargoExamenMedicoL}}</td>
						        <td>{{$examen->nombreFrecuenciaMedicion}}</td>

						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>

				      <!-- Pestaña VACUNAS REQUERIDAS -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Vacunas Requeridas</b></td>

			     			</tr>
							
							<tr>
								<td><b>Descripci&#243;n</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($CargoVacuna as $vacuna)
						       <tr>
						        <td>{{$vacuna->nombreListaGeneral}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				       <!-- Pestaña Posicion predominante (mas del 60% de la jornada) -->
				    <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Posici&#243;n predominante (m&#225;s del 60% de la jornada) </b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($Cargo as $dato)
						       <tr>
						        <td><?php echo $dato->posicionPredominanteCargo;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				      <!-- Pestaña Restricciones para el Cargo -->
				    <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Restricciones para el Cargo</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($Cargo as $dato)
						       <tr>
						        <td><?php echo $dato->restriccionesCargo;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				      <!-- Pestaña Elementos de Protecci&#243;n Personal -->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Elementos de Protecci&#243;n Personal</b></td>

			     			</tr>
							
							<tr>
								<td><b>Descripci&#243;n</b></td>
							</tr>
							<tr>
								
							</tr>
					      </thead>
					       <tbody>
					         @foreach($elementoproteccion as $elementoproteccion)
						       <tr>
						        <td>{{$elementoproteccion->nombreElementoProteccion}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				       <!-- Pestaña Autoridades -->
				    <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td style=" background-color:#848484; color:white;"><b>Autoridades</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($Cargo as $dato)
						       <tr>
						        <td><?php echo $dato->autoridadesCargo;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>

				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



