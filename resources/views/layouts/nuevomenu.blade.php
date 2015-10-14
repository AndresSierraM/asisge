<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	@yield('clases')

	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	{!!Html::style('CSS/principal.css'); !!}

	<title>Asisge S.A.</title>
</head>
<body id='body'>

<div id="header">

<div class="contenedor">
  <ul class="nav nav-pills">
    <li>
    	<center>SISoft<center>
    </li>
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
		    </ul>
    	</nav>

    </div>


    <div id="menu2" class="tab-pane fade">
		<nav>
	        <ul class="nav nav-pills">
      		 	<li>
					{!! HTML::decode(HTML::link('diagnostico', HTML::image('images/iconosmenu/Diagnostico.png','Imagen no encontrada',array('width'=>'48','title' => 'Diagnostico General')))) !!}
		 		</li>
		 		<li>
					{!! HTML::decode(HTML::link('cuadromando', HTML::image('images/iconosmenu/Cuadro%20Mando.png','Imagen no encontrada',array('width'=>'48','title' => 'Cuadro de Mando')))) !!}
		 		</li>
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

</div>
<br>
<br>
<br>
<br>
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





<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h3>Popover Options</h3>
  <p>The <strong>html</strong> option specifies whether to accept HTML tags in the popover.</p>
  <button class="btn btn-success btn-md">Click me</button>
</div>

<script>
$(document).ready(function(){
    $('.btn').popover({title: "<h1><strong>HTML</strong> inside <code>the</code> <em>popover</em></h1>", content: "<img src='https://www.google.com/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&ved=0CAcQjRxqFQoTCLD-nLaMz8cCFcTXHgodmMQPew&url=http%3A%2F%2Fwww.zehngames.com%2Farticulos%2Fel-item-como-icono-videoludico%2F&ei=cxHiVfD4GMSve5iJv9gH&psig=AFQjCNG27haemtmIz7FZXBwfC4yYe_elcg&ust=1440965358642198&cad=rja' title='hongo'>", html: true, placement: "right"}); 
});
</script>

</body>
</html>
