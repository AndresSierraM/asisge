@extends('layouts.formato')

@section('contenido')
	{!!Form::model($entregaelementoproteccion)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($entregaelementoproteccion as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Entrega Elementos Proteccion</td>
							</tr>
							<tr>
								<td>Empleado</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							<tr>
								<td>Firma</td>
								<td><?php echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$dato->firmaTerceroEntregaElementoProteccion.'"';?></td>
							</tr>
							<tr>
								<td>Fecha Entrega</td>
								<td>{{$dato->fechaEntregaElementoProteccion}}</td>
							</tr>
						</thead>
					</table>
				    @endforeach
				     <table  class="table table-striped table-bordered" width="100%">
				      <thead>
				       <tr>
				        <td>Elemento</td>
				        <td>Cantidad</td>
				       </tr>
				      </thead>
				      <tbody>
				       @foreach($entregaelementoproteccionDetalle as $dato)
				       <tr>
				        <td>{{$dato->nombreElementoProteccion}}</td>
				        <td>{{$dato->cantidadEntregaElementoProteccionDetalle}}</td>
				       </tr>
				       @endforeach
				      </tbody>
				     </table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop