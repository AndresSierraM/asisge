<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	@yield('clases')

	{!!Html::style('CSS/principal.css'); !!}
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


	<title>Asisge S.A.</title>
</head>
<body id='body'>


<div class="container">
  <h2>Dynamic Pills</h2>
  <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
    <li><a data-toggle="pill" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="pill" href="#menu3">Menu 3</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>


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
			{!! HTML::decode(HTML::link('', HTML::image('images/iconosmenu/salir-01.png','Imagen no encontrada',array('width'=>'48','title' => 'Salir')))) !!}
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
