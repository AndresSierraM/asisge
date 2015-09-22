<html>
	<head>
	</head>
	<body>
		{!!Form::model($matrizRiesgo)!!}
			<table>
				<tr>
					<td>
						Fecha Elaboraci&oacute;n
					</td>
					<td>
						{{$matrizRiesgo->fechaElaboracionMatrizRiesgo}}
					</td>
					<td>
						Matriz Riesgo
					</td>
					<td>
						{{$matrizRiesgo->nombreMatrizRiesgo}}
					</td>
				</tr>
				<tr>
					<td>Proceso</td>
					<td>Rutinaria</td>
					<td>Clasificaci&oacute;n</td>
					<td>Tipo Riesgo</td>
					<td>Descripci&oacute;n</td>
					<td>Efectos salud</td>
					<td>Planta</td>
					<td>Temporal</td>
					<td>Total</td>
					<td>Fuente</td>
					<td>Medio</td>
					<td>Persona</td>
					<td>Nivel deficiencia</td>
					<td>Nivel exposici&oacute;n</td>
					<td>Nivel probabilidad</td>
					<td>Interpretaci&oacute;n probabilidad</td>
					<td>Nivel consecuencia</td>
					<td>Nivel riesgo</td>
					<td>Interpretaci&oacute;n riesgo</td>
					<td>Aceptaci&oacute;n riesgo</td>
					<td>Eliminaci&oacute;n</td>
					<td>Sustituaci&oacute;n</td>
					<td>Controles</td>
					<td>Protección Persona</td>
					<td>Evidencia</td>
					<td>Observaciones</td>
				</tr>
				@foreach($matrizRiesgo->matrizRiesgoDetalles as $dato)
					<tr>
						<td>{{$dato->Proceso_idProceso}}</td>
						<td>{{$dato->rutinariaMatrizRiesgoDetalle}}</td>
						<td>{{$dato->ClasificacionRiesgo_idClasificacionRiesgo}}</td>
						<td>{{$dato->TipoRiesgo_idTipoRiesgo}}</td>
						<td>{{$dato->TipoRiesgoDetalle_idTipoRiesgoDetalle}}</td>
						<td>{{$dato->TipoRiesgoSalud_idTipoRiesgoSalud}}</td>
						<td>{{$dato->vinculadosMatrizRiesgoDetalle}}</td>
						<td>{{$dato->temporalesMatrizRiesgoDetalle}}</td>
						<td>{{$dato->totalExpuestosMatrizRiesgoDetalle}}</td>
						<td>{{$dato->fuenteMatrizRiesgoDetalle}}</td>
						<td>{{$dato->medioMatrizRiesgoDetalle}}</td>
						<td>{{$dato->personaMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nivelDeficienciaMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nivelExposicionMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nivelProbabilidadMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nombreProbabilidadMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nivelConsecuenciaMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nivelRiesgoMatrizRiesgoDetalle}}</td>
						<td>{{$dato->nombreRiesgoMatrizRiesgoDetalle}}</td>
						<td>{{$dato->aceptacionRiesgoMatrizRiesgoDetalle}}</td>
						<td>{{$dato->ListaGeneral_idEliminacionRiesgo}}</td>
						<td>{{$dato->ListaGeneral_idSustitucionRiesgo}}</td>
						<td>{{$dato->ListaGeneral_idControlAdministrativo}}</td>
						<td>{{$dato->ListaGeneral_idElementoProteccion}}</td>
						<td>{{$dato->imagenMatrizRiesgoDetalle}}</td>
						<td>{{$dato->observacionMatrizRiesgoDetalle}}</td>
					</tr>
				@endforeach
			</table>
		{!!Form::close()!!}
	</body>
</html>