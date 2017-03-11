@extends('layouts.formato')

@section('contenido')

	{!!Form::model($programa)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					@foreach($programa as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Programa</td>
							</tr>
							<tr>
								<td>Programa</td>
								<td>{{$dato->nombrePrograma}}</td>
							</tr>
							<tr>
								<td>Fecha de Elaboracion</td>
								<td>{{$dato->fechaElaboracionPrograma}}</td>
							</tr>
							<tr>
								<td>Clasificacion de Riesgo</td>
								<td>{{$dato->nombreClasificacionRiesgo}}</td>
							</tr>
							<tr>
								<td>Alcance</td>
								<td>{{$dato->alcancePrograma}}</td>
							</tr>
							<tr>
								<td>Objetivo</td>
								<td>{{$dato->nombreCompaniaObjetivo}}</td>
							</tr>
							<tr>
								<td>Objetivo Especifico</td>
								<td>{{$dato->objetivoEspecificoPrograma}}</td>
							</tr>
							<tr>
								<td>Elaborado Por</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							
						</thead>
					</table>
					@endforeach
		            <table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>Actividad</td>
								<td>Responsable</td>
								<td>Documento</td>
								<td>Fecha Planeada</td>
								<td>Recurso Planeado</td>
								<td>Fecha Ejecutada</td>
								<td>Recurso Ejecutado</td>
								<td>Observacion</td>
							</tr>
						</thead>
						<tbody>
							@foreach($programaDetalle as $dato)
							<tr>
								<td>{{$dato->actividadProgramaDetalle}}</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>{{$dato->nombreDocumentoSoporte}}</td>
								<td>{{$dato->fechaPlaneadaProgramaDetalle}}</td>
								<td>{{$dato->recursoPlaneadoProgramaDetalle}}</td>
								<td>{{$dato->fechaEjecucionProgramaDetalle}}</td>
								<td>{{$dato->recursoEjecutadoProgramaDetalle}}</td>
								<td>{{$dato->observacionProgramaDetalle}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop	