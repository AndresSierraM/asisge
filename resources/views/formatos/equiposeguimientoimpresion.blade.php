@extends('layouts.formato')

@section('contenido')
	{!!Form::model($EquipoSeguimientoEncabezadoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1750px;">
				<div class="panel-body" >
					@foreach($EquipoSeguimientoEncabezadoS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"><b>Equipos de Seguimiento y medici&#243;n</b></td>
							</tr>
							<tr>
								<td><b>Fecha</b></td>
								<td>{{$encabezado->fechaEquipoSeguimiento}}</td>
							</tr>
							<tr>
								<td><b>Equipo</b></td>
								<td>{{$encabezado->nombreEquipoSeguimiento}}</td>
								
							</tr>												
							<tr>
								<td><b>Responsable</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
						</thead>
					</table>
				    @endforeach
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     <tr>
						<th colspan="7"></th>
						<th colspan="2" style="text-align:center;">Rango</th>						
						<th></th>
						<th colspan="2" style="text-align:center;">Capacidad de Trabajo</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>Identificación / Código</th>
						<th >Tipo</th>
						<th>Frecuencia de Calibración</th>
						<th>Fecha Inicial Calibración</th>
						<th>Frecuencia Verificación</th>
						<th>Fecha Inicial Verificación</th>
						<th>Unidad Medida</th>
						<th style="width: 90px;text-align:center;">></th>
						<th style="width: 90px;text-align:center;"><</th>
						<th>Escala</th>
						<th style="width: 90px;text-align:center;">></th>
						<th style="width: 90px;text-align:center;"><</th>						
						<th>Utilización</th>
						<th>Tolerancia (+/-)</th>
						<th>Error Máximo permitido</th>
					</tr>
					      </thead>
					      	<tbody>	
					      	  @foreach($EquipoSeguimientoDetalleS as $detalle)					     
						       	<tr>
							        <td>{{$detalle->identificacionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->tipoEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->NombreFrecuenciaMedicionCalibracion}}</td>
							        <td>{{$detalle->fechaInicioCalibracionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->NombreFrecuenciaMedicionVerificacion}}</td>
							        <td>{{$detalle->fechaInicioVerificacionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->unidadMedidaCalibracionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->rangoInicialCalibracionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->rangoFinalCalibracionEquipoSeguimientoDetalle}}</td>
							   		<td>{{$detalle->escalaCalibracionEquipoSeguimientoDetalle}}</td>							        
							        <td>{{$detalle->capacidadInicialCalibracionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->capacidadFinalCalibracionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->utilizacionCalibracionEquipoSeguimientoDetalle}}</td>	
							        <td>{{$detalle->toleranciaCalibracionEquipoSeguimientoDetalle}}</td>
							        <td>{{$detalle->errorPermitidoCalibracionEquipoSeguimientoDetalle}}</td>								       
						       	</tr>
						       	@endforeach						      
					      	</tbody>
				     </table>
				    
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



