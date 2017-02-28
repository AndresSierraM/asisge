@extends('layouts.formato')

@section('contenido')
	{!!Form::model($EvaluacionDesempenio)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($EvaluacionDesempenio as $dato)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Evaluacion Desempeño</td>
							</tr>
							<tr>
								<td>Empleado</td>
								<td>{{$dato->nombreEmpleado}}</td>
							</tr>
							<tr>
								<td>Cargo</td>
								<td>{{$dato->nombreCargo}}</td>
								
							</tr>
							<tr>
								<td>Responsable</td>
								<td>{{$dato->nombreResponsable}}</td>

							</tr>
							<tr>
								<td>Fecha</td>
								<td>{{$dato->fechaElaboracionEvaluacionDesempenio}}</td>
								
							</tr>
							<tr>
								<td>Observacion</td>
								<td><?php echo $dato->observacionEvaluacionDesempenio;?></td>
								
							</tr>
						</thead>
					</table>
				    @endforeach
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td>Responsabilidades</td>
				     			</tr>
						       <tr>
						        <td>Responsabilidad</td>
						        <td>Respuesta</td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($EvaluacionDesempenioResponsabilidad as $dato)
						       <tr>
						        <td>{{$dato->descripcionCargoResponsabilidad}}</td>
						        <td>{{$dato->respuestaEvaluacionResponsabilidad}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				        <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td>Educacion</td>
				     			</tr>
						       <tr>
						        <td>Requerida por el Cargo</td>
						        <td>% Peso</td>
						        <td>Competencia del Empleado</td>
						        <td>Resultado</td>
						       </tr>
					      </thead>
					      <tbody>
					     
						       @foreach($EvaluacionDesempenioEducacion as $dato)
						       <tr>
						        <td>{{$dato->nombrePerfilRequerido}}</td>
						        <td>{{$dato->porcentajeCargoEducacion}}</td> 
						        <td>{{$dato->nombrePerfilAspirante}}</td>
						        <td>{{$dato->calificacionEvaluacionEducacion}}</td>
						       </tr>
						       @endforeach
						  
					      </tbody>
				     </table>
				     <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td>Formacion</td>
				     			</tr>
						       <tr>
						        <td>Requerida por el Cargo</td>
						        <td>% Peso</td>
						        <td>Competencia del Empleado</td>
						        <td>Resultado</td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($EvaluacionDesempenioFormacion as $dato)
						       <tr>
						        <td>{{$dato->nombrePerfilRequerido}}</td>
						        <td>{{$dato->porcentajeCargoFormacion}}</td>
						        <td>{{$dato->nombrePerfilAspirante}}</td>
						        <td>{{$dato->calificacionEvaluacionFormacion}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				       <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td>Habilidades propias del Cargo</td>
				     			</tr>
						       <tr>
						        <td>Requerida por el Cargo</td>
						        <td>% Peso</td>
						        <td>Competencia del Empleado</td>
						        <td>Resultado</td>
						       </tr>
					      </thead>
					      <tbody>
						       @foreach($EvaluacionDesempenioHabilidad as $dato)
						       <tr>
						        <td>{{$dato->nombrePerfilRequerido}}</td>
						        <td>{{$dato->porcentajeCargoHabilidad}}</td>
						        <td>{{$dato->nombrePerfilAspirante}}</td>
						        <td>{{$dato->calificacionEvaluacionHabilidad}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>
				      <table  class="table table-striped table-bordered" width="100%">
				     <thead>
				     			<tr>
				     			<td>Plan Accion</td>
				     			</tr>
						       <tr>
						        <td>Actividad</td>
						        <td>Responsable</td>
						        <td>Documento</td>
						        <td>F.Planeada</td>
						        <td>F.Ejecutada</td>

						       </tr>
					      </thead>
					      <tbody>
						       @foreach($EvaluacionAccion as $dato)
						       <tr>
						        <td>{{$dato->actividadEvaluacionAccion}}</td>
						        <td>{{$dato->nombreCompletoTercero}}</td>
						        <td>{{$dato->nombreDocumentoSoporte}}</td>
						        <td>{{$dato->fechaPlaneadaEvaluacionAccion}}</td>
						        <td>{{$dato->fechaEjecutadaEvaluacionAccion}}</td>
						       </tr>
						       @endforeach
					      </tbody>
				     </table>

				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



