@extends('layouts.formato')

@section('contenido')
	{!!Form::model($ausentismoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($ausentismoS as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Ausentismos</td>
							</tr>
							<tr>
								<td>Empleado</td>
								<td>{{$dato->nombreCompletoTercero}}</td>
							</tr>
							<tr>
								<td>Descripci&#243;n</td>
								<td>{{$dato->nombreAusentismo}}</td>
							</tr>
							<tr>
								<td>Tipo de Ausencia</td>
								<td>{{$dato->tipoAusentismo}}</td>  
							</tr>
							<tr>
								<td>Fecha Elaboraci&#243;n</td>
								<td>{{$dato->fechaElaboracionAusentismo}}</td>
							</tr>
							<tr>
								<td>Fecha Inicio</td>
								<td>{{$dato->fechaInicioAusentismo}}</td>
							</tr>
							<tr>
								<td>Fecha Fin</td>
								<td>{{$dato->fechaFinAusentismo}}</td>
							</tr>
							<tr>
								<td>D&#237;as</td>
								<td>{{$dato->diasAusentismo	}}</td>
							</tr>

							<tr>
								<td>Soporte de la Ausencia</td>
								<td>
							<?php
							// Se hace un substr para validar la extencion del archivo tomando desde el "punto".
							// Si es un pdf o un word va a devolver un mensaje donde dice Archivo Adjunto.
								if (substr($dato->archivoAusentismo, -4) === ".pdf" or (substr($dato->archivoAusentismo, -5)) === ".docx")
									{
										echo'Archivo Adjunto';
									} 
								 else
								 	{
								 		// Si no es un archivo PDF o Word, el sistema mostrara la Imagen 
								 		echo '<img style="width:60%; height:60%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$dato->archivoAusentismo.'"';
								 	}
							?>
								</td>
							</tr>

						
						</thead>
					</table>
				    @endforeach	
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop