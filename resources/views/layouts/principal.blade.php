<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	@yield('clases')

	{!!Html::style('CSS/principal.css'); !!}
	
	<title>Asisge S.A.</title>

</head>
<body id='body'>
	
	<nav>
        <ul>
        <li><center>Logo<center></li>
        <li><center><a href="users" >
 			{!! HTML::image('images/iconosmenu/usuarios.png', '../Usuarios', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="paquete" >
 			{!! HTML::image('images/iconosmenu/Opciones%20Seguridad.png', 'Paquetes del menu', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="opcion">
 			{!! HTML::image('images/iconosmenu/Opciones%20Generales.png', 'Opciones del menu', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="pais">
 			{!! HTML::image('images/iconosmenu/Paises.png', 'Paises', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="departamento">
 			{!! HTML::image('images/iconosmenu/Paises.png', 'Departamentos', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="ciudad">
 			{!! HTML::image('images/iconosmenu/Ciudades.png', 'Ciudades', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="tipoidentificacion">
 			{!! HTML::image('images/iconosmenu/Tipos%20Identificacion.png', 'Tipos de Identificacion', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="compania">
 			{!! HTML::image('images/iconosmenu/Companias.png', 'Compañías', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="frecuenciamedicion">
 			{!! HTML::image('images/iconosmenu/Frecuencia%20Medicion.png', 'Frecuencias de Medicion', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="proceso">
 			{!! HTML::image('images/iconosmenu/Procesos.png', 'Procesos', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="tercero">
 			{!! HTML::image('images/iconosmenu/Terceros.png', 'Terceros', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
		<li><center><a href="">
 			{!! HTML::image('images/iconosmenu/salir-01.png', 'Salir', array('width' => '48', 'height' => '48') ) !!}
		</a></center></li>
        
        </ul>
    </nav>


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
