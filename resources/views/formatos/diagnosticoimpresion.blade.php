@extends('layouts.formato')

@section('contenido')
	{!!Form::model($diagnostico)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					<table class="table" style="width:800px">
						<thead>
							<tr>
								<th>
									Fecha Elaboraci&oacute;n:
								</th>
								<th>
									{{$diagnostico->fechaElaboracionDiagnostico}}
								</th>
								<th>
									Descripción del Diagnostico :
								</th>
								<th>
									{{$diagnostico->nombreDiagnostico}}
								</th>
							</tr>
						</thead>
					</table>
		            <table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<th>ASPECTO A EVALUAR</th>
								<th>CALIFICACION</th>
								<th>% CUMPLIMIENTO</th>
								<th>OBSERVACION</th>
							</tr>
						<thead>
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
									echo '<tr>
											<td>'.$diagnosticoDetalle[$j]["detalleDiagnosticoPregunta"].'</td>
											<td>'.$diagnosticoDetalle[$j]["puntuacionDiagnosticoDetalle"].'</td>
											<td>'.$diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"].'</td>
											<td>'.$diagnosticoDetalle[$j]["mejoraDiagnosticoDetalle"].'</td>
										</tr>';

									$sumadet += $diagnosticoDetalle[$j]["resultadoDiagnosticoDetalle"];
									$conteodet++;
									$j++;
								}
								echo '<tr>
										<td colspan="2" style="font-weight: bold;">Porcentaje de Cumplimiento '.$grupo.'</td>
										<td style="font-weight: bold;">'.number_format(($sumadet/$conteodet),1,'.',',').'%</td>
										<td style="font-weight: bold;">&nbsp;</td>
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
									<td style="font-weight: bold;">Ejecucion Total '.$grupo.'</td>
									<td style="font-weight: bold;">'.number_format(($suma/$conteo),1,'.',',').'%</td>
								</tr>';

						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop