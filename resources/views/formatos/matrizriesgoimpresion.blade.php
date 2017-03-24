@extends('layouts.formato')

@section('contenido')
	{!!Form::model($matrizRiesgo)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:2100px;">
				<div class="panel-body" >
					<table class="table" style="width:500px">
						<thead>
							<tr>
								<th>
									Fecha Elaboraci&oacute;n:
								</th>
								<th>
									{{$matrizRiesgo->fechaElaboracionMatrizRiesgo}}
								</th>
								<th>
									Matriz Riesgo:
								</th>
								<th>
									{{$matrizRiesgo->nombreMatrizRiesgo}}
								</th>
							</tr>
						</thead>
					</table>
		            <table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<th>Proceso/Cargos</th>
								<th>Rutina</th>
								<th>Clasificaci&oacute;n</th>
								<th>Tipo Riesgo</th>
								<th>Descripci&oacute;n</th>
								<th>Efectos salud</th>
								<th>Planta</th>
								<th>Temporal</th>
								<th>Total</th>
								<th>Fuente</th>
								<th>Medio</th>
								<th>Persona</th>
								<th>Nivel deficiencia</th>
								<th>Nivel exposici&oacute;n</th>
								<th>Inter. probabilidad</th>
								<th>Nivel consecuencia</th>
								<th>Inter. riesgo</th>
								<th>Aceptaci&oacute;n riesgo</th>
								<th>Eliminaci&oacute;n</th>
								<th>Sustituaci&oacute;n</th>
								<th>Controles</th>
								<th>Protección Persona</th>
								<th>Evidencia</th>
								<th>Observaciones</th>
							</tr>
						<thead>
						<tbody>
						@foreach($matrizRiesgoDetalle as $dato)
							<tr>
								<td>{{$dato->nombreProceso}}</td>
								<td>{{($dato->rutinariaMatrizRiesgoDetalle == 1 ? 'Sí' : 'No')}}</td>
								<td>{{$dato->nombreClasificacionRiesgo}}</td>
								<td>{{$dato->nombreTipoRiesgo}}</td>
								<td>{{$dato->nombreTipoRiesgoDetalle}}</td>
								<td>{{$dato->nombreTipoRiesgoSalud}}</td>
								<td>{{$dato->vinculadosMatrizRiesgoDetalle}}</td>
								<td>{{$dato->temporalesMatrizRiesgoDetalle}}</td>
								<td>{{$dato->totalExpuestosMatrizRiesgoDetalle}}</td>
								<td>{{$dato->fuenteMatrizRiesgoDetalle}}</td>
								<td>{{$dato->medioMatrizRiesgoDetalle}}</td>
								<td>{{$dato->personaMatrizRiesgoDetalle}}</td>
								<td>{{($dato->nivelDeficienciaMatrizRiesgoDetalle == 10 ? 'Muy Alto' 
									  	: ($dato->nivelDeficienciaMatrizRiesgoDetalle == 6 ? 'Alto'
									  	: ($dato->nivelDeficienciaMatrizRiesgoDetalle == 2 ? 'Medio'
									  	: ($dato->nivelDeficienciaMatrizRiesgoDetalle == 0 ? 'Bajo'
									  	: '' ))))}}</td>
								<td>{{($dato->nivelExposicionMatrizRiesgoDetalle == 4 ? 'Continua' 
									  	: ($dato->nivelExposicionMatrizRiesgoDetalle == 3 ? 'Frecuente'
									  	: ($dato->nivelExposicionMatrizRiesgoDetalle == 2 ? 'Ocasional'
									  	: ($dato->nivelExposicionMatrizRiesgoDetalle == 1 ? 'Esporádica'
									  	: '' ))))}}</td>
								<td>{{$dato->nombreProbabilidadMatrizRiesgoDetalle}}</td>
								<td>{{($dato->nivelConsecuenciaMatrizRiesgoDetalle == 100 ? 'Mortal' 
									  	: ($dato->nivelConsecuenciaMatrizRiesgoDetalle == 60 ? 'Muy Grave'
									  	: ($dato->nivelConsecuenciaMatrizRiesgoDetalle == 25 ? 'Grave'
									  	: ($dato->nivelConsecuenciaMatrizRiesgoDetalle == 10 ? 'Leve'
									  	: '' ))))}}</td>
								<td>{{$dato->nombreRiesgoMatrizRiesgoDetalle}}</td>
								<td>{{$dato->aceptacionRiesgoMatrizRiesgoDetalle}}</td>
								<td>{{$dato->eliminacionMatrizRiesgoDetalle}}</td>
								<td>{{$dato->sustitucionMatrizRiesgoDetalle}}</td>
								<td>{{$dato->controlMatrizRiesgoDetalle}}</td>
								<td>{{$dato->elementoProteccionMatrizRiesgoDetalle}}</td>
								<td>{{$dato->imagenMatrizRiesgoDetalle}}</td>
								<td>{{$dato->observacionMatrizRiesgoDetalle}}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop