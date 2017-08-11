@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Plan de Trabajo Anual</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/plantrabajo.js')!!}

<?php
  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  $base64 = ''; 
  if(isset($plantrabajoformulario))
  {
    $path = 'imagenes/'.$plantrabajoformulario["firmaAuditorPlanTrabajo"];
    
    if($plantrabajoformulario["firmaAuditorPlanTrabajo"] != "" and file_exists($path))
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
<div id="signature-pad" class="m-signature-pad" style="float:top;">
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
              {!!Form::hidden('idPlanTrabajo', null, array('id' => 'idPlanTrabajo')) !!}
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
              		{!!Form::select('Tercero_idAuditor',$Tercero_idAuditor, (isset($plantrabajoformulario) ? $plantrabajoformulario->Tercero_idAuditor : 0),["class" => "form-control", "placeholder" =>"Seleccione el auditor"])!!}

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
				
    <div class="panel-group" id="accordion">
      <?php
  			if (isset($plantrabajoformulario)) 
  			{
  				for ($i=0; $i < count($plantrabajodetalle); $i++) 
  				{ 
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
								<th >Meta</th>
								<th >Responsable</th>
								<th >Observación</th>
							</tr>
						</thead>
						<tbody>';
  					while ($i < $total and $moduloAnt == $detalle[$i]["nombreModulo"])
  					{
  						// cada campo en un TD
  						?>
  						{!!Form::hidden('idPlanTrabajoDetalle[]', (isset($plantrabajoformulario->plantrabajodetalle) ? $detalle[$i]["idPlanTrabajoDetalle"] : null), array('id' => 'idPlanTrabajoDetalle')) !!}
  						<?php
  						echo 
  						'<input type="hidden" id="PlanTrabajo_idPlanTrabajo" name="PlanTrabajo_idPlanTrabajo[]" value="'.$detalle[$i]["PlanTrabajo_idPlanTrabajo"].'">

  						<input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="'.$detalle[$i]["Modulo_idModulo"].'">

  						<input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$detalle[$i]["idConcepto"].'">

  						<input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="'.$detalle[$i]["TipoExamenMedico_idTipoExamenMedico"].'">

  						<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$detalle[$i]["nombreConceptoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="eneroPlanTrabajoDetalle" name="eneroPlanTrabajoDetalle[]" value="'.$detalle[$i]["eneroPlanTrabajoDetalle"].'">

  						<input type="hidden" id="febreroPlanTrabajoDetalle" name="febreroPlanTrabajoDetalle[]" value="'.$detalle[$i]["febreroPlanTrabajoDetalle"].'">

  						<input type="hidden" id="marzoPlanTrabajoDetalle" name="marzoPlanTrabajoDetalle[]" value="'.$detalle[$i]["marzoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="abrilPlanTrabajoDetalle" name="abrilPlanTrabajoDetalle[]" value="'.$detalle[$i]["abrilPlanTrabajoDetalle"].'">

  						<input type="hidden" id="mayoPlanTrabajoDetalle" name="mayoPlanTrabajoDetalle[]" value="'.$detalle[$i]["mayoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="junioPlanTrabajoDetalle" name="junioPlanTrabajoDetalle[]" value="'.$detalle[$i]["junioPlanTrabajoDetalle"].'">

  						<input type="hidden" id="julioPlanTrabajoDetalle" name="julioPlanTrabajoDetalle[]" value="'.$detalle[$i]["julioPlanTrabajoDetalle"].'">

  						<input type="hidden" id="agostoPlanTrabajoDetalle" name="agostoPlanTrabajoDetalle[]" value="'.$detalle[$i]["agostoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="septiembrePlanTrabajoDetalle" name="septiembrePlanTrabajoDetalle[]" value="'.$detalle[$i]["septiembrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="octubrePlanTrabajoDetalle" name="octubrePlanTrabajoDetalle[]" value="'.$detalle[$i]["octubrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="noviembrePlanTrabajoDetalle" name="noviembrePlanTrabajoDetalle[]" value="'.$detalle[$i]["noviembrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="diciembrePlanTrabajoDetalle" name="diciembrePlanTrabajoDetalle[]" value="'.$detalle[$i]["diciembrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="'.$detalle[$i]["presupuestoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="'.$detalle[$i]["costoRealPlanTrabajoDetalle"].'">';

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
	  					<td><input type="text" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="'.(isset($detalle[$i]["cumplimientoPlanTrabajoDetalle"]) ? $detalle[$i]["cumplimientoPlanTrabajoDetalle"] : "" ).'"</td>
	  					<td><input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="'.(isset($detalle[$i]["metaPlanTrabajoDetalle"]) ? $detalle[$i]["metaPlanTrabajoDetalle"] : "" ).'"</td>
	  					<td>';?>
							{!!Form::select('Cargo_idResponsable[]',$Cargo_idResponsable, (isset($plantrabajoformulario) ? $detalle[$i]["idCargo"] : ''),["class" => "form-control", "placeholder" =>"Seleccione el cargo responsable"])!!}
						<?php 
						echo '</td>
	  					<td><textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">'.$detalle[$i]["observacionPlanTrabajoDetalle"].'</textarea></td>

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
  				//////////////////////////////////////////////////////////
  				// R O M P I M I E N T O   E X A M E N E S   M E D I C O S
  				//////////////////////////////////////////////////////////

  				for ($i=0; $i < count($plantrabajodetalleexamen); $i++) 
  				{ 
  					$examen[] = get_object_vars($plantrabajodetalleexamen[$i]);
  				}

  				$reg = 0;
  				$total = count($examen);

  				$meses = array('enero','febrero','marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

  					$moduloAnt = $examen[$reg]["nombreModulo"];

  				echo 
  					'<div class="panel panel-primary">
            			<div class="panel-heading">
	              			<h4 class="panel-title">
	                		<a data-toggle="collapse" data-parent="#accordion" href="#'.$examen[$reg]["Modulo_idModulo"].'">'.$moduloAnt.'</a>
	              			</h4>
            			</div>
            			<div id="'.$examen[$reg]["Modulo_idModulo"].'" class="panel-collapse">
              			<div class="panel-body" style="overflow:auto;">';


			    while ($reg < $total) 
			    {
			    	$examenAnt = $examen[$reg]['nombreTipoExamenMedico'];
			    
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
									<th >Meta</th>
									<th >Responsable</th>
									<th >Observación</th>
								</tr>
							</thead>
							<tbody>';

			    	while ($reg < $total AND $examenAnt == $examen[$reg]['nombreTipoExamenMedico']) 
  					{
  						echo 
  						'<input type="hidden" id="idPlanTrabajoDetalle" name="idPlanTrabajoDetalle[]" value="'.$examen[$reg]["idPlanTrabajoDetalle"].'">

  						<input type="hidden" id="PlanTrabajo_idPlanTrabajo" name="PlanTrabajo_idPlanTrabajo[]" value="'.$examen[$reg]["PlanTrabajo_idPlanTrabajo"].'">

  						<input type="hidden" id="Modulo_idModulo" name="Modulo_idModulo[]" value="'.$examen[$reg]["Modulo_idModulo"].'">

  						<input type="hidden" id="idConcepto" name="idConcepto[]" value="'.$examen[$reg]["idConcepto"].'">

  						<input type="hidden" id="TipoExamenMedico_idTipoExamenMedico" name="TipoExamenMedico_idTipoExamenMedico[]" value="'.$examen[$reg]["TipoExamenMedico_idTipoExamenMedico"].'">

  						<input type="hidden" id="nombreConceptoPlanTrabajoDetalle" name="nombreConceptoPlanTrabajoDetalle[]" value="'.$examen[$reg]["nombreConceptoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="eneroPlanTrabajoDetalle" name="eneroPlanTrabajoDetalle[]" value="'.$examen[$reg]["eneroPlanTrabajoDetalle"].'">

  						<input type="hidden" id="febreroPlanTrabajoDetalle" name="febreroPlanTrabajoDetalle[]" value="'.$examen[$reg]["febreroPlanTrabajoDetalle"].'">

  						<input type="hidden" id="marzoPlanTrabajoDetalle" name="marzoPlanTrabajoDetalle[]" value="'.$examen[$reg]["marzoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="abrilPlanTrabajoDetalle" name="abrilPlanTrabajoDetalle[]" value="'.$examen[$reg]["abrilPlanTrabajoDetalle"].'">

  						<input type="hidden" id="mayoPlanTrabajoDetalle" name="mayoPlanTrabajoDetalle[]" value="'.$examen[$reg]["mayoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="junioPlanTrabajoDetalle" name="junioPlanTrabajoDetalle[]" value="'.$examen[$reg]["junioPlanTrabajoDetalle"].'">

  						<input type="hidden" id="julioPlanTrabajoDetalle" name="julioPlanTrabajoDetalle[]" value="'.$examen[$reg]["julioPlanTrabajoDetalle"].'">

  						<input type="hidden" id="agostoPlanTrabajoDetalle" name="agostoPlanTrabajoDetalle[]" value="'.$examen[$reg]["agostoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="septiembrePlanTrabajoDetalle" name="septiembrePlanTrabajoDetalle[]" value="'.$examen[$reg]["septiembrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="octubrePlanTrabajoDetalle" name="octubrePlanTrabajoDetalle[]" value="'.$examen[$reg]["octubrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="noviembrePlanTrabajoDetalle" name="noviembrePlanTrabajoDetalle[]" value="'.$examen[$reg]["noviembrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="diciembrePlanTrabajoDetalle" name="diciembrePlanTrabajoDetalle[]" value="'.$examen[$reg]["diciembrePlanTrabajoDetalle"].'">

  						<input type="hidden" id="presupuestoPlanTrabajoDetalle" name="presupuestoPlanTrabajoDetalle[]" value="'.$examen[$reg]["presupuestoPlanTrabajoDetalle"].'">

  						<input type="hidden" id="costoRealPlanTrabajoDetalle" name="costoRealPlanTrabajoDetalle[]" value="'.$examen[$reg]["costoRealPlanTrabajoDetalle"].'">';

  						echo '<tr align="center">';
  						echo '<td>'.$examen[$reg]["nombreConceptoPlanTrabajoDetalle"].'</td>';
  						
  						for($mes = 0; $mes <= 11; $mes++)
	  					{	
	  						switch ($examen[$reg][$meses[$mes]."PlanTrabajoDetalle"]) 
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
											<img src="http://'.$_SERVER['HTTP_HOST'].'/images/iconosmenu/Amarillo.png" width="30"><label style="color:black;">'.$examen[$reg][$meses[$mes]."PlanTrabajoDetalle"].'%</label>
										</a>
	  								</td>';
	  								break;
	  						};
	  					}
	  					echo '
	  					<td>'.(isset($examen[$reg]["presupuestoPlanTrabajoDetalle"]) ? $examen[$reg]["presupuestoPlanTrabajoDetalle"] : "" ).'</td>
	  					<td>'.(isset($examen[$reg]["costoRealPlanTrabajoDetalle"]) ? $examen[$reg]["costoRealPlanTrabajoDetalle"] : "" ).'</td>
	  					<td><input type="text" id="cumplimientoPlanTrabajoDetalle" name="cumplimientoPlanTrabajoDetalle[]" value="'.(isset($examen[$reg]["cumplimientoPlanTrabajoDetalle"]) ? $examen[$reg]["cumplimientoPlanTrabajoDetalle"] : "" ).'"</td>
	  					<td><input type="text" id="metaPlanTrabajoDetalle" name="metaPlanTrabajoDetalle[]" value="'.(isset($examen[$reg]["metaPlanTrabajoDetalle"]) ? $examen[$reg]["metaPlanTrabajoDetalle"] : "" ).'"</td>
	  					<td>';?>
							{!!Form::select('Cargo_idResponsable[]',$Cargo_idResponsable, (isset($plantrabajodetalleexamen) ? $examen[$reg]["idCargo"] : ''),["class" => "form-control", "placeholder" =>"Seleccione el cargo responsable"])!!}
						<?php 
						echo '</td>
	  					<td><textarea id="observacionPlanTrabajoDetalle" name="observacionPlanTrabajoDetalle[]">'.$examen[$reg]["observacionPlanTrabajoDetalle"].'</textarea></td>

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
  			else
  			{
				echo "
				<script>
					$(document).ready(function(){
						consultarPlanTrabajo('2017','a','','plantrabajo');
					});
				</script>";
			}
		?>
    </div>
		    
@if(isset($plantrabajoformulario))
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