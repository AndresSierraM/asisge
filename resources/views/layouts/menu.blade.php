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
				{!! HTML::image('images/iconosmenu/Archivos%20Maestros.png','Archivos Maestros',array('width'=>'32','title' => 'Archivos maestros')) !!}
			</div>
			<div id="menudoc" class="menu">
				{!! HTML::image('images/iconosmenu/Documentos.png','Documentos',array('width'=>'32','title' => 'Documentos')) !!}
			</div>
			<div id="menuseg" class="menu">
				{!! HTML::image('images/iconosmenu/Seguridad.png','Seguridad',array('width'=>'32','title' => 'Seguridad')) !!}
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
							{!! HTML::decode(HTML::link('pais', HTML::image('images/iconosmenu/Paises.png','Imagen no encontrada',array('width'=>'22','title' => 'Paises')))) !!}
							</li>
						<li>
							{!! HTML::decode(HTML::link('departamento', HTML::image('images/iconosmenu/Departamentos.png','Imagen no encontrada',array('width'=>'22','title' => 'Departamentos')))) !!}
							</li>
						<li>
							{!! HTML::decode(HTML::link('ciudad', HTML::image('images/iconosmenu/Ciudades.png','Imagen no encontrada',array('width'=>'22','title' => 'Ciudades')))) !!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('tipoidentificacion', HTML::image('images/iconosmenu/Tipos%20Identificacion.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipos de Identificacion')))) !!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('frecuenciamedicion', HTML::image('images/iconosmenu/Frecuencia%20Medicion.png','Imagen no encontrada',array('width'=>'22','title' => 'Frecuencias de Medicion')))) !!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('proceso', HTML::image('images/iconosmenu/Procesos.png','Imagen no encontrada',array('width'=>'22','title' => 'Procesos')))) !!}
						</li>
						<li>
							{!! HTML::decode(HTML::link('tercero', HTML::image('images/iconosmenu/Terceros.png','Imagen no encontrada',array('width'=>'22','title' => 'Terceros')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('clasificacionriesgo', HTML::image('images/iconosmenu/Clasificacion%20Riesgo.png','Imagen no encontrada',array('width'=>'22','title' => 'Clasificaci&oacute;n de Riesgos')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('tiporiesgo', HTML::image('images/iconosmenu/Tipo%20Riesgo.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Riesgos')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('listageneral', HTML::image('images/iconosmenu/Lista%20General.png','Imagen no encontrada',array('width'=>'22','title' => 'Lista General')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('tiponormalegal', HTML::image('images/iconosmenu/Tipo%20Norma.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Norma Legal')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('expidenormalegal', HTML::image('images/iconosmenu/Manual%20Funciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Emisor de Norma Legal')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('documento', HTML::image('images/iconosmenu/Documentos.png','Imagen no encontrada',array('width'=>'22','title' => 'Documentos o Registros')))) !!}
				 		</li>
				 		<li>
							{!! HTML::decode(HTML::link('tipoinspeccion', HTML::image('images/iconosmenu/Inspecciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Inspecci&oacute;n')))) !!}
			 			</li>
				 		<li>
							{!! HTML::decode(HTML::link('cargo', HTML::image('images/iconosmenu/Cargos.png','Imagen no encontrada',array('width'=>'22','title' => 'Cargos / Perfiles')))) !!}
			 			</li>

					</ul>
				</div>
			</div>
			
			<div id="gridboxdoc" class="gridbox" style="margin-left: 50px;">
				<div id="innergriddoc" class="innergrid">
					<ul id="iconsdoc" class="icons">
	      		 	<li>
						{!! HTML::decode(HTML::link('diagnostico', HTML::image('images/iconosmenu/Diagnostico.png','Imagen no encontrada',array('width'=>'22','title' => 'Diagnostico General')))) !!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('cuadromando', HTML::image('images/iconosmenu/Cuadro%20Mando.png','Imagen no encontrada',array('width'=>'22','title' => 'Cuadro de Mando')))) !!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('matrizriesgo', HTML::image('images/iconosmenu/Matriz%20Riesgos.png','Imagen no encontrada',array('width'=>'22','title' => 'Matriz de Riesgos')))) !!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('matrizlegal', HTML::image('images/iconosmenu/Matriz%20Requisitos%20Legales.png','Imagen no encontrada',array('width'=>'22','title' => 'Matriz Legal')))) !!}
				 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('procedimiento', HTML::image('images/iconosmenu/Planilla%20Procedimientos.png','Imagen no encontrada',array('width'=>'22','title' => 'Procedimientos')))) !!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('programa', HTML::image('images/iconosmenu/Programas%20Actividades.png','Imagen no encontrada',array('width'=>'22','title' => 'Programas/Actividades')))) !!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('plancapacitacion', HTML::image('images/iconosmenu/Capacitaciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Plan de Capacitaciones')))) !!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('actacapacitacion', HTML::image('images/iconosmenu/Capacitaciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Acta de Capacitaciones')))) !!}
			 		</li>
			 		<li>
						{!! HTML::decode(HTML::link('inspeccion', HTML::image('images/iconosmenu/Inspecciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Inspecciones de Seguridad')))) !!}
			 		</li>
					</ul>
				</div>
			</div>

			<div id="gridboxseg" class="gridbox" style="margin-left: 85px;">
				<div id="innergridseg" class="innergrid">
					<ul id="iconsseg" class="icons">
					<li>
						{!! HTML::decode(HTML::link('compania', HTML::image('images/iconosmenu/Companias.png','Imagen no encontrada',array('width'=>'22','title' => 'Compañías')))) !!}
					</li>
			        <li>
						{!! HTML::decode(HTML::link('rol', HTML::image('images/iconosmenu/Perfiles.png','Imagen no encontrada',array('width'=>'22','title' => 'Roles/Perfiles')))) !!}
			        </li>
			       	<li>
						{!! HTML::decode(HTML::link('users', HTML::image('images/iconosmenu/usuarios.png','Imagen no encontrada',array('width'=>'22','title' => 'Usuarios')))) !!}
			        </li>
					<li>
						{!! HTML::decode(HTML::link('paquete', HTML::image('images/iconosmenu/Opciones%20Seguridad.png','Imagen no encontrada',array('width'=>'22','title' => 'Paquetes del menu')))) !!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('opcion', HTML::image('images/iconosmenu/Opciones%20Generales.png','Imagen no encontrada',array('width'=>'22','title' => 'Opciones del menu')))) !!}
					</li>

					</ul>
				</div>
			</div>
</body>

<p style="text-align: justify;">


	<!-- <div class="contenedor">
	  <ul class="nav nav-pills">
	    
	  	<li class="active" >
	    	{!! HTML::decode(HTML::link('#menu1', HTML::image('images/iconosmenu/Archivos%20Maestros.png','Archivos Maestros',array('width'=>'22', 'padding'=>'0px 10px', 'title' => 'Archivos Maestros')),array("data-toggle"=>"pill"))) !!}
	  	</li>
	    <li>
	    	{!! HTML::decode(HTML::link('#menu2', HTML::image('images/iconosmenu/Documentos.png','Documentos',array('width'=>'22','title' => 'Documentos')),array("data-toggle"=>"pill"))) !!}
	  	</li>
	  	<li>
	    	{!! HTML::decode(HTML::link('#menu3', HTML::image('images/iconosmenu/Seguridad.png','Seguridad',array('width'=>'22','title' => 'Seguridad')),array("data-toggle"=>"pill"))) !!}
	  	</li>
	  	<li>
	    	{!! HTML::decode(HTML::link('', HTML::image('images/iconosmenu/Salir-01.png','Imagen no encontrada',array('width'=>'22','title' => 'Salir')),array("data-toggle"=>"pill"))) !!}
	    	
	  	</li>
	  </ul>
	  
	  <div class="tab-content">
	    <div id="menu1" class="tab-pane fade in active">
			<nav>
		        <ul class="nav nav-pills">
					<li>
						{!! HTML::decode(HTML::link('pais', HTML::image('images/iconosmenu/Paises.png','Imagen no encontrada',array('width'=>'22','title' => 'Paises')))) !!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('departamento', HTML::image('images/iconosmenu/Departamentos.png','Imagen no encontrada',array('width'=>'22','title' => 'Departamentos')))) !!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('ciudad', HTML::image('images/iconosmenu/Ciudades.png','Imagen no encontrada',array('width'=>'22','title' => 'Ciudades')))) !!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('tipoidentificacion', HTML::image('images/iconosmenu/Tipos%20Identificacion.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipos de Identificacion')))) !!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('frecuenciamedicion', HTML::image('images/iconosmenu/Frecuencia%20Medicion.png','Imagen no encontrada',array('width'=>'22','title' => 'Frecuencias de Medicion')))) !!}
				</li>
					<li>
						{!! HTML::decode(HTML::link('proceso', HTML::image('images/iconosmenu/Procesos.png','Imagen no encontrada',array('width'=>'22','title' => 'Procesos')))) !!}
				</li>
					<li>
						{!! HTML::decode(HTML::link('tercero', HTML::image('images/iconosmenu/Terceros.png','Imagen no encontrada',array('width'=>'22','title' => 'Terceros')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('clasificacionriesgo', HTML::image('images/iconosmenu/Clasificacion%20Riesgo.png','Imagen no encontrada',array('width'=>'22','title' => 'Clasificaci&oacute;n de Riesgos')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('tiporiesgo', HTML::image('images/iconosmenu/Tipo%20Riesgo.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Riesgos')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('listageneral', HTML::image('images/iconosmenu/Lista%20General.png','Imagen no encontrada',array('width'=>'22','title' => 'Lista General')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('tiponormalegal', HTML::image('images/iconosmenu/Tipo%20Norma.png','Imagen no encontrada',array('width'=>'22','title' => 'Tipo de Norma Legal')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('expidenormalegal', HTML::image('images/iconosmenu/Manual%20Funciones.png','Imagen no encontrada',array('width'=>'22','title' => 'Emisor de Norma Legal')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('documento', HTML::image('images/iconosmenu/Documentos.png','Imagen no encontrada',array('width'=>'22','title' => 'Documentos o Registros')))) !!}
			 	</li>
			    </ul>
	    	</nav>

	    </div>


	    <div id="menu2" class="tab-pane fade">
			<nav>
		        <ul class="nav nav-pills">
	      		 	<li>
						{!! HTML::decode(HTML::link('diagnostico', HTML::image('images/iconosmenu/Diagnostico.png','Imagen no encontrada',array('width'=>'22','title' => 'Diagnostico General')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('cuadromando', HTML::image('images/iconosmenu/Cuadro%20Mando.png','Imagen no encontrada',array('width'=>'22','title' => 'Cuadro de Mando')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('matrizriesgo', HTML::image('images/iconosmenu/Matriz%20Riesgos.png','Imagen no encontrada',array('width'=>'22','title' => 'Matriz de Riesgos')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('matrizlegal', HTML::image('images/iconosmenu/Matriz%20Requisitos%20Legales.png','Imagen no encontrada',array('width'=>'22','title' => 'Matriz Legal')))) !!}
			 	</li>
			 		<li>
						{!! HTML::decode(HTML::link('procedimiento', HTML::image('images/iconosmenu/Planilla%20Procedimientos.png','Imagen no encontrada',array('width'=>'22','title' => 'Procedimientos')))) !!}
			 	</li>
			    </ul>
	    	</nav>
	    </div>


	    <div id="menu3" class="tab-pane fade">
			<nav>
		        <ul class="nav nav-pills">
					<li>
						{!! HTML::decode(HTML::link('compania', HTML::image('images/iconosmenu/Companias.png','Imagen no encontrada',array('width'=>'22','title' => 'Compañías')))) !!}
					</li>
			        <li>
						{!! HTML::decode(HTML::link('rol', HTML::image('images/iconosmenu/Perfiles.png','Imagen no encontrada',array('width'=>'22','title' => 'Roles/Perfiles')))) !!}
			        </li>
			       	<li>
						{!! HTML::decode(HTML::link('users', HTML::image('images/iconosmenu/usuarios.png','Imagen no encontrada',array('width'=>'22','title' => 'Usuarios')))) !!}
			        </li>
					<li>
						{!! HTML::decode(HTML::link('paquete', HTML::image('images/iconosmenu/Opciones%20Seguridad.png','Imagen no encontrada',array('width'=>'22','title' => 'Paquetes del menu')))) !!}
					</li>
					<li>
						{!! HTML::decode(HTML::link('opcion', HTML::image('images/iconosmenu/Opciones%20Generales.png','Imagen no encontrada',array('width'=>'22','title' => 'Opciones del menu')))) !!}
					</li>
			    </ul>
	    	</nav>

	    </div>
	  </div>

	</div> -->

	<div id="contenedor">
	    @yield('titulo')
	</div>
	<div id="contenedor-fin">
	    <div id="pantalla">
	       @yield('content') 
	    </div>
	</div>
	
	<div id="footer">
	    <p>SiSoft... ASISGE S.A.S. - Todos los derechos reservados</p>
	</div>
</body>
</html>
