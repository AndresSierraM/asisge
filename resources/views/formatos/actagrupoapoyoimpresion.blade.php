@extends('layouts.formato')

@section('contenido')
	{!!Form::model($actagrupoapoyo)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($actagrupoapoyo as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Acta de Reunion Grupo Apoyo</td>
							</tr>
							<tr>
								<td>Grupo de Apoyo</td>
								<td>{{$dato->nombreGrupoApoyo}}</td>
							</tr>
							<tr>
								<td>Fecha de Reunion</td>
								<td>{{$dato->fechaActaGrupoApoyo}}</td>
							</tr>
							<tr>
								<td>Hora Inicio</td>
								<td>{{$dato->horaInicioActaGrupoApoyo}}</td>
							</tr>
							<tr>
								<td>Hora Fin</td>
								<td>{{$dato->horaFinActaGrupoApoyo}}</td>
							</tr>
							
						</thead>
					</table>
				    @endforeach
				    <table  class="table table-striped table-bordered" width="100%">
				      <thead>
				      <tr>
				        <td>Participantes</td>
				       </tr>
				       <tr>
				        <td>Empleados</td>
				        <td>Firma</td>
				       </tr>
				      </thead>
				      <tbody>
				       @foreach($actagrupoapoyotercero as $dato)
				       <tr>
				        <td>{{$dato->nombreCompletoTercero}}</td>
				        <td><?php echo '<img style="width:50%; height:50%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$dato->firmaActaGrupoApoyoTercero.'"';?></td>
				       </tr>
				       @endforeach
				      </tbody>
				     </table>
				     <!-- Nuevo requerimiento, Temas tratados-->
				      <table  class="table table-striped table-bordered" width="100%">
				      <thead>
				      <tr>
				        <td>Temas Tratados</td>
				       </tr>
				       <tr>
				        <td>Tema</td>
				        <td>Desarrollo del Tema</td>
				        <td>Responsable</td>
				        <td>Observaciones</td>
				       </tr>
				      </thead>
				      <tbody>
				       @foreach($actagrupoapoyotema as $dato)
				       <tr>
				        <td>{{$dato->temaActaGrupoApoyoTema}}</td>
				        <td>{{$dato->desarrolloActaGrupoApoyoTema}}</td>
				        <td>{{$dato->nombreCompletoTercero}}</td>
				        <td>{{$dato->observacionActaGrupoApoyoTema}}</td>
				       </tr>
				       @endforeach
				      </tbody>
				     </table>
				     @foreach($actagrupoapoyo as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td>Observaciones</td>
							</tr>
							<tr>
								<td><?php echo $dato->observacionActaGrupoApoyo;?></td>
							</tr>

						</thead>
					</table>
				    @endforeach

				     <table  class="table table-striped table-bordered" width="100%">
				      <thead>
				       <tr>
				        <td>Actividad</td>
				        <td>Responsable</td>
				        <td>Documento</td>
				        <td>Fecha Planceacion</td>
				        <td>Recurso Planeacion</td>
				        <td>Fecha Ejecucion</td>
				        <td>Recurso Ejecucion</td>
				        <td>Observacion</td>
				       </tr>
				      </thead>
				      <tbody>
				       @foreach($actagrupoapoyodetalle as $dato)
				       <tr>
				        <td>{{$dato->actividadGrupoApoyoDetalle}}</td>
				        <td>{{$dato->nombreCompletoTercero}}</td>
				        <td>{{$dato->nombreDocumentoSoporte}}</td>
				        <td>{{$dato->fechaPlaneadaActaGrupoApoyoDetalle}}</td>
				        <td>{{$dato->recursoPlaneadoActaGrupoApoyoDetalle}}</td>
				        <td>{{$dato->fechaEjecucionGrupoApoyoDetalle}}</td>
				        <td>{{$dato->recursoEjecutadoActaGrupoApoyoDetalle}}</td>
				        <td>{{$dato->observacionGrupoApoyoDetalle}}</td>
				       </tr>
				       @endforeach
				      </tbody>
				     </table>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop