@extends('layouts.formato')

@section('contenido')
	{!!Form::model($EquipoSeguimientoVerificacionEncabezadoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1750px;">
				<div class="panel-body" >
					@foreach($EquipoSeguimientoVerificacionEncabezadoS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"><b>Verificaci&#243;n de Equipos de Seguimiento y medici&#243;n</b></td>
							</tr>
							<tr>
								<td><b>Fecha</b></td>
								<td>{{$encabezado->fechaEquipoSeguimientoVerificacion}}</td>
							</tr>
							<tr>
								<td><b>Equipo</b></td>
								<td>{{$encabezado->nombreEquipoSeguimiento}}</td>
								
							</tr>												
							<tr>
								<td><b>Responsable</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td><b>C&#243;digo</b></td>
								<td>{{$encabezado->identificacionEquipoSeguimientoDetalle}}</td>								
							</tr>
							<tr>
								<td><b>Error Encontrado</b></td>
								<td>{{$encabezado->errorEncontradoEquipoSeguimientoVerificacion}}</td>								
							</tr>
							<tr>
								<td><b>Resultado</b></td>
								<td>{{$encabezado->resultadoEquipoSeguimientoVerificacion}}</td>								
							</tr>
							<tr>
								<td><b>Acci&#243;n a tomar</b></td>
								<td>{{$encabezado->accionEquipoSeguimientoVerificacion}}</td>								
							</tr>	
						</thead>
					</table>
				    @endforeach
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



