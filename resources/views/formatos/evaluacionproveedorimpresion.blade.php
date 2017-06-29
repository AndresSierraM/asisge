@extends('layouts.formato')

@section('contenido')
	{!!Form::model($evaluacionproveedor)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($evaluacionproveedor as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"><b>Evaluación de Proveedor</b></td>
							</tr>
							<tr>
								<td><b>Proveedor</b></td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							<tr>
								<td><b>Fecha Elaboración</b></td>
								<td>{{$dato->fechaElaboracionEvaluacionProveedor}}</td>
							</tr>
                            <tr>
								<td><b>Fecha Inicial</b></td>
								<td>{{$dato->fechaInicialEvaluacionProveedor}}</td>
							</tr>
                            <tr>
								<td><b>Fecha Final</b></td>
								<td>{{$dato->fechaFinalEvaluacionProveedor}}</td>
							</tr>
                            <tr>
								<td><b>Solicitante</b></td>
								<td>{{$dato->name}}</td>
							</tr>
						</thead>
					</table>
					 <table class="table table-striped table-bordered" width="100%">
				      <thead>
				       <tr>
				        <td>
				         <b>Observaciones</b>
				        </td>
				       </tr>
				      </thead>
				      <tbody>
				       <tr>
				        <td>
				         {{$dato->observacionEvaluacionProveedor}}
				        </td>
				       </tr>
				      </tbody>
				     </table>
				    @endforeach
                     <table  class="table table-striped table-bordered" width="100%">
					      <thead>
                                <tr>
                                    <td><b>Resultado</b></td>
                                </tr>
						       <tr>
						       <tr>
						        <td><b>Concepto</b></td>
						        <td><b>Porcentaje</b></td>
						        <td><b>Peso</b></td>
						        <td><b>Resultado</b></td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($evaluacionproveedorresultado as $dato)
						       <tr>
						        <td>{{$dato->descripcionEvaluacionProveedorResultado}}</td>
						        <td>{{$dato->porcentajeEvaluacionProveedorResultado}}</td>
						        <td>{{$dato->pesoEvaluacionProveedorResultado}}</td>
                                <td>{{$dato->resultadoEvaluacionProveedorResultado}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop