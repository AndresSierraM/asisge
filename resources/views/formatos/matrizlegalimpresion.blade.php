@extends('layouts.formato')

@section('contenido')

	{!!Form::model($matrizLegal)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					<table class="table" style="width:800px">
						<thead>
							<tr>
								<th>
									Fecha Elaboraci&oacute;n:
								</th>
								<th>
									{{$matrizLegal->fechaElaboracionMatrizLegal}}
								</th>
								<th>
									Matriz Legal:
								</th>
								<th>
									{{$matrizLegal->nombreMatrizLegal}}
								</th>
								<th>
									Origen:
								</th>
								<th>
									{{$matrizLegal->origenMatrizLegal}}
								</th>
							</tr>
						</thead>
					</table>
		            <table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<th>Tipo de norma</th>
								<th>Art&iacute;culos Aplicables</th>
								<th>Expedida por</th>
								<th>Exigencia</th>
								<th>Fuente</th>
								<th>Medio</th>
								<th>Persona</th>
								<th>Herramienta de seguimiento</th>
								<th>Se cumple</th>
								<th>Fecha verificaci&oacute;n</th>
								<th>Acci&oacute;n / Evidencia</th>
								<th>Control a implementar</th>
							</tr>
						<thead>
						<tbody>
						@foreach($matrizLegalDetalle as $dato)
							<tr>
								<td>{{$dato->nombreTipoNormaLegal}}</td>
								<td>{{$dato->articuloAplicableMatrizLegalDetalle}}</td>
								<td>{{$dato->nombreExpideNormaLegal}}</td>
								<td>{{$dato->exigenciaMatrizLegalDetalle}}</td>
								<td>{{$dato->fuenteMatrizLegalDetalle}}</td>
								<td>{{$dato->medioMatrizLegalDetalle}}</td>
								<td>{{$dato->personaMatrizLegalDetalle}}</td>
								<td>{{$dato->herramientaSeguimientoMatrizLegalDetalle}}</td>
								<td>{{($dato->cumpleMatrizLegalDetalle == 1 ? 'Sí' : 'No')}}</td>
								<td>{{$dato->fechaVerificacionMatrizLegalDetalle}}</td>
								<td>{{$dato->accionEvidenciaMatrizLegalDetalle}}</td>
								<td>{{$dato->controlAImplementarMatrizLegalDetalle}}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop