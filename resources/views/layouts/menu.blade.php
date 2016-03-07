<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	@yield('clases')
	{!!Html::style('CSS/menu.css'); !!}
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
	
	{!!Html::script('assets/bootstrap-v3.3.5/js/bootstrap.min.js'); !!}
	{!!Html::script('js/menu.js'); !!}

	<title>Asisge S.A.</title>
</head>
<body id='body' >

	<div id="header">
		<div id="container">
		<div class="barramenu">
			
			<div id="menuarch" class="menu">
				{!! HTML::image('images/iconosmenu/Archivos%20Maestros.png','Archivos Maestros',array('width'=>'40','title' => 'Archivos maestros')) !!}
			</div>
			<div id="menudoc" class="menu">
				{!! HTML::image('images/iconosmenu/Documentos.png','Documentos',array('width'=>'40','title' => 'Documentos')) !!}
			</div>
			<div id="menuseg" class="menu">
				{!! HTML::image('images/iconosmenu/Seguridad.png','Seguridad',array('width'=>'40','title' => 'Seguridad')) !!}
			</div>
			<div id="menuarch" class="menu">
				{!! HTML::decode(HTML::link('dashboard', HTML::image('images/iconosmenu/Informes.png','Imagen no encontrada',array('width'=>'40','title' => 'Tablero de Control')))) !!}
			</div>
		</div>

			<div id="arrowarch" class="arrow" style="margin-left: 25px;">
			</div>
			<div id="arrowdoc" class="arrow" style="margin-left: 60px;">
			</div>
			<div id="arrowseg" class="arrow" style="margin-left: 95px;">
			</div>

			<div id="gridboxarch" class="gridbox" style="margin-left: 15px;">
				<div id="innergridarch" class="innergrid">
					<ul id="iconsarch" class="icons">
						<li>
							{!! HTML::decode(HTML::link('pais', HTML::image('images/iconosmenu/Paises.png','Imagen no encontrada',array('width'=>'32','title' => 'Paises')))) !!}<br>
							{!!Form::label('', 'Paises')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('departamento', HTML::image('images/iconosmenu/Departamentos.png','Imagen no encontrada',array('width'=>'22','title' => 'Departamentos')))) !!}
							{!!Form::label('', 'Departamentos')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('ciudad', HTML::image('images/iconosmenu/Ciudades.png','Imagen no encontrada',array('width'=>'22','title' => 'Ciudades')))) !!}
							{!!Form::label('', 'Ciudades')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('tipoidentificacion', HTML::image('images/iconosmenu/Tipos%20Identificacion.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipos de Identificacion')))) !!}
							{!!Form::label('', 'Tipos de Identificacion')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('frecuenciamedicion', HTML::image('images/iconosmenu/Frecuencia%20Medicion.png','Imagen no encontrada',array('width'=>'22','title' => 'Frecuencias de Medicion')))) !!}
							{!!Form::label('', 'Frecuencia Medicion')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('proceso', HTML::image('images/iconosmenu/Procesos.png','Imagen no encontrada',array('width'=>'22','title' => 'Procesos')))) !!}
							{!!Form::label('', 'Procesos')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('cargo', HTML::image('images/iconosmenu/Cargos.png','Imagen no encontrada',array('width'=>'22','title' => 'Cargos / Perfiles')))) !!}
							{!!Form::label('', 'Cargos / Perfiles')!!}
			 			</li>
						<li>
							{!! HTML::decode(HTML::link('tercero', HTML::image('images/iconosmenu/Terceros.png','Imagen no encontrada',array('width'=>'22','title' => 'Terceros')))) !!}
							{!!Form::label('', 'Terceros')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('clasificacionriesgo', HTML::image('images/iconosmenu/Clasificacion%20Riesgo.png','Imagen no encontrada',array('width'=>'22','title' => 'Clasificaci&oacute;n de Riesgos')))) !!}
							{!!Form::label('', 'Clasificacion Riesgo')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('tiporiesgo', HTML::image('images/iconosmenu/Tipo%20Riesgo.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Riesgos')))) !!}
							{!!Form::label('', 'Tipo de Riesgo')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('listageneral', HTML::image('images/iconosmenu/Lista%20General.png','Imagen no encontrada',array('width'=>'22','title' => 'Lista General')))) !!}
							{!!Form::label('', 'Listas Generales')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('tiponormalegal', HTML::image('images/iconosmenu/Tipo%20Norma.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Norma Legal')))) !!}
							{!!Form::label('', 'Tipo de Norma')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('expidenormalegal', HTML::image('images/iconosmenu/Manual%20Funciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Emisor de Norma Legal')))) !!}
							{!!Form::label('', 'Emisor Norma')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('documento', HTML::image('images/iconosmenu/Documentos.png','Imagen no encontrada',array('width'=>'22','title' => 'Documentos o Registros')))) !!}
							{!!Form::label('', 'Documentos')!!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('tipoinspeccion', HTML::image('images/iconosmenu/Inspecciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Inspecci&oacute;n')))) !!}
							{!!Form::label('', 'Tipos de Inspeccion')!!}
			 			</li>
				 		<li>
							{!! HTML::decode(HTML::link('tipoexamenmedico', HTML::image('images/iconosmenu/Matriz%20Examenes%20medicos.png','Imagen no encontrada',array('width'=>'22','title' => 'Ex&aacute;menes M&eacute;dicos')))) !!}
							{!!Form::label('', 'Tipo Examen Medico')!!}
			 			</li>
				 		<li>
							{!! HTML::decode(HTML::link('grupoapoyo', HTML::image('images/iconosmenu/Grupos%20apoyo.png','Imagen no encontrada',array('width'=>'22','title' => 'Grupos de Apoyo')))) !!}
							{!!Form::label('', 'Grupos de Apoyo')!!}
			 			</li>
			 			<li>
							{!! HTML::decode(HTML::link('tipoelementoproteccion', HTML::image('images/iconosmenu/Tipo%20Equipos.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipos de Elementos de Protección')))) !!}
							{!!Form::label('', 'Tipo Elemento Proteccion')!!}
			 			</li>
			 			<li>
							{!! HTML::decode(HTML::link('elementoproteccion', HTML::image('images/iconosmenu/Tipo%20Equipos.png','Imagen no encontrada',array('width'=>'22','title' => 'Elementos de Protección')))) !!}
							{!!Form::label('', 'Elemento de Proteccion')!!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('preguntalistachequeo', HTML::image('images/iconosmenu/Preguntas%20Lista%20Chequeo.png','Imagen no encontrada',array('width'=>'22','title' => 'Preguntas Lista de Verificaci&oacute;n')))) !!}
							{!!Form::label('', 'Lista de Verificacion')!!}
						</li>
					</ul>
				</div>
			</div>
			
			<div id="gridboxdoc" class="gridbox" style="margin-left: 50px;">
				<div id="innergriddoc" class="innergrid">
					<ul id="iconsdoc" class="icons">
	      		 	<li>
						{!! HTML::decode(HTML::link('diagnostico', HTML::image('images/iconosmenu/Diagnostico.png','Imagen no encontrada',array('width'=>'22','title' => 'Diagnostico General')))) !!}
						{!!Form::label('', 'Disgnostico')!!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('cuadromando', HTML::image('images/iconosmenu/Cuadro%20Mando.png','Imagen no encontrada',array('width'=>'22','title' => 'Cuadro de Mando')))) !!}
						{!!Form::label('', 'Cuadro de Mando')!!}
					</li>
			 		<li>
						{!! HTML::decode(HTML::link('matrizriesgo', HTML::image('images/iconosmenu/Matriz%20Riesgos.png','Imagen no encontrada',array('width'=>'22','title' => 'Matriz de Riesgos')))) !!}
						{!!Form::label('', 'Matriz de Riesgo')!!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('matrizlegal', HTML::image('images/iconosmenu/Matriz%20Requisitos%20Legales.png','Imagen no encontrada',array('width'=>'22','title' => 'Matriz Legal')))) !!}
						{!!Form::label('', 'Matriz Legal')!!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('procedimiento', HTML::image('images/iconosmenu/Planilla%20Procedimientos.png','Imagen no encontrada',array('width'=>'22','title' => 'Procedimientos')))) !!}
						{!!Form::label('', 'Procedimientos')!!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('programa', HTML::image('images/iconosmenu/Programas%20Actividades.png','Imagen no encontrada',array('width'=>'22','title' => 'Programas/Actividades')))) !!}
						{!!Form::label('', 'Programas / Actividades')!!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('plancapacitacion', HTML::image('images/iconosmenu/Capacitaciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Plan de Capacitaciones')))) !!}
						{!!Form::label('', 'Plan de Capacitacion')!!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('actacapacitacion', HTML::image('images/iconosmenu/Capacitaciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Acta de Capacitaciones')))) !!}
						{!!Form::label('', 'Acta de Capacitacion')!!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('inspeccion', HTML::image('images/iconosmenu/Inspecciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Inspecciones de Seguridad')))) !!}
						{!!Form::label('', 'Inspecciones')!!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('examenmedico', HTML::image('images/iconosmenu/Matriz%20Examenes%20medicos.png','Imagen no encontrada',array('width'=>'22','title' => 'Ex&aacute;menes M&eacute;dicos')))) !!}
						{!!Form::label('', 'Examen Medico')!!}
		 			</li>
		 			<li>
						{!! HTML::decode(HTML::link('ausentismo', HTML::image('images/iconosmenu/Ausentismo.png','Imagen no encontrada',array('width'=>'22','title' => 'Ausentismos')))) !!}
						{!!Form::label('', 'Ausentismos')!!}
		 			</li>
		 			<li>
						{!! HTML::decode(HTML::link('accidente', HTML::image('images/iconosmenu/Tipo%20Equipos.png','Imagen no encontrada',array('width'=>'22','title' => 'Investigaci&oacute;n de Accidentes')))) !!}
						{!!Form::label('', 'Accidentes')!!}
		 			</li>
		 			<li>
						{!! HTML::decode(HTML::link('conformaciongrupoapoyo', HTML::image('images/iconosmenu/Grupos%20apoyo.png','Imagen no encontrada',array('width'=>'22','title' => 'Conformaci&oacute;n de Grupos de Apoyo')))) !!}
						{!!Form::label('', 'Conf. Grupo Apoyo')!!}
		 			</li>
		 			<li>
						{!! HTML::decode(HTML::link('actagrupoapoyo', HTML::image('images/iconosmenu/Acta%20Reunion.png','Imagen no encontrada',array('width'=>'22','title' => 'Acta de Reuni&oacute;n de Grupos de Apoyo')))) !!}
						{!!Form::label('', 'Acta Reunión')!!}
		 			</li>
		 			<li>
						{!! HTML::decode(HTML::link('entregaelementoproteccion', HTML::image('images/iconosmenu/Entrega%20Elementos.png','Imagen no encontrada',array('width'=>'22','title' => 'Entrega de Elementos de Protecci&oacute;n Personal')))) !!}
						{!!Form::label('', 'Entrega EPP')!!}
		 			</li>
		 			<li>
						{!! HTML::decode(HTML::link('planauditoria', HTML::image('images/iconosmenu/Auditorias.png','Imagen no encontrada',array('width'=>'22','title' => 'Plan de Auditorias')))) !!}
						{!!Form::label('', 'Plan de Auditoria')!!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('listachequeo', HTML::image('images/iconosmenu/Preguntas%20Lista%20Chequeo.png','Imagen no encontrada',array('width'=>'22','title' => 'Lista de Verificaci&oacute;n')))) !!}
						{!!Form::label('', 'Lista de Chequeo')!!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('reporteacpm', HTML::image('images/iconosmenu/Acciones%20Correctivas.png','Imagen no encontrada',array('width'=>'22','title' => 'Acciones Correctivas Preventivas y de Mejora')))) !!}
						{!!Form::label('', 'A.C.P.M')!!}
					</li>

		 			</ul>
				</div>
			</div>

			<div id="gridboxseg" class="gridbox" style="margin-left: 85px;">
				<div id="innergridseg" class="innergrid">
					<ul id="iconsseg" class="icons">
					<li>
						{!! HTML::decode(HTML::link('compania', HTML::image('images/iconosmenu/Companias.png','Imagen no encontrada',array('width'=>'22','title' => 'Compañías')))) !!}
						{!!Form::label('', 'Compañias')!!}
					</li>
			        <li>
						{!! HTML::decode(HTML::link('rol', HTML::image('images/iconosmenu/Perfiles.png','Imagen no encontrada',array('width'=>'22','title' => 'Roles/Perfiles')))) !!}
						{!!Form::label('', 'Roles')!!}
			        </li>
			       	<li>
						{!! HTML::decode(HTML::link('users', HTML::image('images/iconosmenu/usuarios.png','Imagen no encontrada',array('width'=>'22','title' => 'Usuarios')))) !!}
						{!!Form::label('', 'Usuarios')!!}
			        </li>
					<li>
						{!! HTML::decode(HTML::link('paquete', HTML::image('images/iconosmenu/Opciones%20Seguridad.png','Imagen no encontrada',array('width'=>'22','title' => 'Paquetes del menu')))) !!}
						{!!Form::label('', 'Paquetes')!!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('opcion', HTML::image('images/iconosmenu/Opciones%20Generales.png','Imagen no encontrada',array('width'=>'22','title' => 'Opciones del menu')))) !!}
						{!!Form::label('', 'Opciones')!!}
					</li>

					</ul>
				</div>
			</div>
</body>

	<div id="contenedor" class="panel panel-primary">
	  <div   class="panel panel-heading">
	    @yield('titulo')
	  </div>
	  <div  id="contenedor-fin" class="panel-body">
	    @yield('content') 
	  </div>
	</div>


	<div id="footer">
	    <p>SiSoft... ASISGE S.A.S. - Todos los derechos reservados</p>
	</div>
</body>
</html>
