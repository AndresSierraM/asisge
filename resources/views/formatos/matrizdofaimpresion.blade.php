@extends('layouts.formato')

@section('contenido')
	{!!Form::model($MatrizDofaEncabezado)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body" >
					@foreach($MatrizDofaEncabezado as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Matriz Dofa</td>
							</tr>
							<tr>
								<td>Fecha</td>
								<td>{{$encabezado->fechaElaboracionMatrizDOFA}}</td>
							</tr>
							<tr>
								<td>Responsable</td>
								<td>{{$encabezado->nombreCompletoTercero}}</td>								
							</tr>
							<tr>
								<td>Procesos</td>
								<td>{{$encabezado->nombreProceso}}</td>
							</tr>				
						</thead>
					</table>
				    @endforeach
				    	<!-- Multi oportunidad -->
			     	<table  class="table table-striped table-bordered" width="100%">
				     		<thead>
				     			<tr>
				     				<td>Oportunidades (Externas)</td>
				     			</tr>
						       <tr>
							        <td>Oportunidades (Externas)</td>
							        <td>Matriz Riesgo Proceso</td>
						       </tr>
					      	</thead>
					      <tbody>
						       @foreach($MatrizDofaoportunidadS as $oportunidad)
						       <tr>
							        <td>{{$oportunidad->descripcionMatrizDOFADetalle_Oportunidad}}</td>
							        <td>{{($oportunidad->matrizRiesgoMatrizDOFADetalle_Oportunidad == 1 ? 'Sí' : 'No')}}</td>						        
						       </tr>
						       @endforeach
					      </tbody>
			     	</table>	
			     	<!-- Multi fortaleza -->
		          	<table  class="table table-striped table-bordered" width="100%">
				     		<thead>
				     			<tr>
				     				<td>Fortalezas (Internas)</td>
				     			</tr>
						       <tr>
							        <td>Fortalezas (Internas)</td>
							        <td>Matriz Riesgo Proceso</td>
						       </tr>
					      	</thead>
					      <tbody>
						       @foreach($MatrizDofafortalezaS as $fortaleza)
						       <tr>
							        <td>{{$fortaleza->descripcionMatrizDOFADetalle_Fortaleza}}</td>
							        <td>{{($fortaleza->matrizRiesgoMatrizDOFADetalle_Fortaleza == 1 ? 'Sí' : 'No')}}</td>						        
						       </tr>
						       @endforeach
					      </tbody>
			     	</table>
			     	<!-- Multi Amenaza -->
		          	<table  class="table table-striped table-bordered" width="100%">
				     		<thead>
				     			<tr>
				     				<td>Amenazas (Externas)</td>
				     			</tr>
						       <tr>
							        <td>Amenazas (Externas)</td>
							        <td>Matriz Riesgo Proceso</td>
						       </tr>
					      	</thead>
					      <tbody>
						       @foreach($MatrizDofaamenazaS as $amenaza)
						       <tr>
							        <td>{{$amenaza->descripcionMatrizDOFADetalle_Amenaza}}</td>
							        <td>{{($amenaza->matrizRiesgoMatrizDOFADetalle_Amenaza == 1 ? 'Sí' : 'No')}}</td>						        
						       </tr>
						       @endforeach
					      </tbody>
			     	</table>
			     	<!-- Multi Debilidad -->
		          	<table  class="table table-striped table-bordered" width="100%">
				     		<thead>
				     			<tr>
				     				<td>Debilidades (Internas)</td>
				     			</tr>
						       <tr>
							        <td>Debilidades (Internas)</td>
							        <td>Matriz Riesgo Proceso</td>
						       </tr>
					      	</thead>
					      <tbody>
						       @foreach($MatrizDofadebilidadS as $debilidad)
						       <tr>
							        <td>{{$debilidad->descripcionMatrizDOFADetalle_Debilidad}}</td>
							        <td>{{($debilidad->matrizRiesgoMatrizDOFADetalle_Debilidad == 1 ? 'Sí' : 'No')}}</td>						        
						       </tr>
						       @endforeach
					      </tbody>
			     	</table>		        		
				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



