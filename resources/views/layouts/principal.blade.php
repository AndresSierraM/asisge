<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	@yield('clases')

	{!!Html::style('CSS/principal.css'); !!}

	<title>Asisge S.A.</title>
</head>
<body id='body'>
	<div id="header">
	<nav>
        <ul>
        <li><center>Logo<center></li>
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
			{!! HTML::decode(HTML::link('diagnostico', HTML::image('images/iconosmenu/Diagnostico.png','Imagen no encontrada',array('width'=>'48','title' => 'Diagnostico General')))) !!}
 		</center></li>
 		<li><center>
			{!! HTML::decode(HTML::link('cuadromando', HTML::image('images/iconosmenu/Cuadro%20Mando.png','Imagen no encontrada',array('width'=>'48','title' => 'Cuadro de Mando')))) !!}
 		</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('auth/logout', HTML::image('images/iconosmenu/salir-01.png','Imagen no encontrada',array('width'=>'48','title' => 'Salir')))) !!}
		</center></li>
       
        </ul>
    </nav>
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
