@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Plan de Trabajo Anual</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::style('css/signature-pad.css'); !!} 

<?php
  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  $base64 = ''; 
  if(isset($plantrabajo))
  {
    $path = 'imagenes/'.$plantrabajo["firmaAuditorPlanTrabajo"];
    
    if($plantrabajo["firmaAuditorPlanTrabajo"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
  }

?>

	@if(isset($plantrabajoformulario))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($plantrabajoformulario,['route'=>['plantrabajoformulario.destroy',$plantrabajoformulario->idPlanTrabajo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($plantrabajoformulario,['route'=>['plantrabajoformulario.update',$plantrabajoformulario->idPlanTrabajo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'plantrabajoformulario.store','method'=>'POST'])!!}
	@endif



<div id='form-section' >
<div id="signature-pad" class="m-signature-pad">
    <input type="hidden" id="signature-reg" value="">
    <div class="m-signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
      <div class="description">Firme sobre el recuadro</div>
      <button type="button" class="button clear btn btn-danger" data-action="clear">Limpiar</button>
      <button type="button" class="button save btn btn-success" data-action="save">Guardar Firma</button>
    </div>
</div>
	<fieldset id="plantrabajo-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('numeroPlanTrabajo', 'Número', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('numeroPlanTrabajo',null,['class'=>'form-control','placeholder'=>'Ingresa el número del plan de trabajo'])!!}
              {!!Form::hidden('idPlanTrabajo', null, array('id' => 'idplantrabajo')) !!}
            </div>
          </div>
        </div>
		
		<div class="form-group" id='test'>
          {!!Form::label('fechaPlanTrabajo', 'Fecha', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
				{!!Form::text('fechaPlanTrabajo',null,['class'=>'form-control','placeholder'=>'Ingresa la fecha del plan de trabajo'])!!}
            </div>
          </div>
        </div>


        <div class="form-group" id='test'>
          {!!Form::label('asuntoPlanTrabajo', 'Asunto', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o"></i>
              </span>
				{!!Form::text('asuntoPlanTrabajo',null,['class'=>'form-control','placeholder'=>'Ingresa el asunto del plan de trabajo'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
           {!!Form::label('Tercero_idAuditor', 'Revisado por:', array('class' => 'col-sm-2 control-label'))!!}          
            <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-pencil-square-o"></i>
                  </span>
              		{!!Form::select('Tercero_idAuditor',$Tercero_idAuditor, (isset($plantrabajo) ? $plantrabajo->Tercero_idAuditor : 0),["class" => "form-control", "placeholder" =>"Seleccione auditor del plan de trabajo"])!!}

	              <div class="col-sm-10">
	                <img id="firma" style="width:200px; height: 150px; border: 1px solid;" onclick="mostrarFirma();" src="<?php echo $base64;?>">
	                {!!Form::hidden('firmabase64', $base64, array('id' => 'firmabase64'))!!}
	              </div>
            	</div>
          	</div>
        </div>
        <input type="hidden" id="token" value="{{csrf_token()}}"/>
    </fieldset>
 </div>


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
							<img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/'.$icono.'"  width="30">
						</a>'.$etiqueta;	
	}
	//$valorTarea .' '. $valorCumplido. 
	return $icono;
}

function valorTarea($valorTarea, $valorCumplido)
{

	$valor = '';	
	$valor = number_format(($valorCumplido / ($valorTarea == 0 ? 1: $valorTarea) *100),1,'.',',');

	if ($valorTarea == 0 and $valorCumplido == 0) 
	{
		$valor = '';
	}
	
	return $valor;
}



function imprimirTabla($titulo, $informacion , $idtabla, $tercero, $idModulo)
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
								<th >Observación</th>
							</tr>
						</thead>
						<tbody>';

							foreach($informacion as $dato)
							{
								echo '<tr align="center">
								<input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="'.$idModulo.'">
									<th scope="row">'.$dato->descripcionTarea.'</th>
									<input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$dato->idConcepto.'">
									<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$dato->descripcionTarea.'">

									<td>'.colorTarea($dato->EneroT, $dato->EneroC).'</td>
									<input type="hidden" id="eneroPlanTrabajoDetalle" name="eneroPlanTrabajoDetalle[]" value="'.valorTarea($dato->EneroT, $dato->EneroC).'">

									<td>'.colorTarea($dato->FebreroT, $dato->FebreroC).'</td>
									<input type="hidden" id="febreroPlanTrabajoDetalle" name="febreroPlanTrabajoDetalle[]" value="'.valorTarea($dato->FebreroT, $dato->FebreroC).'">

									<td>'.colorTarea($dato->MarzoT, $dato->MarzoC).'</td>
									<input type="hidden" id="marzoPlanTrabajoDetalle" name="marzoPlanTrabajoDetalle[]" value="'.valorTarea($dato->MarzoT, $dato->MarzoC).'">

									<td>'.colorTarea($dato->AbrilT, $dato->AbrilC).'</td>
									<input type="hidden" id="abrilPlanTrabajoDetalle" name="abrilPlanTrabajoDetalle[]" value="'.valorTarea($dato->AbrilT, $dato->AbrilC).'">

									<td>'.colorTarea($dato->MayoT, $dato->MayoC).'</td>
									<input type="hidden" id="mayoPlanTrabajoDetalle" name="mayoPlanTrabajoDetalle[]" value="'.valorTarea($dato->MayoT, $dato->MayoC).'">

									<td>'.colorTarea($dato->JunioT, $dato->JunioC).'</td>
									<input type="hidden" id="junioPlanTrabajoDetalle" name="junioPlanTrabajoDetalle[]" value="'.valorTarea($dato->JunioT, $dato->JunioC).'">

									<td>'.colorTarea($dato->JulioT, $dato->JulioC).'</td>
									<input type="hidden" id="julioPlanTrabajoDetalle" name="julioPlanTrabajoDetalle[]" value="'.valorTarea($dato->JulioT, $dato->JulioC).'">

									<td>'.colorTarea($dato->AgostoT, $dato->AgostoC).'</td>
									<input type="hidden" id="agostoPlanTrabajoDetalle" name="agostoPlanTrabajoDetalle[]" value="'.valorTarea($dato->AgostoT, $dato->AgostoC).'">

									<td>'.colorTarea($dato->SeptiembreT, $dato->SeptiembreC).'</td>
									<input type="hidden" id="septiembrePlanTrabajoDetalle" name="septiembrePlanTrabajoDetalle[]" value="'.valorTarea($dato->SeptiembreT, $dato->SeptiembreC).'">

									<td>'.colorTarea($dato->OctubreT, $dato->OctubreC).'</td>
									<input type="hidden" id="octubrePlanTrabajoDetalle" name="octubrePlanTrabajoDetalle[]" value="'.valorTarea($dato->OctubreT, $dato->OctubreC).'">

									<td>'.colorTarea($dato->NoviembreT, $dato->NoviembreC).'</td>
									<input type="hidden" id="noviembrePlanTrabajoDetalle" name="noviembrePlanTrabajoDetalle[]" value="'.valorTarea($dato->NoviembreT, $dato->NoviembreC).'">

									<td>'.colorTarea($dato->DiciembreT, $dato->DiciembreC).'</td>
									<input type="hidden" id="diciembrePlanTrabajoDetalle" name="diciembrePlanTrabajoDetalle[]" value="'.valorTarea($dato->DiciembreT, $dato->DiciembreC).'">

									<td>'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'</td>
									<input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="'.(isset($dato->PresupuestoT) ? $dato->PresupuestoT : '&nbsp;').'">

         							<td>'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'</td>
         							<input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="'.(isset($dato->PresupuestoC) ? $dato->PresupuestoC : '&nbsp;').'">

									<td><input type="text" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]"></td>

									<td>';?>
										{!!Form::select('Tercero_idResponsable[]',$tercero, (isset($plantrabajo) ? $plantrabajo->Tercero_idAuditor : 0),["class" => "form-control", "placeholder" =>"Seleccione auditor del plan de trabajo"])!!}
									<?php 
									echo '</td>
									<td><textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]"></textarea></td>
								</tr>';
							}
						
						echo '</tbody>
					</table>
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
				
    <div class="panel-group" id="accordion">
      <?php
  			if (isset($plantrabajo)) 
  			{
  				for ($i=0; $i < count($plantrabajodetalle); $i++) { 
  					$detalle[] = get_object_vars($plantrabajodetalle[$i]);
  				}

  				$i = 0;
  				$total = count($detalle);

  				$meses = array('enero','febrero','marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
  				while ($i < $total) 
  				{
  					$moduloAnt = $detalle[$i]["nombreModulo"];
  					echo 
  					'<div class="panel panel-primary">
            			<div class="panel-heading">
	              			<h4 class="panel-title">
	                		<a data-toggle="collapse" data-parent="#accordion" href="#'.$detalle[$i]["Modulo_idModulo"].'">'.$moduloAnt.'</a>
	              			</h4>
            			</div>
            			<div id="'.$detalle[$i]["Modulo_idModulo"].'" class="panel-collapse">
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
								<th >Observación</th>
							</tr>
						</thead>
						<tbody>';
  					while ($i < $total and $moduloAnt == $detalle[$i]["nombreModulo"])
  					{
  						// cada campo en un TD
  						echo '<tr align="center">';
  						echo '<td>'.$detalle[$i]["nombreConceptoPlanTrabajoDetalle"].'</td>';
  						
  						for($mes = 0; $mes <= 11; $mes++)
	  					{	
	  						switch ($detalle[$i][$meses[$mes]."PlanTrabajoDetalle"]) 
	  						{
	  							case null:
	  								echo '<td>  </td>';
	  								break;

	  							case 0:
	  								echo '
	  								<td>
	  									<a href="#" data-toggle="tooltip" data-placement="right" title="">
											<img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/Rojo.png" width="30">
										</a>
	  								</td>';
	  								break;
	  							
	  							case 100:
	  								echo '
	  								<td>
	  									<a href="#" data-toggle="tooltip" data-placement="right" title="">
											<img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/Verde.png" width="30">
										</a>
	  								</td>';
	  								break;

	  							default:
	  								echo '
	  								<td>
	  									<a href="#" data-toggle="tooltip" data-placement="right" title="">
											<img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/Amarillo.png" width="30"><label style="color:black;">'.$detalle[$i][$meses[$mes]."PlanTrabajoDetalle"].'%</label>
										</a>
	  								</td>';
	  								break;
	  						};
	  					}
	  					echo '
	  					<td>'.(isset($detalle[$i]["presupuestoPlanTrabajoDetalle"]) ? $detalle[$i]["presupuestoPlanTrabajoDetalle"] : "" ).'</td>
	  					<td>'.(isset($detalle[$i]["costoRealPlanTrabajoDetalle"]) ? $detalle[$i]["costoRealPlanTrabajoDetalle"] : "" ).'</td>
	  					<td><input type="text" value="'.(isset($detalle[$i]["cumplimientoPlanTrabajoDetalle"]) ? $detalle[$i]["cumplimientoPlanTrabajoDetalle"] : "" ).'"></td>
	  					<td>'.$detalle[$i]["nombreCompletoTercero"].'</td>
	  					<td><textarea>'.$detalle[$i]["observacionPlanTrabajoDetalle"].'</textarea></td>

	  					</tr>';

  						$i++;
  					}

  					// cerrar tabla
  					echo '
  									</tbody>
								</table>
  							</div> 
				        </div>
				    </div>';

  				}


  			}
  			else
  			{
				imprimirTabla('Revision de Información', $matrizlegal, 'matrizlegal',$Tercero_idAuditor, 30);
				imprimirTabla('Acta Reunión', $grupoapoyo, 'grupoapoyo',$Tercero_idAuditor, 9);
				imprimirTabla('Plan de Capacitación', $capacitacion, 'capacitacion',$Tercero_idAuditor, 36);	
				imprimirTabla('Programas', $programa, 'programa',$Tercero_idAuditor, 40);	
				imprimirTabla('Examen Médico', $examen, 'examen',$Tercero_idAuditor, 22);
				imprimirTabla('Accidente', $accidente, 'accidente',$Tercero_idAuditor, 3);
				imprimirTabla('Inspección', $inspeccion, 'inspeccion',$Tercero_idAuditor, 24);
				imprimirTabla('Plan de Auditoría', $auditoria, 'auditoria',$Tercero_idAuditor, 32);
				imprimirTabla('Atividades de Grupos de Apoyo ', $actividadesgrupoapoyo, 'actividadesgrupoapoyo',$Tercero_idAuditor, 9);
			}
		?>
    </div>
		    
@if(isset($plantrabajo))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif

	{!! Form::close() !!}
	

<script type="text/javascript">

	$('#fechaPlanTrabajo').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    $(document).ready(function()
	  {
	    mostrarFirma();
	  });

    

</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}
@stop