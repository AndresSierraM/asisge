@extends('layouts.formato')

@section('contenido')

{!!Form::model($accidente)!!}

<?php 
function colorTarea($valorTarea, $valorCumplido)
{

	$icono = '';		
	if($valorTarea != $valorCumplido and $valorCumplido != 0)
	{
		$tool = 'Tareas Pendientes : '.$valorTarea.'  /  Tareas Realizadas : '.
$valorCumplido;
		$icono = ' <img src="images\iconosmenu\Amarillo.png" title="'.$tool.'" width="30"><label>'.number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',').'%</label>';		
	}elseif($valorTarea == $valorCumplido and $valorTarea != 0)
	{
		$icono = '<img src="images\iconosmenu\Verde.png" width="30">';
	}
	elseif($valorTarea > 0 and $valorCumplido == 0)
	{
		$icono = '<img src="images\iconosmenu\Rojo.png" width="30">';		
	}

	//$valorTarea .' '. $valorCumplido. 
	return $icono;
}

function imprimirTabla($titulo, $informacion)
{
	echo '<div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#mision">'.$titulo.'</a>
              </h4>
            </div>
            <div id="mision" class="panel-collapse collapse in">
              <div class="panel-body">
                <div class="form-group" id="test">
                  <div class="col-sm-10" style="width: 100%;">
                    <div class="input-group">

                    <table  class="table table-striped table-bordered table-hover" width="1490">
						<caption>'.$titulo.'</caption>

						<thead class="thead-inverse">
							<tr class="table-info">
								<th scope="col" width="30%">&nbsp;</th>
								<th >Presupuesto</th>
								<th >Costo Real</th>
								<th >Cumplimiento</th>
								<th >Responsable</th>
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
							</tr>
						</thead>
						<tbody>';

							foreach($informacion as $dato)
							{
								echo '<tr>
									<th scope="row">'.$dato->descripcionTarea.'</th>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
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
								</tr>';
							}
						
						echo '</tbody>
					</table>
				</div>
              </div>
            </div>  
          </div> 
        </div>
      </div>';
}
?>

<style>
    .info {
            background-color: blue,
            color: white;
        }

</style>
	<div class="col-lg-12">
	    <div class="panel panel-default" style="width:1500px;">
			<div class="panel-body" >
				<table class="table" width="1490">
					<thead>
						<tr>
							<td align="center">Plan de Trabajo</td>
						</tr>
					</thead>
				</table>



				<div class="form-group">
		          <div class="col-lg-12">
		            <div class="panel panel-default">
		              <div class="panel-heading">Detalles</div>
		              <div class="panel-body">
		                <div class="panel-group" id="accordion">
		                  <?php
								imprimirTabla('Investigacion de Accidentes', $accidente);
								imprimirTabla('Auditorías', $auditoria);				
								imprimirTabla('Planes de Capacitación', $capacitacion);				
								imprimirTabla('Programas / Actividades', $programa);	
								imprimirTabla('Examenes Médicos', $examen);
								imprimirTabla('Inspecciones de Seguridad', $inspeccion);
							?>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
			</div>
		</div>
	</div>
	{!!Form::close()!!}
@stop