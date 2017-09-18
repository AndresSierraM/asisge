@extends('layouts.formato')

@section('contenido')
	{!!Form::model($inspeccion)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($inspeccion as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Inspecciones</td>
							</tr>
							<tr>
								<td>Nombre</td>
								<td>{{$dato->nombreTipoInspeccion}}</td>
							</tr>
							<tr>
								<td>Realizada por</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							<tr>
								<td>Firma</td>
								<td><?php echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$dato->firmaRealizadaPorInspeccion.'"';?></td>
							</tr>
							<tr>
								<td>Fecha Elaboración</td>
								<td>{{$dato->fechaElaboracionInspeccion}}</td>
							</tr>
							<tr>
								<td>Centro de Costos</td>
								<td>{{$dato->nombreCentroCosto}}</td>
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
				         <?php echo $dato->observacionesInspeccion;?>
				        </td>
				       </tr>
				      </tbody>
				     </table>
				    @endforeach
				     <table  class="table table-striped table-bordered" width="100%">
					      <thead>
						       <tr>
						        <td>Pregunta</td>
						        <td>Situación identificada</td>
						        <td>Evidencia fotográfica</td>
						        <td>Ubicación</td>
						        <td>Acción de mejora</td>
						        <td>Responsable</td>
						        <td>Fecha</td>
						        <td>Observaciones</td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($inspeccionResumen as $dato)
						       <tr>
						        <td>{{$dato->contenidoTipoInspeccionPregunta}}</td>
						        <td>{{$dato->situacionInspeccionDetalle}}</td>
						        <td><?php echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$dato->fotoInspeccionDetalle.'"';?></td>
						        <td>{{$dato->ubicacionInspeccionDetalle}}</td>
						        <td>{{$dato->accionMejoraInspeccionDetalle}}</td>
						        <td>{{$dato->nombreCompletoTercero}}</td>
						        <td>{{$dato->fechaInspeccionDetalle}}</td>
						        <td>{{$dato->observacionInspeccionDetalle}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop