@extends('layouts.formato')

@section('contenido')
	{!!Form::model($ManualGestionEncabezado)!!}
	<!-- Se quema el overflow-y auto apra que salga la barra vertical cuando tiene mucha informacion -->
	<html lang="es" style="overflow-y: auto;">
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($ManualGestionEncabezado as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"  style=" background-color:#337ab7; color:white;">Plan de Emergencias</td>
							</tr>
							<tr>
								<td><b>C&oacute;digo</b></td>
								<td>{{$encabezado->codigoManualGestion}}</td>
							</tr>
							<tr>
								<td><b>Nombre</b></td>
								<td>{{$encabezado->nombreManualGestion}}</td>
								
							</tr>
							<tr>
								<td><b>Fecha Elaboraci&oacute;n</b></td>
								<td>{{$encabezado->fechaManualGestion}}</td>

							</tr>
							<tr>
								<td><b>Empleador</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td><b>Firma</b></td>
								<td><?php echo '<img style="width:20%; height:20%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$encabezado->firmaEmpleadorManualGestion.'"';?></td>
							</tr>						 
						</thead>
					</table>
				@endforeach		
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



