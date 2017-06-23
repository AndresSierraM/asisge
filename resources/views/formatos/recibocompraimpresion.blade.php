@extends('layouts.formato')

@section('contenido')
	{!!Form::model($recibocompra)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($recibocompra as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"><b>Recibo de Compra</b></td>
							</tr>
							<tr>
								<td><b>Número</b></td>
								<td>{{$dato->numeroReciboCompra}}</td>
							</tr>
							<tr>
								<td><b>Orden de Compra</b></td>
								<td>{{$dato->numeroOrdenCompra}}</td>
							</tr>
							<tr>
								<td><b>Fecha Elaboración</b></td>
								<td>{{$dato->fechaElaboracionReciboCompra}}</td>
							</tr>
                            <tr>
								<td><b>Fecha Estimada Orden de Compra</b></td>
								<td>{{$dato->fechaEstimadaOrdenCompra}}</td>
							</tr>
                            <tr>
								<td><b>Fecha Entrega</b></td>
								<td>{{$dato->fechaRealReciboCompra}}</td>
							</tr>
                            <tr>
								<td><b>Proveedor</b></td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
                            <tr>
								<td><b>Solicitante</b></td>
								<td>{{$dato->name}}</td>
							</tr>
                            <tr>
								<td><b>Estado</b></td>
								<td>{{$dato->estadoReciboCompra}}</td>
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
				         {{$dato->observacionReciboCompra}}
				        </td>
				       </tr>
				      </tbody>
				     </table>
				    @endforeach
				     <table  class="table table-striped table-bordered" width="100%">
					      <thead>
                                <tr>
                                    <td><b>Recibo</b></td>
                                </tr>
						       <tr>
						        <td><b>Referencia</b></td>
						        <td><b>Descripción</b></td>
						        <td><b>Cantidad OC</b></td>
						        <td><b>Cantidad Recibo</b></td>
						        <td><b>Tipo de Calidad</b></td>
						        <td><b>Costo OC</b></td>
						        <td><b>Costo Recibo</b></td>
						        <td><b>Valor Total</b></td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($recibocompraproducto as $dato)
						       <tr>
						        <td>{{$dato->referenciaReciboCompraProducto}}</td>
						        <td>{{$dato->descripcionReciboCompraProducto}}</td>
						        <td>{{$dato->cantidadOrdenCompraProducto}}</td>
						        <td>{{$dato->cantidadReciboCompraProducto}}</td>
						        <td>{{$dato->nombreTipoCalidad}}</td>
						        <td>{{$dato->valorUnitarioOrdenCompraProducto}}</td>
                                <td>{{$dato->valorUnitarioReciboCompraProducto}}</td>
						        <td>{{$dato->valorTotalReciboCompraProducto}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
                     <table  class="table table-striped table-bordered" width="100%">
					      <thead>
                                <tr>
                                    <td><b>Resultado</b></td>
                                </tr>
						       <tr>
						       <tr>
						        <td><b>Resultado del Recibo</b></td>
						        <td><b>Orden de Compra</b></td>
						        <td><b>Recibo</b></td>
						        <td><b>Diferencia</b></td>
						        <td><b>Porcentaje</b></td>
						        <td><b>Peso</b></td>
						        <td><b>Resultado</b></td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($recibocompraresultado as $dato)
						       <tr>
						        <td>{{$dato->descripcionReciboCompraResultado}}</td>
						        <td>{{$dato->valorCompraReciboCompraResultado}}</td>
						        <td>{{$dato->valorReciboReciboCompraResultado}}</td>
						        <td>{{$dato->diferenciaReciboCompraResultado}}</td>
						        <td>{{$dato->porcentajeReciboCompraResultado}}</td>
						        <td>{{$dato->pesoReciboCompraResultado}}</td>
                                <td>{{$dato->resultadoReciboCompraResultado}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop