@extends('layouts.formato')


@section('contenido')

{!!Form::model($diagnostico)!!}


		<div class="col-lg-12">
            <div class="panel panel-default" >
				<div class="panel-body" >
					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td colspan="4" style="font-weight: bold; text-align: center;">
									DIAGNOSTICO EN SEGURIDAD Y SALUD EN EL TRABAJO SST
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Fecha Elaboraci&oacute;n: {{$diagnostico->fechaElaboracionDiagnostico}}
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Descripción del Diagnostico: {{$diagnostico->nombreDiagnostico}}
								</td>
							</tr>
							<tr>
								<td colspan="4" >
									Evaluación inicial que se realiza con el fin de identificar las prioridades en Seguridad y Salud en el Trabajo propias de la empresa como punto de partida para el establecimiento del Sistema de Gestión de Seguridad y Salud en el Trabajo SG-SST o para la actualización existen. La evaluación inicial debe ser revisada (mínimo una vea al año) y actualizada cuando sea necesario, con el objetico de mantener vigente las prioridades en seguridad y salud en el trabajo acorde con los cambios en las condiciones y procesos de trabajo. 
								</td>
							</tr>	
        				</table>

				        <table class="table table-striped table-bordered" width="100%">
				          <tr>
				                <th colspan="2">La calificación posible es entre 1 y 5, segun el grado de cumplimiento del aspecto evaluado</th>
				                <th colspan="2">% cumplimiento</th>
				              </tr>
				              <tr>
				                <td >0: Sin Acción / No se ha Iniciado</td>
				                <td >1: Iniciaci&oacute;n</td>
				                <td style="background-color:red; width: 30px;">&nbsp;</td>
				                <td >entre 0% y 35%</td>
				              </tr>
				              <tr>
				                <td >2: Implementaci&oacute;n Parcial</td>
				                <td >3: Implementaci&oacute;n Completa</td>
				                <td style="background-color:yellow;">&nbsp;</td>
				                <td >entre 36% y 70%</td>
				              </tr>
				              <tr>
				                <td >4: Implementada y Sostenida</td>
				                <td >5: Mejorada Continuamente</td>
				                <td style="background-color:green;">&nbsp;</td>
				                <td >entre 71% y 100%</td>
				              </tr>
				        </table>
				        
				        <table class="table table-striped table-bordered" width="100%">
							<tr>
								<td colspan="4">
									Equipos Cr&iacute;ticos: {{$diagnostico->equiposCriticosDiagnostico}}
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Herramientas Cr&iacute;ticas: {{$diagnostico->herramientasCriticasDiagnostico}}
								</td>
							</tr>
							<tr>
								<td colspan="4">
									Observaciones: {{$diagnostico->observacionesDiagnostico}}
								</td>
							</tr>
							<tr>
								<th>Aspecto a Evaluar</th>
								<th>Calificaci&oacute;n</th>
								<th>% Cumplimiento</th>
								<th>Observaci&oacute;n</th>
							</tr>
						</thead>
						<tbody>
				        <?php 
				        	$grupo = '';				        	
				        	
				        	// por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
				        	for ($i = 0, $c = count($diagnosticoDetalle); $i < $c; ++$i) 
				        	{
							    $diagnosticoDetalle[$i] = (array) $diagnosticoDetalle[$i];
							}

							for ($i = 0, $c = count($diagnosticoResumen); $i < $c; ++$i) 
				        	{
							    $diagnosticoResumen[$i] = (array) $diagnosticoResumen[$i];
							}

							$total = count($diagnosticoDetalle);

							
      						$j=0; 
					        while($j < $total)
					        {
					        	$grupo = $diagnosticoDetalle[$j]["nombreDiagnosticoGrupo"];
								echo '<tr>
										<td colspan="4" style="font-weight: bold;">'.$grupo.'</td>
									</tr>';
								$sumadet = 0;
								$conteodet = 0;

					        	while($j < $total and $grupo == $diagnosticoDetalle[$j]["nombreDiagnosticoGrupo"])
								{
									$color = 'white';
									if($diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"] >= 0 and $diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"] <= 35)
										$color = 'red';
									elseif($diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"] >= 36 and $diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"] <= 70)
										$color = 'yellow';
									elseif($diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"] >= 71 and $diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"] <= 100)
										$color = 'green';
									echo '<tr>
											<td>'.$diagnosticoDetalle[$j]["detalleDiagnosticoPregunta"].'</td>
											<td align="center">'.$diagnosticoDetalle[$j]["puntuacionDiagnosticoDetalle"].'</td>
											<td align="center" style="background-color:'.$color.';">'.$diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"].'%</td>
											<td>'.$diagnosticoDetalle[$j]["mejoraDiagnosticoDetalle"].'</td>
										</tr>';

									$sumadet += $diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"];
									$conteodet++;
									$j++;
								}
								echo '<tr>
										<td colspan="2" style="font-weight: bold;">Porcentaje de Cumplimiento '.$grupo.'</td>
										<td align="center" style="font-weight: bold;">'.number_format(($sumadet/($conteodet == 0 ? 1 : $conteodet)),1,'.',',').'%</td>
										<td style="font-weight: bold;">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="4" style="font-weight: bold;">&nbsp;</td>
									</tr>';
							}
							?>
						</tbody>
					</table>

					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<th>ASPECTO A EVALUAR</th>
								<th>% CUMPLIMIENTO</th>
							</tr>
						<thead>
						<tbody>
						<?php
							$total = count($diagnosticoResumen);
							
							$j=0; 
							$suma = 0;
							$conteo = 0;
							$arrayGrafico = '';
					        while($j < $total)
					        {

								echo '<tr>
										<td>'.$diagnosticoResumen[$j]["nombreDiagnosticoGrupo"].'</td>
										<td>'.number_format($diagnosticoResumen[$j]["resultadoDiagnosticoDetalle"],1,'.',',').'</td>
									</tr>';

								$arrayGrafico .= "{ aspecto: '".$diagnosticoResumen[$j]["nombreDiagnosticoGrupo"]."', value: ".$diagnosticoResumen[$j]["resultadoDiagnosticoDetalle"]." },";

								$suma += $diagnosticoResumen[$j]["resultadoDiagnosticoDetalle"];
								$conteo++;
								$j++;
							}
							$arrayGrafico = substr($arrayGrafico,0,strlen($arrayGrafico)-1);

							echo '<tr>
									<td style="font-weight: bold;">Ejecucion Total </td>
									<td style="font-weight: bold;">'.number_format(($suma/($conteo == 0 ? 1 : $conteo)),1,'.',',').'%</td>
								</tr>';

						?>
						</tbody>
					</table>

					<div id="resultado" style="height: 250px; width: 800px;"></div>

				</div>
			</div>
		</div>



<script type="text/javascript">
	
	new Morris.Bar({
	// ID of the element in which to draw the chart.
	element: 'resultado',
	// Chart data records -- each entry in this array corresponds to a point on
	// the chart.
	data: [
	<?php echo $arrayGrafico;?>
	],
	// The name of the data record attribute that contains x-values.
	xkey: 'aspecto',
	// A list of names of data record attributes that contain y-values.
	ykeys: ['value'],
	// Labels for the ykeys -- will be displayed when you hover over the
	// chart.
	labels: ['%Cump'],
	resize: true,
	hideHover: 'auto',
	ymax: 100
	});


</script>

	{!!Form::close()!!}

	
@stop