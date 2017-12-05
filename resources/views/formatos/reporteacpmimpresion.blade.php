@extends('layouts.formato')

@section('contenido')

	{!!Form::model($reporteACPMEncabezado)!!}
	<html lang="es" style="overflow-y: auto;">
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($reporteACPMEncabezado as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center" style=" background-color:#337ab7; color:white;">Reporte ACPM</td>

								<!-- Registro y seguimiento de acciones correctivas, preventivas y de mejora -->
							</tr>
							<tr>
								<td>N&uacute;mero</td>
								<td>{{$encabezado->numeroReporteACPM}}</td>
							</tr>
							<tr>
								<td>Fecha Inicio</td>
								<td>{{$encabezado->fechaElaboracionReporteACPM}}</td>
							</tr>
							<tr>
								<td>Descripci&oacute;n</td>
								<td>{{$encabezado->descripcionReporteACPM}}</td>
							</tr>							
					@endforeach		
						</thead>
					</table>

		            
					<table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr style=" background-color:#848484; color:white;">
								<td>N°</td>
								<td>Fecha Reporte</td>
								<td>Proceso</td>
								<td>Fuente</td>
								<td>Tipo</td>
								<td>Descripci&oacute;n no Conformidad</td>
								<td>An&aacute;lisis Causa</td>
								<td>Correcci&oacute;n</td>
								<td>Responsable</td>
								<td>Plan de Acci&oacute;n</td>
								<td>Responsable</td>
								<td>Fecha Estimada Cierre</td>
								<td>Estado Actual</td>
								<td>Fecha Cierre</td>
								<td>¿Eficaz?</td>
							</tr>
						</thead>
						<tbody>
							@foreach($reporteACPMDetalle as $dato)
							<tr>
								<td>{{$dato->ordenReporteACPMDetalle}}</td>
								<td>{{$dato->fechaReporteACPMDetalle}}</td>
								<td>{{$dato->nombreProceso}}</td>
								<td>{{$dato->nombreModulo}}</td>
								<td>{{($dato->tipoReporteACPMDetalle == 'Correctiva'? 'Correctiva' : ($dato->tipoReporteACPMDetalle == 'Preventiva' ? 'Preventiva' : 'Mejora'))}}</td>
								<td>{{$dato->descripcionReporteACPMDetalle}}</td>
								<td>{{$dato->analisisReporteACPMDetalle}}</td>
								<td>{{$dato->correccionReporteACPMDetalle}}</td>
								<td>{{$dato->ResponsableCoreccion}}</td>
								<td>{{$dato->planAccionReporteACPMDetalle}}</td>
								<td>{{$dato->ResponsablePlanAccion}}</td>
								<td>{{$dato->fechaEstimadaCierreReporteACPMDetalle}}</td>
								<td>{{$dato->estadoActualReporteACPMDetalle}}</td>
								<td style="width: 100px;">{{$dato->fechaCierreReporteACPMDetalle}}</td>
								<td>{{($dato->eficazReporteACPMDetalle == 1 ? 'S&iacute;' : 'No')}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop