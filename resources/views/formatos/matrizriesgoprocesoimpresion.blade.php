@extends('layouts.formato')

@section('contenido')
	{!!Form::model($MatrizRiesgoProcesoEncabezado)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1750px;">
				<div class="panel-body" >
					@foreach($MatrizRiesgoProcesoEncabezado as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Matriz de Riesgo por Proceso</td>
							</tr>
							<tr>
								<td>Fecha Elaboraci&oacute;n</td>
								<td>{{$encabezado->fechaMatrizRiesgoProceso}}</td>
							</tr>
							<tr>
								<td>Responsable</td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>
								
							</tr>												
							<tr>
								<td>Proceso</td>
								<td>{{$encabezado->nombreProceso}}</td>								
							</tr>
						</thead>
					</table>
				    @endforeach
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
					     			<th>Descripci&oacute;n del Riesgo</th>
									<th>Efecto Posible</th>
									<th>Frecuencia</th>
									<th>Impacto</th>
									<th>Nivel Valor</th>
									<th>Interpretaci&oacute;n Valorac&oacute;n</th>
									<th>Acciones</th>
									<th>Descripci&oacute;n Acci&oacute;n</th>
									<th>Responsable Acci&oacute;n</th>
									<th>Seguimiento</th>
									<th>Fecha Seguimiento</th>
									<th>Fecha Cierre</th>
									<th>Eficaz</th>
						       </tr>
					      </thead>
					      <tbody>
						      @foreach($MatrizRiesgoProcesoDetalle as $detalle)
						       	<tr>
							        <td>{{$detalle->descripcionMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->efectoMatrizRiesgoProcesoDetalle}}</td>
							        <td>
							        	{{($detalle->frecuenciaMatrizRiesgoProcesoDetalle == 3 ? 'Alta' : ($detalle->frecuenciaMatrizRiesgoProcesoDetalle == 2 ? 'Media' : ($detalle->frecuenciaMatrizRiesgoProcesoDetalle == 1 ? 'Baja' : '' )))}}
            						</td>
							        <td>
							        	{{($detalle->impactoMatrizRiesgoProcesoDetalle == 3 ? 'Alta' : ($detalle->impactoMatrizRiesgoProcesoDetalle == 2 ? 'Media' : ($detalle->impactoMatrizRiesgoProcesoDetalle == 1 ? 'Baja' : '' )))}}
							        </td>
							        <td>{{$detalle->nivelValorMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->interpretacionValorMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->accionesMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->descripcionAccionMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->nombreCompletoTercero}}</td>
							        <td>{{$detalle->seguimientoMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->fechaSeguimientoMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{$detalle->fechaCierreMatrizRiesgoProcesoDetalle}}</td>
							        <td>{{($detalle->eficazMatrizRiesgoProcesoDetalle == 1 ? 'Sí' : 'No')}}</td>			        
						       	</tr>
						       @endforeach
					      </tbody>
				     </table>
				    
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



