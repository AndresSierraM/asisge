@extends('layouts.formato')

@section('contenido')

	{!!Form::model($listaChequeo)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					@foreach($listaChequeo as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Lista Chequeo</td>
							</tr>
							<tr>
								<td>N&uacute;mero</td>
								<td>{{$dato->numeroListaChequeo}}</td>
							</tr>
							<tr>
								<td>Fecha</td>
								<td>{{$dato->fechaElaboracionListaChequeo}}</td>
							</tr>
							<tr>
								<td>Plan de Auditor&iacute;a</td>
								<td>{{$dato->numeroPlanAuditoria}}</td>
							</tr>
							<tr>
								<td>Proceso</td>
								<td>{{$dato->nombreProceso}}</td>
							</tr>
							
							
						</thead>
					</table>

		            @endforeach
					<table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>Orden</td>
								<td>Descripci&oacute;n Pregunta</td>
								<td>¿A qui&eacute;n?</td>
								<td>Respuesta</td>
								<td>Conforme</td>
								<td>Hallazgo</td>
								<td>Observaci&oacute;n</td>
							</tr>
						</thead>
						<tbody>
							@foreach($listaChequeoDetalle as $dato)
							<tr>
								<td>{{$dato->ordenPreguntaListaChequeo}}</td>
								<td>{{$dato->descripcionPreguntaListaChequeo}}</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>{{$dato->respuestaListaChequeoDetalle}}</td>
								<td>{{($dato->conformeListaChequeoDetalle == 1 ? 'Sí' : 'No')}}</td>
								<td>{{$dato->hallazgoListaChequeoDetalle}}</td>
								<td>{{$dato->observacionListaChequeoDetalle}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@foreach($listaChequeo as $dato)
					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>
									Observaciones
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{$dato->observacionesListaChequeo}}
								</td>
							</tr>
						</tbody>
					</table>
					@endforeach
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop