@extends('layouts.formato')

@section('contenido')
	{!!Form::model($conformaciongrupoapoyoS)!!}
		<div class="col-lg-12">
            <div class="panel panel-default" style="width:1500px;">
				<div class="panel-body">
					@foreach($conformaciongrupoapoyoS as $encabezado)
					<table class="table" width="100%">
						<thead>
							<tr>
								<td colspan="2" align="center">Conformaci&#243;n de  Grupos Apoyo</td>
							</tr>
							<tr>
								<td>Grupo</td>
								<td>{{$encabezado->nombreGrupoApoyo}}</td>
							</tr>
							<tr>
								<td>Descripci&#243;n</td>
								<td>{{$encabezado->nombreConformacionGrupoApoyo}}</td>
								
							</tr>
							<tr>
								<td>Fecha de Elaboraci&#243;n</td>
								<td>{{$encabezado->fechaConformacionGrupoApoyo}}</td>
							</tr>
						</thead>
					</table>
					  <!-- Pestaña Convocatoria -->
				        <table  class="table table-striped table-bordered" width="70%">
				     <thead>
				     		<tr>
				     			<td><b>Detalles</b></td>
			     			</tr>
			     			<tr>
				     			<td colspan="2"><b>Convocatoria</b></td>
			     			</tr>
					       	<tr>
								<td><b>Fecha</b></td>
								<td>{{$encabezado->fechaConvocatoriaConformacionGrupoApoyo}}</td>
							</tr>
							<tr>
								<td><b>Representante</b></td>
								<td>{{$encabezado->representante}}</td>
							</tr>
							<tr>
								<td><b>Fecha Votaci&#243;n</b></td>
								<td>{{$encabezado->fechaVotacionConformacionGrupoApoyo}}</td>
							</tr>
							<tr>
								<td><b>Gerente General</b></td>
								<td>{{$encabezado->gerente}}</td>
							</tr>
					      </thead>
				     </table>
				     <!-- Pestaña Actas de votacion-->
				        <table  class="table table-striped table-bordered" width="70%">
					     <thead>				     		
				     			<tr>
					     			<td colspan="2"><b>Actas de Votaci&#243;n</b></td>
				     			</tr>
						       	<tr>
									<td><b>Fecha</b></td>
									<td>{{$encabezado->fechaActaConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Hora</b></td>
									<td>{{$encabezado->horaActaConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Inicio del Periodo</b></td>
									<td>{{$encabezado->fechaInicioConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Fin del Periodo</b></td>
									<td>{{$encabezado->fechaFinConformacionGrupoApoyo}}</td>
								</tr>
								@endforeach
						      </thead>
				     	</table>
				     			   <!-- Multiregistro Votacion -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
									<tr>
										<td><b>Jurado</b></td>
										<td><b>Firma</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($conformaciongrupoapoyojuradoS as $jurado)
						       <tr>
						        <td>{{$jurado->nombreCompletoTercero}}</td>
						        <td><?php echo '<img style="width:40%; height:40%; position:left;" src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$jurado->firmaActaConformacionGrupoApoyoTercero.'"';?></td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				        <!-- Multiregistro Resultado de la votacion  -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td><b>Resultado de la Votaci&#243;n</b></td>
					     			</tr>
									<tr>
										<td><b>Nombre</b></td>
										<td><b>Votos</b></td>
									</tr>
									<tr>
										
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($conformaciongrupoapoyoresultadoS as $resultado)
						       <tr>
						        <td>{{$resultado->nombreCompletoTercero}}</td>
						        <td>{{$resultado->votosConformacionGrupoApoyoResultado}}</td>
						       </tr>
						       @endforeach
					 	
					      </tbody>
				     </table>
				       <!-- Pestaña Actas de votacion-->
				        <table  class="table table-striped table-bordered" width="70%">
				        @foreach($conformaciongrupoapoyoS as $encabezado)
					     <thead>				     		
				     			<tr>
					     			<td colspan="2"><b>Constituci&#243;n</b></td>
				     			</tr>
						       	<tr>
									<td><b>Fecha</b></td>
									<td>{{$encabezado->fechaConstitucionConformacionGrupoApoyo}}</td>
								</tr>
								<tr>
									<td><b>Presidente</b></td>
									<td>{{$encabezado->presidente}}</td>
								</tr>
								<tr>
									<td><b>Secretario</b></td>
									<td>{{$encabezado->secretario}}</td>
								</tr>
								@endforeach
						      </thead>
				     	</table>
				     	  <!-- Multiregistro Integrantes del Comite  -->
				       <table  class="table table-striped table-bordered" width="100%">
					     	<thead>
					     			<tr>
					     				<td><b>Integrantes del Comite</b></td>
					     			</tr>
									<tr>
										<td><b>Nombrado Por</b></td>
										<td><b>Principal</b></td>
										<td><b>Suplentes</b></td>
									</tr>
					      	</thead>
					       <tbody>
					         @foreach($conformaciongrupoapoyocomiteS as $integrante)
						       <tr>
						        <td>{{$integrante->nombradoPor}}</td>
						        <td>{{$integrante->principal}}</td>
						        <td>{{$integrante->suplente}}</td>
						       </tr>
						       @endforeach					 	
					      </tbody>
				     </table>

				</div>
			</div>
		</div>
	{!!Form::close()!!}
@stop



