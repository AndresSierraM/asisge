@extends('layouts.formato')

@section('contenido')
	{!!Form::model($cuadromandoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($cuadromandoS as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Cuadro Mando</td>
							</tr>
							<tr>
								<td>Compa&#241;ia</td>
								<td>{{$dato->nombreCompania}}</td>
							</tr>
							<tr>
								<td>N&#250;mero</td>
								<td>{{$dato->numeroCuadroMando}}</td>
							</tr>
							<tr>
								<td>Objetivo Estrat&#233;gico</td>
								<td>{{$dato->nombreCompaniaObjetivo}}</td> 
							</tr>
							<tr>
								<td>Proceso</td>
								<td>{{$dato->nombreProceso}}</td>
							</tr>
							<tr>
								<td>Objetivos Especificos de los Procesos</td>
								<td>{{$dato->objetivoEspecificoCuadroMando}}</td>
							</tr>
							<tr>
								<td>Nombre del indicador</td>
								<td>{{$dato->indicadorCuadroMando}}</td>
							</tr>
							<tr>
								<td>Definici&#243;n del indicador</td>
								<td>{{$dato->definicionIndicadorCuadroMando}}</td>
							</tr>

							<tr>
								<td>Formula del Indicador</td>
								<td>{{$dato->formulaCuadroMando}}</td>
							</tr>
						</thead>
					</table>
					       <table  class="table table-striped table-bordered" width="100%">
							     	<thead>
						     			<tr>
							     			<td><b>Meta</b></td>
							     		@foreach($cuadromandoS as $datos)
											<td><b>{{$datos->operadorMetaCuadroMando}}</b></td>
											<td><b>{{$datos->valorMetaCuadroMando}}</b></td>
											<td><b>{{$datos->tipoMetaCuadroMando}}</b></td>
										@endforeach
						     			</tr>
							      	</thead>
					     	</table>
					     <table class="table" width="100%">
					     	<tr>
								<td>Frecuencia</td>
								<td>{{$dato->nombreFrecuenciaMedicion}}</td>
							</tr>
							<tr>
								<td>Visualizaci&#243;n</td>
								<td>{{$dato->visualizacionCuadroMando}}</td>
							</tr>
							<tr>
								<td>Responsable Medici&#243;n</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
						</table>
				    @endforeach	
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop