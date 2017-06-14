@extends('layouts.formato')

@section('contenido')
	{!!Form::model($examenmedicoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($examenmedicoS as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Examenes Medicos</td>
							</tr>
							<tr>
								<td>Empleado</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							<tr>
								<td>Cargo</td>
								<td>{{$dato->nombreCargo}}</td>
							</tr>
							<tr>
								<td>Fecha Elaboraci&#243;n</td>
								<td>{{$dato->fechaExamenMedico}}</td>
							</tr>
							<tr>
								<td>Tipo de Examen</td>
								<td>{{$dato->tipoExamenMedico}}</td>
							</tr>
						</thead>
					</table>

					   <!-- Multiregistro-->
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
			     			<tr>
				     			<td><b>Examen</b></td> 
								<td><b>Resultado</b></td>
								<td><b>Evidencia Fotogr&#225;fica</b></td>
								<td><b>Observaci&#243;n</b></td>
							</tr>
					      </thead>
					       <tbody>
					         @foreach($examenmedicodetalles as $detalle)
						       <tr>
						        <td>{{$detalle->nombreTipoExamenMedico}}</td>
						        <td>{{$detalle->resultadoExamenMedicoDetalle}}</td>
						        <td><?php echo '<img style="width:60%; height:60%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$detalle->fotoExamenMedicoDetalle.'"';?></td>
						        <td>{{$detalle->observacionExamenMedicoDetalle}}</td>

						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				    @endforeach	
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop