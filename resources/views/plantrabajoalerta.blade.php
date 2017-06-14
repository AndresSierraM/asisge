@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Configuraci&oacute;n de la Alerta- Plan de Trabajo</center></h3>@stop
@section('content')
@include('alerts.request')

{!!Html::script('js/plantrabajoalerta.js')!!}

<?php 
	$fechaDia = null;
	$horaDia = null;
	$intervaloDia = null;

	$fechaSemana = null;
	$horaSemana = null;
	$intervaloSemana = null;

	$fechaMes = null;
	$horaMes = null;

if(isset($plantrabajoalerta))
{

	if($plantrabajoalerta->tareaDiasPlanTrabajoAlerta != '')
	{
		
		$fechaSemana = $plantrabajoalerta->tareaFechaInicioPlanTrabajoAlerta;
		$horaSemana = $plantrabajoalerta->tareaHoraPlanTrabajoAlerta;
		$intervaloSemana = $plantrabajoalerta->tareaIntervaloPlanTrabajoAlerta;
	}
	else
	{
		if($plantrabajoalerta->tareaMesesPlanTrabajoAlerta != '')
		{
			
			$fechaMes = $plantrabajoalerta->tareaFechaInicioPlanTrabajoAlerta;
			$horaMes = $plantrabajoalerta->tareaHoraPlanTrabajoAlerta;
		}
		else
		{
			$fechaDia = $plantrabajoalerta->tareaFechaInicioPlanTrabajoAlerta;
			$horaDia = $plantrabajoalerta->tareaHoraPlanTrabajoAlerta;
			$intervaloDia = $plantrabajoalerta->tareaIntervaloPlanTrabajoAlerta;
		}
	}
}

?>

<script>
  // tomamos los valores de los modulos enviados desde el controlador, y los almacenamos en un array convertidos en formato json
  // para luego enviarlo como parametro al multiregistro en el campo descripcionModulo
  var modulos = [JSON.parse('<?php echo $idModulo;?>'), JSON.parse('<?php echo $nombreModulo;?>')];

 var alertaplan = '<?php echo (isset($plantrabajoalerta) ? json_encode($plantrabajoalerta->planTrabajoAlertaModulo) : "");?>';
    alertaplan = (alertaplan != '' ? JSON.parse(alertaplan) : '');
   

  var valorModelo = [0,''];
  $(document).ready(function(){
    //objeto  ---  instancia  ---     PARAMETROS  
    PlanTrabajoAlertaModulo = new Atributos('PlanTrabajoAlertaModulo','planTrabajoAlertaModulo_Modulo','modulodescripcion_');

    PlanTrabajoAlertaModulo.campoid = 'idPlanTrabajoAlertaModulo';  //hermanitas             
    PlanTrabajoAlertaModulo.campoEliminacion = 'idsborrados';//hermanitas         Cuando se utilice la funcionalidad 
    PlanTrabajoAlertaModulo.botonEliminacion = true;//hermanitas
    // despues del punto son las propiedades que se le van adicionar al objeto
    PlanTrabajoAlertaModulo.campos = ['idPlanTrabajoAlertaModulo','Modulo_idModulo','PlanTrabajoAlerta_idPlanTrabajoAlerta']; //[arrays ]
    PlanTrabajoAlertaModulo.altura = '35px;';
     // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
    PlanTrabajoAlertaModulo.etiqueta = ['input','select','input'];
    PlanTrabajoAlertaModulo.tipo = ['hidden','','hidden']; //tip hidden - oculto para el usuario  y los otros quedan visibles ''
    PlanTrabajoAlertaModulo.estilo = ['','width: 1050px;height:35px;',''];	

    // estas propiedades no son muy usadas PERO SON UToILES
    
    PlanTrabajoAlertaModulo.clase = ['','', ''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
    PlanTrabajoAlertaModulo.sololectura = [false,false, false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
    PlanTrabajoAlertaModulo.completar = ['off','off', 'off']; //autocompleta 
    
    PlanTrabajoAlertaModulo.opciones = ['',modulos, '']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
    PlanTrabajoAlertaModulo.funciones  = ['','', '']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  

    for(var j=0, k = alertaplan.length; j < k; j++)
      {
        // permisos.agregarCampos(JSON.stringify(alertaplan[j]),'L');
        // console.log(JSON.stringify(alertaplan[j]))
           PlanTrabajoAlertaModulo.agregarCampos(JSON.stringify(alertaplan[j]),'L');
           // llenarplantrabajoalertaModelo($("#idPlanTrabajoAlertaModulo"+j).val());
        // Llamar la funcion en el for para que por cada registro de la multiregistro el haga el ajax de llenar el nombre del rol
        // enviando el respectivo id del rol 
      }
  });

  
</script> 

@if(isset($plantrabajoalerta))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($plantrabajoalerta,['route'=>['plantrabajoalerta.destroy',$plantrabajoalerta->idPlanTrabajoAlerta],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($plantrabajoalerta,['route'=>['plantrabajoalerta.update',$plantrabajoalerta->idPlanTrabajoAlerta],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'plantrabajoalerta.store','method'=>'POST'])!!}
  @endif

<div id='form-section' >
	<fieldset id="pestañas-form-fieldset">	
<input type="hidden" id="token" value="{{csrf_token()}}"/>
		<div class="form-group" id='test'>
			 {!!Form::label('nombrePlanTrabajoAlerta', 'Descripción', array('class' => 'col-sm-1 control-label')) !!}
			<div class="col-sm-11">
				<div class="input-group">
			         <span class="input-group-addon">
			                <i class="fa fa-user " style="width: 14px;"></i>
			         </span>
			             {!!Form::text('nombrePlanTrabajoAlerta',null,['class'=> 'form-control','placeholder'=>'Ingrese el nombre de la alerta'])!!}
			     </div>
			</div>
		</div>

		<ul class="nav nav-tabs"> <!--Pestañas de navegacion 3 opciones-->

		<li class="active"><a data-toggle="tab" href="#correo"><?php echo "<img src=http://".$_SERVER["HTTP_HOST"]."/images/correo.png style='width:40px; height:30px;'></a></li></a></li>"?>

		<li class=""><a data-toggle="tab" href="#tarea"><?php echo "<img src=http://".$_SERVER["HTTP_HOST"]."/images/clock.png style='width:40px; height:30px;'></a></li></a></li>"?>
		<li class=""><a data-toggle="tab" href="#filtro"><?php echo "<img src=http://".$_SERVER["HTTP_HOST"]."/images/setup.png style='width:40px; height:30px;'></a></li></a></li>"?>

		</ul>


	<div class="tab-content">


	<div id="correo" class="tab-pane fade in active">
	<div class="plantrabajoalerta-container">


			          <!--  Destinatario -->

		<div class="form-group" id='test'>
			 {!!Form::label('correoParaPlanTrabajoAlerta', 'Para', array('class' => 'col-sm-1 control-label')) !!}
			<div class="col-sm-11">
				<div class="input-group">
			         <span class="input-group-addon">
			                <i class="fa fa-user" style="width: 14px;"></i>
			         </span>
			             {!!Form::text('correoParaPlanTrabajoAlerta',null,['class'=> 'form-control','placeholder'=>'Ingrese correo destinatario'])!!}
			             {!!Form::hidden('idPlanTrabajoAlerta', null, array('id' => 'idPlanTrabajoAlerta')) !!}
			             {!!Form::hidden('idsborrados', null, array('id' => 'idsborrados')) !!}
			     </div>
			</div>
		</div>


			    	<!--  copia -->
		 <div class="form-group" id='test'>
				     {!!Form::label('correoCopiaPlanTrabajoAlerta', 'CC', array('class' => 'col-sm-1 control-label')) !!}
			<div class="col-sm-11">
				 <div class="input-group">
				       <span class="input-group-addon">
				                <i class="fa fa-files-o" style="width: 14px;"></i>
				       </span>
				            	{!!Form::text('correoCopiaPlanTrabajoAlerta',null,['class'=> 'form-control','placeholder'=>'Ingrese correo para copia','style'=>'width:100%;,right'])!!}
				 </div>
			</div>
		 </div>

			      <!-- Copia Oculta -->
					<div class="form-group" id='test'>
					    {!!Form::label('correoCopiaOcultaPlanTrabajoAlerta', 'CCO', array('class' => 'col-sm-1 control-label')) !!}
				        <div class="col-sm-11">
				            <div class="input-group">
				              <span class="input-group-addon">
				                <i class="fa fa-clipboard" style="width: 14px;"></i>
				              </span>
							{!!Form::text('correoCopiaOcultaPlanTrabajoAlerta',null,['class'=> 'form-control','placeholder'=>'Ingrese correo para copia oculta','style'=>'width:100%;,right'])!!}
			            	</div>
			          </div>
			        </div>


			      	<!-- place holder para la Asunto -->
			      	<div class="form-group" id='test'>
			 		{!!Form::label('correoAsuntoPlanTrabajoAlerta', 'Asunto', array('class' => 'col-sm-1 control-label')) !!}
			          <div class="col-sm-11">
			            <div class="input-group">
			              <span class="input-group-addon">
			                <i class="fa fa-pencil-square" style="width: 14px;"></i>
			              </span>
						{!!Form::text('correoAsuntoPlanTrabajoAlerta',null,['class'=> 'form-control','placeholder'=>'Ingrese Asunto ','style'=>'width:100%;,right'])!!}
			            </div>
			          </div>
			        </div>
			    
			      <!-- Mensaje -->
			    
			        <div class="form-group" id='test'>
			     {!!Form::label('correoMensajePlanTrabajoAlerta', 'Mensaje', array('class' => 'col-sm-1 control-label')) !!}
			          <div class="col-sm-12">
			            <div class="input-group">
			              <span class="input-group-addon">
			                <i class="fa fa-commenting-o" style="width: 14px;"></i>
			              </span>
							{!!Form::textarea('correoMensajePlanTrabajoAlerta',null,['class'=> 'form-control','placeholder'=>'','style'=>'width:600px;,right'])!!}
			            </div>
			          </div>
			        </div>  


			     </div>
			  </div>


													<!-- ULTIMA OPCION MULTIREGISTRO -->
	<div id="filtro" class="tab-pane fade">
		<div class="plantrabajoalerta-container">
				<!-- Meses pasados --> 
			<div class="form-group" id='test'>
					         {!!Form::label('filtroMesesPasadosPlanTrabajoAlerta', 'Meses Pasados', array('class' => 'col-sm-1 control-label')) !!}
					<div class="col-sm-11">
					        <div class="input-group">	
					              <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					              </span>
					             {!!Form::text('filtroMesesPasadosPlanTrabajoAlerta',(isset($plantrabajoalerta) ? $plantrabajoalerta->filtroMesesPasadosPlanTrabajoAlerta : 1),['class'=> 'form-control','placeholder'=>'Ingrese la fecha de inicio','style'=>'width:100%;,right'])!!}
					        </div>
					 </div>
					 </br></br></br>
					<!--  MESES FUTUROS  -->

					   <div class="form-group" id='test'>
					         {!!Form::label('filtroMesesFuturosPlanTrabajoAlerta', 'Meses Futuros', array('class' => 'col-sm-1 control-label')) !!}
					       <div class="col-sm-11">
					            <div class="input-group">	
					              <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					              </span>
					             {!!Form::text('filtroMesesFuturosPlanTrabajoAlerta',(isset($plantrabajoalerta )? $plantrabajoalerta->filtroMesesFuturosPlanTrabajoAlerta : 1),['class'=> 'form-control','placeholder'=>'Ingrese la fecha de inicio','style'=>'width:100%;,right'])!!}
					            </div>
					         </div>
					    </div>


					    	</br></br>
						    
					         
					<div class="row">
					<div class="form-group" id='test'>
					{!!Form::label('filtroEstadosPlanTrabajoAlerta', 'Estado', array('class' => 'col-sm-1 control-label')) !!}
					    <div class="col-md-1">Pendiente
							    <div class="input-group">
							        {!! Form::checkbox('Estado1', 1,true, ['onclick' => 'seleccionarEstado();', 'id' => 'Estado1']) !!} 
							        {!!Form::hidden('filtroEstadosPlanTrabajoAlerta', '1,2,3,', array('id' => 'filtroEstadosPlanTrabajoAlerta')) !!}
							    </div>
						</div>	
						<div class="col-md-1">En proceso
							    <div class="input-group">
							         {!! Form::checkbox('Estado2', 1, true, ['onclick' => 'seleccionarEstado();', 'id' => 'Estado2'] ) !!} 
							    </div>
						</div>
						<div class="col-md-1">Terminados
							     <div class="input-group">
							          {!! Form::checkbox('Estado3', 1, true, ['onclick' => 'seleccionarEstado();', 'id' => 'Estado3']) !!} 
							     </div>
						</div>		
				    	</div> 
					</div>


						<!-- html multiregistro -->
				<div class="form-group" id='test'>
			      <div class="col-sm-12">

			        <div class="row show-grid">
			          <div class="col-md-1" style="width: 40px;height: 35px;" onclick="PlanTrabajoAlertaModulo.agregarCampos(valorModelo,'A')">
			            <span class="glyphicon glyphicon-plus"></span>
			          </div>
			          <div class="col-md-1" style="width: 1050px;display:inline-block;height:35px;">Nombre del Modulo</div>
			          <!-- este es el div para donde van insertando los registros --> 
			          <div id="planTrabajoAlertaModulo_Modulo">
			          </div>
			        </div>
			      </div>
			    </div>  


			</div>			  
		 </div>
    </div>



									<!-- panel para el primer calendario  fecha inicio  -->
									
			<div id="tarea" class="tab-pane fade">
				<div class="plantrabajoalerta-container">
				  <div class="panel-group" id="accordion">
				    <div class="panel panel-default">
				      <div class="panel-body">
				        <h4 class="panel-title active"></h4>


				          <a data-toggle="collapse" data-parent="#accordion" href="#Calendariodia"><?php echo "<img src=http://".$_SERVER["HTTP_HOST"]."/images/calendariodia.png style='width:60px; height:50px;'></a></li></a></li>"?></a> <b>Programación Diaria</b>

				          <div id="Calendariodia" class="panel-collapse collapse in">

					        
					        <!-- <div class="panel-body"> -->
					       
					        <div class="form-group" id='test'>
					         {!!Form::label('tareaFechaInicioPlanTrabajoAlertaDia', 'F.Inicio', array('class' => 'col-sm-1 control-label')) !!}
					          <div class="col-sm-11">
					            <div class="input-group">	
					              <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					              </span>
					             {!!Form::text('tareaFechaInicioPlanTrabajoAlertaDia',$fechaDia,['class'=> 'form-control','placeholder'=>'Ingrese la fecha de inicio','style'=>'width:100%;,right'])!!}
					            </div>
					          </div>
					        </div>
			      
			       

							<!-- Hora de la tarea  -->
				        	<div class="form-group" id='test'>
					         {!!Form::label('tareaHoraPlanTrabajoAlertaDia', 'Hora de Alarma', array('class' => 'col-sm-1 control-label')) !!}
					          <div class="col-sm-11">
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-clock-o"></i>
					              </span>
					             {!!Form::text('tareaHoraPlanTrabajoAlertaDia',$horaDia,['class'=> 'form-control','placeholder'=>'','style'=>'width:100%;,right'])!!}
				            	</div>
				          	   </div>
				        	</div>


				<!-- Ejecutar alerta  cada .. -->
			    
				<div class="form-group" id='test'>
			         <div class="col-sm-12">
			            <div class="input-group">
			           {!! Form::checkbox('tareaDiaLaboralPlanTrabajoAlerta', 1, true) !!} Ejecutar solo en días laborales
			            </div>
			         </div>
			    </div>
			        </br></br></br></br></br></br>

					<div class="form-group col-md-4" id='test'>
			          {!!Form::label('tareaIntervaloPlanTrabajoAlertaDia', 'Cada', array('class' => 'col-sm-3 control-label')) !!}
			          <div class="col-md-8">
			            <div class="input-group">
			              <span class="input-group-addon">
			                <i class="fa fa-bars"></i>
			              </span> 
			              {!!Form::text('tareaIntervaloPlanTrabajoAlertaDia',$intervaloDia,['class'=>'form-control','placeholder'=>'Ingrese la periodidad de dias', 'autocomplete' => 'off'])!!}
			              <span class="input-group-addon">
			              Días
			              </span>
			            </div>
			          </div>
			        </div>

			       </div>
			     </div>
			   </div>

</div>
</div>

			      											  <!-- Opciones segundo Calendario -->
		<div class="panel panel-default">
			<div class="panel-body">
				<h4 class="panel-title"></h4>
				<a data-toggle="collapse" data-parent="#accordion" href="#Calendariosemana"><?php echo "<img src=http://".$_SERVER["HTTP_HOST"]."/images/calendarioSemana.png style='width:60px; height:50px;'></a></li></a></li>"?></a><b>Programación Semanal</b>
			 <div id="Calendariosemana" class="panel-collapse collapse ">

			<!-- opcion fecha de inicio  -->
			   <div class="form-group" id='test'>
					         {!!Form::label('tareaFechaInicioPlanTrabajoAlertaSemana', 'F.Inicio', array('class' => 'col-sm-1 control-label')) !!}
					<div class="col-sm-11">
					    <div class="input-group">	
					        <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					        </span>
					             {!!Form::text('tareaFechaInicioPlanTrabajoAlertaSemana',$fechaSemana,['class'=> 'form-control','placeholder'=>'Ingrese la fecha de inicio','style'=>'width:100%;,right'])!!}
					     </div>
					 </div>
				</div>

			          <!-- panel para el Segudno calendario  -->
			        <div class="form-group" id='test'>
					         {!!Form::label('tareaHoraPlanTrabajoAlertaSemana', 'Hora de Alerta', array('class' => 'col-sm-1 control-label')) !!}
					      <div class="col-sm-11">
					        <div class="input-group">	
					              <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					              </span>
					              {!!Form::text('tareaHoraPlanTrabajoAlertaSemana',$horaSemana,['class'=> 'form-control','placeholder'=>'Ingrese la hora de inicio','style'=>'width:100%;,right'])!!}
					         </div>
					     </div>
					  </div>
			      
			       

							<!-- Cada cuanto  -->
				<div class="form-group col-md-12" id='test'>
			          {!!Form::label('tareaIntervaloPlanTrabajoAlertaSemana', 'Cada', array('class' => 'col-sm-1 control-label')) !!}
			        <div class="col-md-3">
			            <div class="input-group">
			              <span class="input-group-addon">
			                <i class="fa fa-bars"></i>
			              </span> 
			              {!!Form::text('tareaIntervaloPlanTrabajoAlertaSemana',$intervaloSemana,['class'=>'form-control','placeholder'=>'Ingrese la periodidad de dias', 'autocomplete' => 'off'])!!}
			              <span class="input-group-addon">
			              Semanas
			              </span>
			            </div>
			        </div>
			    </div>


			<!--  check Box para ejecutar la alerta de Dias laborales  -->
				    <div class="form-group" id='test'>
				         {!!Form::label('tareaDiaLaboralPlanTrabajoAlerta', 'Días de la semana', array('class' => 'col-sm-12 control-label')) !!}
				    </div>

			<!-- Dias de la semana separado con sus respectivos checkbox
			 -->
					<div class="row">
					    <div class="col-md-1">Lunes
							    <div class="input-group">
							        {!! Form::checkbox('Dia1', 1, true, ['onclick' => 'seleccionarDia();', 'id' => 'Dia1']) !!} 
							         {!! Form::hidden('tareaDiasPlanTrabajoAlerta', '1,2,3,4,5,', array('id' => 'tareaDiasPlanTrabajoAlerta')) !!}
							    </div>
						</div>	
						<div class="col-md-1">Martes
							    <div class="input-group">
							         {!! Form::checkbox('Dia2', 1, true, ['onclick' => 'seleccionarDia();', 'id' => 'Dia2']) !!} 
							    </div>
						</div>
						<div class="col-md-1">Miercoles
							     <div class="input-group">
							          {!! Form::checkbox('Dia3', 1, true, ['onclick' => 'seleccionarDia();', 'id' => 'Dia3']) !!} 
							     </div>
						</div>
						<div class="col-md-1">Jueves
							  <div class="input-group">
							   {!! Form::checkbox('Dia4', 1, true, ['onclick' => 'seleccionarDia();', 'id' => 'Dia4']) !!} 
							   </div>
						</div>
						<div class="col-md-1">Viernes
							  <div class="input-group">
							   {!! Form::checkbox('Dia5', 1, true, ['onclick' => 'seleccionarDia();', 'id' => 'Dia5']) !!} 
							  </div>
					    </div>
						<div class="col-md-1">Sabado
							  <div class="input-group">
							   {!! Form::checkbox('Dia6', 1, false, ['onclick' => 'seleccionarDia();', 'id' => 'Dia6']) !!} 
							   </div>
						</div>
						<div class="col-md-1">Domingo
							  <div class="input-group">
							   {!! Form::checkbox('Dia7', 1, false, ['onclick' => 'seleccionarDia();', 'id' => 'Dia7']) !!} 
							    </div>
						</div>
							  
					</div>

			 </div>
				        
			</div>
		</div>


			<!-- tercer calendario mensual -->
				<div class="panel panel-default">
			        <div class="panel-body">
				        <h4 class="panel-title"></h4>
				          <a data-toggle="collapse" data-parent="#accordion" href="#CalendarioMes"><?php echo "<img src=http://".$_SERVER["HTTP_HOST"]."/images/calendarioMes.png style='width:60px; height:50px;'></a></li></a></li>"?></a><b>Programación Mensual</b>
			        <div id="CalendarioMes" class="panel-collapse collapse  ">
			           <div class="form-group" id='test'>
					         {!!Form::label('tareaFechaInicioPlanTrabajoAlertaMes', 'F.Inicio', array('class' => 'col-sm-1 control-label')) !!}
					       <div class="col-sm-11">
					            <div class="input-group">	
					              <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					              </span>
					             {!!Form::text('tareaFechaInicioPlanTrabajoAlertaMes',$fechaMes,['class'=> 'form-control','placeholder'=>'Ingrese la fecha de inicio','style'=>'width:100%;,right'])!!}
					            </div>
					         </div>
					    </div>

			          <!-- panel para el tercer  Hora  -->
			        <div class="form-group" id='test'>
					         {!!Form::label('tareaHoraPlanTrabajoAlertaMes', 'Hora de Alerta', array('class' => 'col-sm-1 control-label')) !!}
					      <div class="col-sm-11">
					        <div class="input-group">	
					              <span class="input-group-addon">
					                <i class="fa fa-calendar"></i>
					              </span>
					             {!!Form::text('tareaHoraPlanTrabajoAlertaMes',$horaMes,['class'=> 'form-control','placeholder'=>'Ingrese la hora de inicio','style'=>'width:100%;,right'])!!}
					         </div>
					     </div>
					  </div>


					  <!-- todos los checkbox para el tercer calendario mensual -->
					  <div class="form-group" id='test'>
				         {!!Form::label('tareaMesesPlanTrabajoAlerta', 'Meses del Año', array('class' => 'col-sm-12 control-label')) !!}
				    </div>
					<div class="row">
						    <div class="col-md-1">Enero
								    <div class="input-group">
								        {!! Form::checkbox('Mes1', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes1']) !!} 

								        {!!Form::hidden('tareaMesesPlanTrabajoAlerta','1,2,3,4,5,6,7,8,9,10,11,12,', array('id' => 'tareaMesesPlanTrabajoAlerta')) !!}
								    </div>
							</div>	
							<div class="col-md-1">Febrero
								    <div class="input-group">
								         {!! Form::checkbox('Mes2', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes2']) !!} 
								    </div>
							</div>
							<div class="col-md-1">Marzo
								     <div class="input-group">
								          {!! Form::checkbox('Mes3', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes3']) !!} 
								     </div>
							</div>
							<div class="col-md-1">Abril
								  <div class="input-group">
								   {!! Form::checkbox('Mes4', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes4']) !!} 
								   </div>
							</div>
							<div class="col-md-1">Mayo
								  <div class="input-group">
								   {!! Form::checkbox('Mes5', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes5']) !!} 
								   </div>
						    </div>
							<div class="col-md-1">Junio
								  <div class="input-group">
								   {!! Form::checkbox('Mes6', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes6']) !!} 
								    </div>
							</div>
							  
					</div>

					<!-- orden para el calendario segunda parte de checkbox -->
					<div class="row">
						    <div class="col-md-1">Julio
								    <div class="input-group">
								        {!! Form::checkbox('Mes7', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes7']) !!} 
								    </div>
							</div>	
							<div class="col-md-1">Agosto
								    <div class="input-group">
								         {!! Form::checkbox('Mes8', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes8']) !!} 
								    </div>
							</div>
							<div class="col-md-1">Septiembre
								     <div class="input-group">
								          {!! Form::checkbox('Mes9', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes9']) !!} 
								     </div>
							</div>
							<div class="col-md-1">Octubre
								  <div class="input-group">
								   {!! Form::checkbox('Mes10', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes10']) !!} 
								   </div>
							</div>
							<div class="col-md-1">Noviembre 
								  <div class="input-group">
								   {!! Form::checkbox('Mes11', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes11']) !!} 
								   </div>
						    </div>
							<div class="col-md-1">Diciembre
								  <div class="input-group">
								   {!! Form::checkbox('Mes12', 1, true, ['onclick' => 'seleccionarMes();', 'id' => 'Mes12']) !!} 
								   </div>

							</div>
							  
					</div>
			        
			      	</div>

			      	</div>

				</div>
			</div>

			</div>
			</div>
			</div>



			</fieldset>


@if(isset($plantrabajoalerta))
   @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
    @else
      {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
    @endif
  @else
    {!!Form::submit('Aceptar',["class"=>"btn btn-primary"])!!}
  @endif

 {!! Form::close() !!}

			</div>



			



</div>


<script>
    CKEDITOR.replace(('correoMensajePlanTrabajoAlerta'), {
        fullPage: true,
        allowedContent: true
      }); 


    $('#tareaFechaInicioPlanTrabajoAlertaDia').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    $('#tareaFechaInicioPlanTrabajoAlertaSemana').datetimepicker(({
      format: "YYYY-MM-DD"
    }));
    $('#tareaFechaInicioPlanTrabajoAlertaMes').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    $('#tareaHoraPlanTrabajoAlertaDia').datetimepicker(({
	   	format: "HH:mm"
    }));
    $('#tareaHoraPlanTrabajoAlertaSemana').datetimepicker(({
	   	format: "HH:mm"
    }));
    $('#tareaHoraPlanTrabajoAlertaMes').datetimepicker(({
	   	format: "HH:mm"
    }));


    function seleccionarDia()
    {
    	
    	var dias = '';
    	for(var i = 1; i <= 7; i++)
    	{
    		if($("#Dia"+i).prop('checked') == true)
    			dias += i+',';
    	}
    	 $('#tareaDiasPlanTrabajoAlerta').val(dias);

    }

    function seleccionarMes()
    {
    	var Meses = '';
    	for(var j = 1; j <= 12; j++)
    	{
    		if($("#Mes"+j).prop('checked') == true)

    			Meses += j+',';

    	}
    	 $('#tareaMesesPlanTrabajoAlerta').val(Meses);

    }



function seleccionarEstado()
    {
    	var Estados = '';
    	for(var t = 1; t <= 3; t++)
    	{
    		if($("#Estado"+t).prop('checked') == true)
    			Estados += t+',';

    	}
    	 $('#filtroEstadosPlanTrabajoAlerta').val(Estados);

    }



</script>
@stop


