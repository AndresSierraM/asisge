@extends('layouts.formato')

@section('contenido')
	{!!Form::model($planAuditoriaS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($planAuditoriaS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Plan de Auditor&#237;a</td>
							</tr>
							<tr>
								<td>N&#250;mero Auditor&#237;a</td>
								<td>{{$encabezado->numeroPlanAuditoria}}</td>
							</tr>
							<tr>
								<td>Fecha Inicio</td>
								<td>{{$encabezado->fechaInicioPlanAuditoria}}</td>
								
							</tr>
							<tr>
								<td>Fecha Finalizaci&#243;n</td>
								<td>{{$encabezado->fechaFinPlanAuditoria}}</td>
							</tr>
							<tr>
								<td>Organismo</td>
								<td>{{$encabezado->organismoPlanAuditoria}}</td>
							</tr>
							<tr>
								<td>Auditor Líder</td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>
							</tr>
						</thead>
					</table>
					@endforeach
					 <!-- Multiregistro Acompañantes  -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td colspan="2"><b>Detalles</b></td>
					     			</tr>
					     			<tr>
					     				<td><b>Auditores Acompañantes</b></td>
					     			</tr>
									<tr>
										<td><b>Auditores</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($PlanAuditoriaAcompananteS as $resultado)
						       <tr>
						        <td>{{$resultado->nombreCompletoTercero}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				      <!-- Multiregistro Notificidos  -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td><b>Otros Notificados</b></td>
					     			</tr>
									<tr>
										<td><b>Notificados</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($PlanAuditoriaNotificadoS as $notificado)
						       <tr>
						        <td>{{$notificado->nombreCompletoTercero}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				     <!-- Pestaña Objetivos -->
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td><b>Objetivos de la Auditor&#237;a</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($planAuditoriaS as $encabezado)
						       <tr>
						        <td><?php echo $encabezado->objetivoPlanAuditoria;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				      <!-- Pestaña Alcance auditoria -->
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td><b>Alcance de la Auditor&#237;a</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($planAuditoriaS as $encabezado)
						       <tr>
						        <td><?php echo $encabezado->alcancePlanAuditoria;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				      <!-- Pestaña creterio -->
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td><b>Criterio de la Auditor&#237;a</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($planAuditoriaS as $encabezado)
						       <tr>
						        <td><?php echo $encabezado->criterioPlanAuditoria;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				       <!-- Pestaña Experiencia -->
				        <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				    
			     			<tr>
				     			<td><b>Agenda de la Auditor&#237;a</b></td>

			     			</tr>
					       	<tr>
								<td><b>Proceso</b></td>
								<td><b>Auditado</b></td>
								<td><b>Auditor</b></td>
								<td><b>Fecha</b></td>
								<td><b>Hora Inicio</b></td>
								<td><b>Hora Fin</b></td>
								<td><b>Lugar</b></td>
							</tr>
						   <tbody>
					         @foreach($planauditoriaagendaS as $agenda)
						       <tr>
						        <td>{{$agenda->nombreProceso}}</td>
						        <td>{{$agenda->auditado}}</td>
						        <td>{{$agenda->auditor}}</td>
						        <td>{{$agenda->fechaPlanAuditoriaAgenda}}</td>
						        <td>{{$agenda->horaInicioPlanAuditoriaAgenda}}</td>
						        <td>{{$agenda->horaFinPlanAuditoriaAgenda}}</td>
						        <td>{{$agenda->lugarPlanAuditoriaAgenda}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
						
					      </thead>
				     </table>

				     <!-- Pestaña Recursos necesarios  -->
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td><b>Recursos Necesarios</b></td>
				     			</tr>
				     </thead>
					      <tbody>
						     @foreach($planAuditoriaS as $encabezado)
						       <tr>
						        <td><?php echo $encabezado->recursosPlanAuditoria;?></td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				     <!-- Pestaña Observaciones  -->
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td><b>Observaciones</b></td>
				     			</tr>
				     </thead>
					      <tbody>
				     @foreach($planAuditoriaS as $encabezado)
						       <tr>
						        <td><?php echo $encabezado->observacionesPlanAuditoria;?></td>
						       </tr>						       
					      </tbody>
				     </table>
				      <!-- Pestaña Aprabacioon Auditoria   -->
				 	    <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td><b>Aprobaci&#243;n Auditor&#237;a</b></td>
					     			</tr>
									<tr>
										<td><b>Aprobaci&#243;n</b></td>
										<td><b></b></td>
									</tr>
									<tr>
										<td><b>Fecha Entrega</b></td>
										<td><b>{{$encabezado->fechaEntregaPlanAuditoria}}</td>
									</tr>
					      	</thead>
				     </table>
				     @endforeach
				    
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



