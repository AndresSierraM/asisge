@extends('layouts.formato')

@section('contenido')

	{!!Form::model($accidente)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Plan de Trabajo</td>
							</tr>
						</thead>
					</table>

					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Investigaci&oacute;n de Accidentes</td>
							</tr>
						</thead>
					</table>
					<table  class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<td>&nbsp;</td>
								<td>Presupuesto</td>
								<td>Costo Real</td>
								<td>Cumplimiento</td>
								<td>Responsable</td>
								<td>Enero</td>
								<td>Febrero</td>
								<td>Marzo</td>
								<td>Abril</td>
								<td>Mayo</td>
								<td>Junio</td>
								<td>Julio</td>
								<td>Agosto</td>
								<td>Septiembre</td>
								<td>Octubre</td>
								<td>Noviembre</td>
								<td>Diciembre</td>
							</tr>
						</thead>
						<tbody>
							@foreach($accidente as $dato)
							<tr>
								<td>{{$dato->nombreCompletoTercero}}</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>{{$dato->enero}}</td>
								<td>{{$dato->febrero}}</td>
								<td>{{$dato->marzo}}</td>
								<td>{{$dato->abril}}</td>
								<td>{{$dato->mayo}}</td>
								<td>{{$dato->junio}}</td>
								<td>{{$dato->julio}}</td>
								<td>{{$dato->agosto}}</td>
								<td>{{$dato->septiembre}}</td>
								<td>{{$dato->octubre}}</td>
								<td>{{$dato->noviembre}}</td>
								<td>{{$dato->diciembre}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>


				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop