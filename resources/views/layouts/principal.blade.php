<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
	{!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}
	{!!Html::style('assets/jquery-jqGrid-v4.8.0/css/ui.jqgrid.css'); !!}
	{!!Html::style('assets/tutorial/css/main.css'); !!}
	{!!Html::style('assets/tutorial/css/callouts.css'); !!}
	{!!Html::style('choosen/docsupport/style.css'); !!}
	{!!Html::style('choosen/docsupport/prism.css'); !!}
 	{!!Html::style('choosen/chosen.css'); !!}
 	{!!Html::style('sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css'); !!}
 	{!!Html::style('sb-admin/bower_components/metisMenu/dist/metisMenu.min.css'); !!}
	{!!Html::style('sb-admin/dist/css/sb-admin-2.css'); !!}
	{!!Html::style('sb-admin/bower_components/font-awesome/css/font-awesome.min.css'); !!}
	{!!Html::style('sb-admin/bower_components/datetimepicker/css/bootstrap-datetimepicker.min.css'); !!}
	{!!Html::style('sb-admin/bower_components/fileinput/css/fileinput.css'); !!}
	{!!Html::style('css/principal.css'); !!}
	<style type="text/css" media="all">
	    /* fix rtl for demo */
	    .chosen-rtl .chosen-drop { left: -9000px; }
  	</style>
	{!!Html::script('assets/tutorial/js/ie10-viewport-bug-workaround.js'); !!}
	{!!Html::script('assets/tutorial/js/ie-emulation-modes-warning.js'); !!}
	{!!Html::script('assets/jquery-v2.1.4/jquery-2.1.4.min.js'); !!}
	{!!Html::script('assets/jquery-jqGrid-v4.8.0/js/i18n/grid.locale-en.js'); !!}
	{!!Html::script('assets/jquery-jqGrid-v4.8.0/js/jquery.jqGrid.src.js'); !!}
	{!!Html::script('assets/bootstrap-v3.3.5/js/bootstrap.min.js'); !!}
	{!!Html::script('assets/tutorial/js/helpers.js'); !!}
	{!!Html::script('assets/tutorial/js/base.js'); !!}
	{!!Html::script('sb-admin/bower_components/datetimepicker/js/moment.js'); !!}
	{!!Html::script('sb-admin/bower_components/datetimepicker/js/bootstrap-datetimepicker.min.js'); !!}
	{!!Html::script('sb-admin/bower_components/fileinput/js/fileinput.js'); !!}
	{!!Html::script('sb-admin/bower_components/fileinput/js/fileinput_locale_es.js'); !!}
	{!!Html::script('choosen/chosen.jquery.js'); !!}
	{!!Html::script('choosen/docsupport/prism.js'); !!}


  	<script type="text/javascript">
    	$(document).ready(function (){
		    var config = {
		      '.chosen-select'           : {},
		      '.chosen-select-deselect'  : {allow_single_deselect:true},
		      '.chosen-select-no-single' : {disable_search_threshold:10},
		      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		      '.chosen-select-width'     : {width:"95%"}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }
		});
  	</script>
	<title>Asisge S.A.</title>
</head>
<body id='body'>
	<div id="header">
	<nav>
        <ul>
        <li><center>Logo<center></li>
        <li><center>
			{!! HTML::decode(HTML::link('users', HTML::image('images/iconosmenu/usuarios.png','Imagen no encontrada',array('width'=>'48','title' => 'Usuarios')))) !!}
        	</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('paquete', HTML::image('images/iconosmenu/Opciones%20Generales.png','Imagen no encontrada',array('width'=>'48','title' => 'Paquetes del menu')))) !!}
			</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('opcion', HTML::image('images/iconosmenu/Opciones%20Generales.png','Imagen no encontrada',array('width'=>'48','title' => 'Opciones del menu')))) !!}
			</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('pais', HTML::image('images/iconosmenu/Paises.png','Imagen no encontrada',array('width'=>'48','title' => 'Paises')))) !!}
			</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('departamento', HTML::image('images/iconosmenu/Paises.png','Imagen no encontrada',array('width'=>'48','title' => 'Departamentos')))) !!}
			</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('ciudad', HTML::image('images/iconosmenu/Ciudades.png','Imagen no encontrada',array('width'=>'48','title' => 'Ciudades')))) !!}
			</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('tipoidentificacion', HTML::image('images/iconosmenu/Tipos%20Identificacion.png','Imagen no encontrada',array('width'=>'48','title' => 'Tipos de Identificacion')))) !!}
			</center></li>
		<li><center>
			{!! HTML::decode(HTML::link('compania', HTML::image('images/iconosmenu/Companias.png','Imagen no encontrada',array('width'=>'48','title' => 'Compañías')))) !!}
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