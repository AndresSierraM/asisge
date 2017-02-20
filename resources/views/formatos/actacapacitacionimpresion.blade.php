@extends('layouts.formato')

@section('contenido')

	{!!Form::model($actaCapacitacion)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					@foreach($actaCapacitacion as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Acta de Capacitaciones</td>
							</tr>
							<tr>
								<td>N&uacute;mero</td>
								<td>{{$dato->numeroActaCapacitacion}}</td>
							</tr>
							<tr>
								<td>Fecha</td> 
								<td>{{$dato->fechaElaboracionActaCapacitacion}}</td>
							</tr>
							<tr>
								<td>Plan de Capacitaci&oacute;n</td>
								<td>{{$dato->nombrePlanCapacitacion}}</td>
							</tr>
							<tr>
								<td>Tipo</td>
								<td>{{$dato->tipoPlanCapacitacion}}</td>
							</tr>
							<tr>	
								<td>Responsable</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							<tr>	
								<td>Fecha Inicio</td>
								<td>{{$dato->fechaInicioPlanCapacitacion}}</td>
							</tr>
							<tr>	
								<td>Fecha Fin</td>
								<td>{{$dato->fechaFinPlanCapacitacion}}</td>
							</tr>
							
						</thead>
					</table>

		            <table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>
									Objetivos
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{$dato->objetivoPlanCapacitacion}}
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>
									Personal Involucrado
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{$dato->personalInvolucradoPlanCapacitacion}}
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>
									Metodo
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{$dato->metodoEficaciaPlanCapacitacion}}
								</td>
							</tr>
						</tbody>
					</table>
					@endforeach
					<table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>Descripci&oacute;n</td>
								<td>Capacitador</td>
								<td>Fecha</td>
								<td>Hora</td>
								<td>Dictada</td>
								<td>Cumple Objetivo</td>
							</tr>
						</thead>
						<tbody>
							@foreach($planCapacitacionTema as $dato)
							<tr>
								<td>{{$dato->nombrePlanCapacitacionTema}}</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>{{$dato->fechaPlanCapacitacionTema}}</td>
								<td>{{$dato->horaPlanCapacitacionTema}}</td>
								<td>{{($dato->dictadaPlanCapacitacionTema == 1 ? 'Sí' : 'No')}}</td>
								<td>{{($dato->cumpleObjetivoPlanCapacitacionTema == 1 ? 'Sí' : 'No')}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>Asistente</td>
								<td>Cargo</td>
							</tr>
						</thead>
						<tbody>
							@foreach($actaCapacitacionAsistente as $dato)
							<tr>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>{{$dato->nombreCargo}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop