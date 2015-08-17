<!DOCTYPE html>
<html lang="es">
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

	{!! Html::style('assets/guriddosuito/css/jquery-ui.css'); !!}
    {!! Html::style('assets/guriddosuito/css/trirand/ui.jqgrid.css'); !!}
    {!! Html::style('assets/guriddosuito/css/ui.multiselect.css'); !!}
    {!! Html::script('assets/guriddosuito/js/jquery.min.js'); !!}
    {!! Html::script('assets/guriddosuito/js/trirand/i18n/grid.locale-en.js'); !!}
    {!! Html::script('assets/guriddosuito/js/trirand/jquery.jqGrid.min.js'); !!}

  	<script>     	  
		$.jgrid.no_legacy_api = true;
		$.jgrid.useJSON = true;
		$.jgrid.defaults.width = "1150";
		$.jgrid.defaults.height = "300";
	</script>

    {!! Html::script('assets/guriddosuito/js/jquery-ui.min.js'); !!}

	{!!Html::style('CSS/principal.css'); !!}
	
	<title>Asisge S.A.</title>

</head>
<body id='body'>
	
	<nav>
        <ul>
        <li><center>Logo<center></li>
        <li><center><a href="users" >
 			<img src="images/iconosmenu/usuarios.png" width="48" title="Usuarios" />
		</a></center></li>
		<li><center><a href="paquete" >
 			<img src="images/iconosmenu/Opciones%20Seguridad.png" width="48" title="Paquetes del menu" />
		</a></center></li>
		<li><center><a href="opcion">
 			<img src="images/iconosmenu/Opciones%20Generales.png" width="48" title="Opciones del menu" />
		</a></center></li>
		<li><center><a href="pais">
 			<img src="images/iconosmenu/Paises.png" width="48" title="Paises" />
		</a></center></li>
		<li><center><a href="departamento">
 			<img src="images/iconosmenu/Paises.png" width="48" title="Departamentos" />
		</a></center></li>
		<li><center><a href="ciudad">
 			<img src="images/iconosmenu/Ciudades.png" width="48" title="Ciudades" />
		</a></center></li>
		<li><center><a href="tipoidentificacion">
 			<img src="images/iconosmenu/Tipos%20Identificacion.png" width="48" title="Tipos de Identificacion" />
		</a></center></li>
		<li><center><a href="compania">
 			<img src="images/iconosmenu/Companias.png" width="48" title="Compañías" />
		</a></center></li>
		<li><center><a href="frecuenciamedicion">
 			<img src="images/iconosmenu/Frecuencia%20Medicion.png" width="48" title="Frecuencias de Medicion" />
		</a></center></li>
		<li><center><a href="proceso">
 			<img src="images/iconosmenu/Procesos.png" width="48" title="Procesos" />
		</a></center></li>
		<li><center><a href="tercero">
 			<img src="images/iconosmenu/Terceros.png" width="48" title="Terceros" />
		</a></center></li>
		<li><center><a href="">
 			<img src="images/iconosmenu/salir-01.png" width="48" title="Salir" />
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
