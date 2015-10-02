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
							<tr>
								<th colspan="1">La calificación posible es entre 1 y 5, segun el grado de cumplimiento del aspecto evaluado</th>
								<th colspan="3">% cumplimiento</th>
							</tr>
							<tr>
								<td colspan="1">1 = No se cumple con el aspecto evaluado</td>
								<td colspan="3">entre 0% y 35%</td>
							</tr>
							<tr>
								<td colspan="1">3 = Se cumple parcialmente con el aspecto evaluado</td>
								<td colspan="3">entre 36% y 70%</td>
							</tr>
							<tr>
								<td colspan="1">5 = Se cumple totalmente con el aspecto evaluado</td>
								<td colspan="3">entre 71% y 100%</td>
							</tr>
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
										<td align="center" style="font-weight: bold;">'.number_format(($sumadet/$conteodet),1,'.',',').'%</td>
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
					        while($j < $total)
					        {

								echo '<tr>
										<td>'.$diagnosticoResumen[$j]["nombreDiagnosticoGrupo"].'</td>
										<td>'.number_format($diagnosticoResumen[$j]["resultadoDiagnosticoDetalle"],1,'.',',').'</td>
									</tr>';

								$suma += $diagnosticoResumen[$j]["resultadoDiagnosticoDetalle"];
								$conteo++;
								$j++;
							}
							echo '<tr>
									<td style="font-weight: bold;">Ejecucion Total </td>
									<td style="font-weight: bold;">'.number_format(($suma/$conteo),1,'.',',').'%</td>
								</tr>';

						?>
						</tbody>
					</table>

					<div id="resultado" style="height: 250px; width: 800px;"></div>

				</div>
			</div>
		</div>

<div id="header">
		<h2>Basic Usage</h2>
	</div>

	<div id="content">

		<div class="demo-container">
			<div id="placeholder" class="demo-placeholder"></div>
		</div>

		<p>You don't have to do much to get an attractive plot.  Create a placeholder, make sure it has dimensions (so Flot knows at what size to draw the plot), then call the plot function with your data.</p>

		<p>The axes are automatically scaled.</p>

	</div>

	<div id="footer">
		Copyright &copy; 2007 - 2014 IOLA and Ole Laursen
	</div>

		
	<script type="text/javascript">

	$(function() {

		var d1 = [];
		for (var i = 0; i < 14; i += 0.5) {
			d1.push([i, Math.sin(i)]);
		}

		var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];

		// A null signifies separate line segments

		var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];

		$.plot("#placeholder", [ d1, d2, d3 ]);

		// Add the Flot version string to the footer

		$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
	});

	</script>

<script type="text/javascript">
	
	new Morris.Bar({
	// ID of the element in which to draw the chart.
	element: 'resultado',
	// Chart data records -- each entry in this array corresponds to a point on
	// the chart.
	data: [
	  { aspecto: '1. PLANIFICACION', value: 57.8 },
	  { aspecto: '2. IMPLEMENTACION', value: 78 },
	  { aspecto: '3. VERIFICACION ', value: 76 },
	  { aspecto: '4. ACTUACION', value: 80 }
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