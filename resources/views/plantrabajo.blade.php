@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Plan de Trabajo Anual</center></h3>@stop

@section('content')
{!!Html::script('js/plantrabajo.js')!!}

<script>
	$(document).ready(function(){
		consultarPlanTrabajo('2017','a', '','plantrabajo');
		// consultarExamenPlanTrabajo('a');
	});
</script>
<?php 
function colorTarea($valorTarea, $valorCumplido)
{

	$icono = '';	
	$tool = 'Tareas Pendientes : '.number_format($valorTarea,0,'.',',')."\n".
			'Tareas Realizadas : '.number_format($valorCumplido,0,'.',',');	
	$etiqueta = '';
	if($valorTarea != $valorCumplido and $valorCumplido != 0)
	{
		$icono = 'Amarillo.png';
		$etiqueta = '<label>'.number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',').'%</label>';
	}elseif($valorTarea == $valorCumplido and $valorTarea != 0)
	{
		$icono = 'Verde.png';
	}
	elseif($valorTarea > 0 and $valorCumplido == 0)
	{
		$icono = 'Rojo.png';		
	}

	if($valorTarea != 0 or $valorCumplido != 0)
	{
		$icono = 	'<a href="#" data-toggle="tooltip" data-placement="right" title="'.$tool.'">
							<img src="images/iconosmenu/'.$icono.'"  width="30">
						</a>'.$etiqueta;	
	}
	//$valorTarea .' '. $valorCumplido. 
	return $icono;
}

function imprimirTabla($titulo, $informacion , $idtabla)
{
	echo '<div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
              </h4>
            </div>
            <div id="'.$idtabla.'" class="panel-collapse">
              <div class="panel-body" style="overflow:auto;">
                    <table  class="table table-striped table-bordered table-hover" style="width:100%;" >
						<thead class="thead-inverse">
							<tr class="table-info">
								<th scope="col" width="30%">&nbsp;</th>
								<th >Enero</th>
								<th >Febrero</th>
								<th >Marzo</th>
								<th >Abril</th>
								<th >Mayo</th>
								<th >Junio</th>
								<th >Julio</th>
								<th >Agosto</th>
								<th >Septiembre</th>
								<th >Octubre</th>
								<th >Noviembre</th>
								<th >Diciembre</th>
								<th >Presupuesto</th>
								<th >Costo Real</th>
								<th >Cumplimiento</th>
								<th >Responsable</th>
							</tr>
						</thead>
						<tbody>';

							foreach($informacion as $dato)
							{
								echo '<tr align="center">
									<th scope="row">'.$dato->descripcionTarea.'</th>
									<td>'.colorTarea($dato->EneroT, $dato->EneroC).'</td>
									<td>'.colorTarea($dato->FebreroT, $dato->FebreroC).'</td>
									<td>'.colorTarea($dato->MarzoT, $dato->MarzoC).'</td>
									<td>'.colorTarea($dato->AbrilT, $dato->AbrilC).'</td>
									<td>'.colorTarea($dato->MayoT, $dato->MayoC).'</td>
									<td>'.colorTarea($dato->JunioT, $dato->JunioC).'</td>
									<td>'.colorTarea($dato->JulioT, $dato->JulioC).'</td>
									<td>'.colorTarea($dato->AgostoT, $dato->AgostoC).'</td>
									<td>'.colorTarea($dato->SeptiembreT, $dato->SeptiembreC).'</td>
									<td>'.colorTarea($dato->OctubreT, $dato->OctubreC).'</td>
									<td>'.colorTarea($dato->NoviembreT, $dato->NoviembreC).'</td>
									<td>'.colorTarea($dato->DiciembreT, $dato->DiciembreC).'</td>
									<td>'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'</td>
         							<td>'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'</td>
									<td>'; 
									$mesesC = ((int)$dato->EneroC + 
											(int)$dato->FebreroC + 
											(int)$dato->MarzoC + 
											(int)$dato->AbrilC + 
											(int)$dato->MayoC + 
											(int)$dato->JunioC + 
											(int)$dato->JulioC + 
											(int)$dato->AgostoC + 
											(int)$dato->SeptiembreC + 
											(int)$dato->OctubreC + 
											(int)$dato->NoviembreC + 
											(int)$dato->DiciembreC);

									$mesesT = (((int)$dato->EneroT + 
										   	(int)$dato->FebreroT + 
										   	(int)$dato->MarzoT + 
										   	(int)$dato->AbrilT + 
										   	(int)$dato->MayoT + 
										   	(int)$dato->JunioT + 
										   	(int)$dato->JulioT + 
										   	(int)$dato->AgostoT + 
										   	(int)$dato->SeptiembreT + 
										   	(int)$dato->OctubreT + 
										   	(int)$dato->NoviembreT + 
										   	(int)$dato->DiciembreT));

									echo number_format(($mesesC / ($mesesT == 0 ? 1: $mesesT) *100),1,'.',',');
									echo '</td>
									<td>&nbsp;</td>
								</tr>';
							}
						
						echo '</tbody>
					</table>
		          </div> 
		        </div>
		      </div>';
}


function imprimirTablaExamenesMedicos($titulo, $informacion , $idtabla)
{
	echo '<div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#'.$idtabla.'">'.$titulo.'</a>
              </h4>
            </div>
            <div id="'.$idtabla.'" class="panel-collapse">
              <div class="panel-body" style="overflow:auto;">';

              	  

    $dato = array();
    for ($i=0; $i < count($informacion); $i++) 
    { 
   		$dato[] = get_object_vars($informacion[$i]);
    }

    // hacemos rompimiento por el campo de Tipo de examen medico
    $reg = 0;
    while ($reg < count($dato)) 
    {
    	$examenAnt = $dato[$reg]['nombreTipoExamenMedico'];
    
    	echo '<div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#'.str_replace(" ", "_", $examenAnt).'" href="#'.str_replace(" ", "_", $examenAnt).'">'.$examenAnt.'</a>	
              </h4>
            </div>
            <div id="'.str_replace(" ", "_", $examenAnt).'" class="panel-collapse">
              <div class="panel-body" style="overflow:auto;">';

      	echo  '<table  class="table table-striped table-bordered table-hover" style="width:100%;" >
				<thead class="thead-inverse">
					<tr class="table-info">
						<th scope="col" width="30%">&nbsp;</th>
						<th >Enero</th>
						<th >Febrero</th>
						<th >Marzo</th>
						<th >Abril</th>
						<th >Mayo</th>
						<th >Junio</th>
						<th >Julio</th>
						<th >Agosto</th>
						<th >Septiembre</th>
						<th >Octubre</th>
						<th >Noviembre</th>
						<th >Diciembre</th>
						<th >Presupuesto</th>
						<th >Costo Real</th>
						<th >Cumplimiento</th>
						<th >Responsable</th>
					</tr>
				</thead>
				<tbody>';

    	while ($reg < count($dato) AND $examenAnt == $dato[$reg]['nombreTipoExamenMedico']) 
    	{		
			echo '<tr align="center">
				<th scope="row">'.$dato[$reg]["descripcionTarea"].'</th>
				<td>'.colorTarea($dato[$reg]["EneroT"], $dato[$reg]["EneroC"]).'</td>
				<td>'.colorTarea($dato[$reg]["FebreroT"], $dato[$reg]["FebreroC"]).'</td>
				<td>'.colorTarea($dato[$reg]["MarzoT"], $dato[$reg]["MarzoC"]).'</td>
				<td>'.colorTarea($dato[$reg]["AbrilT"], $dato[$reg]["AbrilC"]).'</td>
				<td>'.colorTarea($dato[$reg]["MayoT"], $dato[$reg]["MayoC"]).'</td>
				<td>'.colorTarea($dato[$reg]["JunioT"], $dato[$reg]["JunioC"]).'</td>
				<td>'.colorTarea($dato[$reg]["JulioT"], $dato[$reg]["JulioC"]).'</td>
				<td>'.colorTarea($dato[$reg]["AgostoT"], $dato[$reg]["AgostoC"]).'</td>
				<td>'.colorTarea($dato[$reg]["SeptiembreT"], $dato[$reg]["SeptiembreC"]).'</td>
				<td>'.colorTarea($dato[$reg]["OctubreT"], $dato[$reg]["OctubreC"]).'</td>
				<td>'.colorTarea($dato[$reg]["NoviembreT"], $dato[$reg]["NoviembreC"]).'</td>
				<td>'.colorTarea($dato[$reg]["DiciembreT"], $dato[$reg]["DiciembreC"]).'</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>';
				$mesesC = ((int)$dato[$reg]["EneroC"] + 
							(int)$dato[$reg]["FebreroC"] + 
							(int)$dato[$reg]["MarzoC"] + 
							(int)$dato[$reg]["AbrilC"] + 
							(int)$dato[$reg]["MayoC"] + 
							(int)$dato[$reg]["JunioC"] + 
							(int)$dato[$reg]["JulioC"] + 
							(int)$dato[$reg]["AgostoC"] + 
							(int)$dato[$reg]["SeptiembreC"] + 
							(int)$dato[$reg]["OctubreC"] + 
							(int)$dato[$reg]["NoviembreC"] + 
							(int)$dato[$reg]["DiciembreC"]);

				$mesesT = (((int)$dato[$reg]["EneroT"] + 
						   	(int)$dato[$reg]["FebreroT"] + 
						   	(int)$dato[$reg]["MarzoT"] + 
						   	(int)$dato[$reg]["AbrilT"] + 
						   	(int)$dato[$reg]["MayoT"] + 
						   	(int)$dato[$reg]["JunioT"] + 
						   	(int)$dato[$reg]["JulioT"] + 
						   	(int)$dato[$reg]["AgostoT"] + 
						   	(int)$dato[$reg]["SeptiembreT"] + 
						   	(int)$dato[$reg]["OctubreT"] + 
						   	(int)$dato[$reg]["NoviembreT"] + 
						   	(int)$dato[$reg]["DiciembreT"]));

				echo number_format(($mesesC / ($mesesT == 0 ? 1: $mesesT) *100),1,'.',',');
				echo '</td>
				<td>&nbsp;</td>
			</tr>';
			$reg++;
		}

		echo '</tbody>
			</table>
          </div> 
        </div>
      </div>';
	}
	echo '</div> 
	  </div>
	</div>';

}
?>
<input type="hidden" id="token" value="{{csrf_token()}}"/>
<style>
    .info {
            background-color: blue,
            color: white;
        }

</style>

	<select id="añoPlanTrabajo" class="form-control" onchange="consultarPlanTrabajo(this.value,'a','','plantrabajo')">
		<option>2017</option>
		<option>2016</option>
	</select>

	<br>
	<div id="plantrabajo"> </div> 
	
@stop