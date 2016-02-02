@extends('layouts.formato')

@section('contenido')

	{!!Form::model($reporteACPM)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Registro y seguimiento de acciones correctivas, preventivas y de mejora</td>
							</tr>
							<tr>
								<td>N&uacute;mero</td>
								<td>{{$reporteACPM->numeroReporteACPM}}</td>
							</tr>
							<tr>
								<td>Fecha</td>
								<td>{{$reporteACPM->fechaElaboracionReporteACPM}}</td>
							</tr>
							<tr>
								<td>Descripci&oacute;n</td>
								<td>{{$reporteACPM->descripcionReporteACPM}}</td>
							</tr>
							
							
						</thead>
					</table>

		            
					<table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
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
								<td>D&iacute;as Atraso</td>
							</tr>
						</thead>
						<tbody>
							@foreach($reporteACPMDetalle as $dato)
							<tr>
								<td>{{$dato->ordenReporteACPMDetalle}}</td>
								<td>{{$dato->fechaReporteACPMDetalle}}</td>
								<td>{{$dato->nombreProceso}}</td>
								<td>&nbsp;</td>
								<td>{{($dato->tipoReporteACPMDetalle == 'C'? 'Correctiva' : ($dato->tipoReporteACPMDetalle == 'P' ? 'Preventiva' : 'Mejora'))}}</td>
								<td>{{$dato->descripcionReporteACPMDetalle}}</td>
								<td>{{$dato->analisisReporteACPMDetalle}}</td>
								<td>{{$dato->correccionReporteACPMDetalle}}</td>
								<td>{{$dato->nombreCompletoResponsableCorrecion}}</td>
								<td>{{$dato->planAccionReporteACPMDetalle}}</td>
								<td>{{$dato->nombreCompletoResponsablePlanAccion}}</td>
								<td>{{$dato->fechaEstimadaCierreReporteACPMDetalle}}</td>
								<td>{{$dato->estadoActualReporteACPMDetalle}}</td>
								<td>{{$dato->fechaCierreReporteACPMDetalle}}</td>
								<td>{{($dato->eficazReporteACPMDetalle == 1 ? 'S&iacute;' : 'No')}}</td>
								<td>{{$dato->diasAtraso}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop