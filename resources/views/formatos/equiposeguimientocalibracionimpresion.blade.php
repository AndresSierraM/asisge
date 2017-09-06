@extends('layouts.formato')

@section('contenido')
	{!!Form::model($EquipoSeguimientoCalibracionEncabezadoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1750px;">
				<div class="panel-body" >
					@foreach($EquipoSeguimientoCalibracionEncabezadoS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center"><b>Calibraci&#243;n de Equipos de Seguimiento y medici&#243;n</b></td>
							</tr>
							<tr>
								<td><b>Fecha</b></td>
								<td>{{$encabezado->fechaEquipoSeguimientoCalibracion}}</td>
							</tr>
							<tr>
								<td><b>Equipo</b></td>
								<td>{{$encabezado->nombreEquipoSeguimiento}}</td>
								
							</tr>												
							<tr>
								<td><b>Responsable</b></td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td><b>C&#243;digo</b></td>
								<td>{{$encabezado->identificacionEquipoSeguimientoDetalle}}</td>								
							</tr>
							<tr>
								<td><b>Proveedor</b></td>
								<td>{{$encabezado->NombreCompletoTerceroProveedor}}</td>								
							</tr>
							<tr>
								<td><b>Error Encontrado</b></td>
								<td>{{$encabezado->errorEncontradoEquipoSeguimientoCalibracion}}</td>								
							</tr>
							<tr>
								<td><b>Resultado</b></td>
								<td>{{$encabezado->resultadoEquipoSeguimientoCalibracion}}</td>								
							</tr>
							</tr>
							<tr>
								<td><b>Acci&#243;n a tomar</b></td>
								<td>{{$encabezado->accionEquipoSeguimientoCalibracion}}</td>								
							</tr>
						@endforeach
						
							<tr>
								<td><b>Adjuntos</b></td>
							@foreach($adjuntoCalibracion as $Adjunto)
								<td>
									<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($Adjunto->rutaEquipoSeguimientoCalibracionArchivo, -4) === ".pdf" or (substr($Adjunto->rutaEquipoSeguimientoCalibracionArchivo, -5)) === ".docx" or (substr($Adjunto->rutaEquipoSeguimientoCalibracionArchivo, -5) === ".pptx"))
									{
										echo' <style="width:60%; height:60%;><b>Archivo Adjunto</b>';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:60%; height:100%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$Adjunto->rutaEquipoSeguimientoCalibracionArchivo.'"';
								 	}
							
							?>
							@endforeach
								</td>								
							</tr>	
						</thead>
					</table>
				    
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



