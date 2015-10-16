<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	@yield('clases')

	{!!Html::style('CSS/principal.css'); !!}

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<title>Asisge S.A.</title>
</head>
<body id='body' >
	
	<div id="header">

	<div class="contenedor">
	  <ul class="nav nav-pills">
	    
	  	<li class="active">
	    	{!! HTML::decode(HTML::link('#menu1', HTML::image('images/iconosmenu/Archivos%20Maestros.png','Archivos Maestros',array('width'=>'48','title' => 'Archivos Maestros')),array("data-toggle"=>"pill"))) !!}
	  	</li>
	    <li>
	    	{!! HTML::decode(HTML::link('#menu2', HTML::image('images/iconosmenu/Documentos.png','Documentos',array('width'=>'48','title' => 'Documentos')),array("data-toggle"=>"pill"))) !!}
	  	</li>
	  	<li>
	    	{!! HTML::decode(HTML::link('#menu3', HTML::image('images/iconosmenu/Seguridad.png','Seguridad',array('width'=>'48','title' => 'Seguridad')),array("data-toggle"=>"pill"))) !!}
	  	</li>
	  	<li>
	    	{!! HTML::decode(HTML::link('', HTML::image('images/iconosmenu/Salir-01.png','Imagen no encontrada',array('width'=>'48','title' => 'Salir')),array("data-toggle"=>"pill"))) !!}
	    	
	  	</li>
	  </ul>
	  
	  <div class="tab-content">
	    <div id="menu1" class="tab-pane fade in active">
			<nav>
		        <ul class="nav nav-pills">
					<li><center>
						{!! HTML::decode(HTML::link('pais', HTML::image('images/iconosmenu/Paises.png','Imagen no encontrada',array('width'=>'48','title' => 'Paises')))) !!}
						</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('departamento', HTML::image('images/iconosmenu/Departamentos.png','Imagen no encontrada',array('width'=>'48','title' => 'Departamentos')))) !!}
						</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('ciudad', HTML::image('images/iconosmenu/Ciudades.png','Imagen no encontrada',array('width'=>'48','title' => 'Ciudades')))) !!}
						</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('tipoidentificacion', HTML::image('images/iconosmenu/Tipos%20Identificacion.png','Imagen no encontrada',array('width'=>'48','title' => 'Tipos de Identificacion')))) !!}
						</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('frecuenciamedicion', HTML::image('images/iconosmenu/Frecuencia%20Medicion.png','Imagen no encontrada',array('width'=>'48','title' => 'Frecuencias de Medicion')))) !!}
					</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('proceso', HTML::image('images/iconosmenu/Procesos.png','Imagen no encontrada',array('width'=>'48','title' => 'Procesos')))) !!}
					</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('tercero', HTML::image('images/iconosmenu/Terceros.png','Imagen no encontrada',array('width'=>'48','title' => 'Terceros')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('clasificacionriesgo', HTML::image('images/iconosmenu/Clasificacion%20Riesgo.png','Imagen no encontrada',array('width'=>'48','title' => 'Clasificaci&oacute;n de Riesgos')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('tiporiesgo', HTML::image('images/iconosmenu/Tipo%20Riesgo.png','Imagen no encontrada',array('width'=>'48','title' => 'Tipo de Riesgos')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('listageneral', HTML::image('images/iconosmenu/Lista%20General.png','Imagen no encontrada',array('width'=>'48','title' => 'Lista General')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('tiponormalegal', HTML::image('images/iconosmenu/Tipo%20Norma.png','Imagen no encontrada',array('width'=>'48','title' => 'Tipo de Norma Legal')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('expidenormalegal', HTML::image('images/iconosmenu/Manual%20Funciones.png','Imagen no encontrada',array('width'=>'48','title' => 'Emisor de Norma Legal')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('documento', HTML::image('images/iconosmenu/Documentos.png','Imagen no encontrada',array('width'=>'48','title' => 'Documentos o Registros')))) !!}
			 		</center></li>
			    </ul>
	    	</nav>

	    </div>


	    <div id="menu2" class="tab-pane fade">
			<nav>
		        <ul class="nav nav-pills">
	      		 	<li><center>
						{!! HTML::decode(HTML::link('diagnostico', HTML::image('images/iconosmenu/Diagnostico.png','Imagen no encontrada',array('width'=>'48','title' => 'Diagnostico General')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('cuadromando', HTML::image('images/iconosmenu/Cuadro%20Mando.png','Imagen no encontrada',array('width'=>'48','title' => 'Cuadro de Mando')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('matrizriesgo', HTML::image('images/iconosmenu/Matriz%20Riesgos.png','Imagen no encontrada',array('width'=>'48','title' => 'Matriz de Riesgos')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('matrizlegal', HTML::image('images/iconosmenu/Matriz%20Requisitos%20Legales.png','Imagen no encontrada',array('width'=>'48','title' => 'Matriz Legal')))) !!}
			 		</center></li>
			 		<li><center>
						{!! HTML::decode(HTML::link('procedimiento', HTML::image('images/iconosmenu/Planilla%20Procedimientos.png','Imagen no encontrada',array('width'=>'48','title' => 'Procedimientos')))) !!}
			 		</center></li>
			    </ul>
	    	</nav>
	    </div>


	    <div id="menu3" class="tab-pane fade">
			<nav>
		        <ul class="nav nav-pills">
					<li><center>
						{!! HTML::decode(HTML::link('compania', HTML::image('images/iconosmenu/Companias.png','Imagen no encontrada',array('width'=>'48','title' => 'Compañías')))) !!}
						</center></li>
			        <li><center>
						{!! HTML::decode(HTML::link('rol', HTML::image('images/iconosmenu/Perfiles.png','Imagen no encontrada',array('width'=>'48','title' => 'Roles/Perfiles')))) !!}
			        	</center></li>
			       	<li><center>
						{!! HTML::decode(HTML::link('users', HTML::image('images/iconosmenu/usuarios.png','Imagen no encontrada',array('width'=>'48','title' => 'Usuarios')))) !!}
			        	</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('paquete', HTML::image('images/iconosmenu/Opciones%20Seguridad.png','Imagen no encontrada',array('width'=>'48','title' => 'Paquetes del menu')))) !!}
						</center></li>
					<li><center>
						{!! HTML::decode(HTML::link('opcion', HTML::image('images/iconosmenu/Opciones%20Generales.png','Imagen no encontrada',array('width'=>'48','title' => 'Opciones del menu')))) !!}
						</center></li>
			    </ul>
	    	</nav>

	    </div>
	  </div>

	</div>

	<div id="contenedor">
	    @yield('titulo')
	</div>
	<div id="contenedor-fin">
	    <div id="pantalla">
	       @yield('content') 
	    </div>
	</div>
	
	<div id="footer">
	    <p>Sistema de gestion documental... Todos los derechos reservados</p>
	</div>
</body>
</html>
