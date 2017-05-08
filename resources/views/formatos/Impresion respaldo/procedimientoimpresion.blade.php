@extends('layouts.formato')

@section('contenido')

	{!!Form::model($procedimiento)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1300px;">
				<div class="panel-body" >
					@foreach($procedimiento as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Procedimiento</td>
							</tr>
							<tr>
								<td>Proceso</td>
								<td>{{$dato->nombreProceso}}</td>
							</tr>
							<tr>
								<td>Procedimiento</td>
								<td>{{$dato->nombreProcedimiento}}</td>
							</tr>
							<tr>
								<td>Fecha Elaboracion</td>
								<td>{{$dato->fechaElaboracionProcedimiento}}</td>
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
									{{$dato->objetivoProcedimiento}}
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>
									Alcance
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{$dato->alcanceProcedimiento}}
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>
									Responsabilidades
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{$dato->responsabilidadProcedimiento}}
								</td>
							</tr>
						</tbody>
					</table>

		            @endforeach
		            <table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>Actividad</td>
								<td>Responsable</td>
								<td>Documento y/o Registro</td>
								
							</tr>
						</thead>
						<tbody>
							@foreach($procedimientoDetalle as $dato)
							<tr>
								<td>{{$dato->actividadProcedimientoDetalle}}</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>{{$dato->nombreDocumentoSoporte}}</td>
								
							</tr>
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop