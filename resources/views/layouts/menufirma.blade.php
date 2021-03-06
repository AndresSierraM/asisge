<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link type="image/x-icon" rel="icon" href="{!!('images/Logo-sisoft.png')!!}">

 	@yield('clases')

 	   {!!Html::script('assets/jquery-v2.1.4/jquery-2.1.4.min.js'); !!}
 	    {!!Html::script('choosen/chosen.jquery.js'); !!}
	{!!Html::style('css/menu.css'); !!}
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
	
	{!!Html::script('assets/bootstrap-v3.3.5/js/bootstrap.min.js'); !!}
	{!!Html::script('js/menu.js'); !!}

      
      {!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
      {!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}
      {!!Html::style('assets/tutorial/css/main.css'); !!}
      {!!Html::style('assets/tutorial/css/callouts.css'); !!}
      
      {!!Html::style('choosen/docsupport/style.css'); !!}
      {!!Html::style('choosen/docsupport/prism.css'); !!}
      {!!Html::style('choosen/chosen.css'); !!}
      
      <!-- {!!Html::style('sb-admin/bower_components/metisMenu/dist/metisMenu.min.css'); !!} -->
      {!!Html::style('sb-admin/dist/css/sb-admin-2.css'); !!}
      <!-- {!!Html::style('sb-admin/bower_components/font-awesome/css/font-awesome.min.css'); !!} -->
      {!!Html::style('sb-admin/bower_components/datetimepicker/css/bootstrap-datetimepicker.min.css'); !!}
      {!!Html::style('sb-admin/bower_components/fileinput/css/fileinput.css'); !!}
      {!!Html::style('sb-admin/bower_components/select2/css/select2.min.css'); !!}

      <!-- estilos para el PAD de Firmas -->
      {!!Html::style('css/signature-pad.css'); !!}

      <!--{!!Html::style('sb-admin/bower_components/ckeditor/sample.css'); !!}-->
      <!-- {!!Html::style('css/menu.css'); !!} -->
      {!!Html::style('css/menu.css'); !!}
      {!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
  
      <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>

      
      {!!Html::script('assets/tutorial/js/ie10-viewport-bug-workaround.js'); !!}
      {!!Html::script('assets/tutorial/js/ie-emulation-modes-warning.js'); !!}
   
      
      {!!Html::script('assets/tutorial/js/helpers.js'); !!}
      {!!Html::script('assets/tutorial/js/base.js'); !!}
      {!!Html::script('sb-admin/bower_components/datetimepicker/js/moment.js'); !!}
      {!!Html::script('sb-admin/bower_components/datetimepicker/js/bootstrap-datetimepicker.min.js'); !!}
      {!!Html::script('sb-admin/bower_components/fileinput/js/fileinput.js'); !!}
      {!!Html::script('sb-admin/bower_components/fileinput/js/fileinput_locale_es.js'); !!}
      {!!Html::script('sb-admin/bower_components/select2/js/select2.min.js'); !!}
     
      {!!Html::script('choosen/docsupport/prism.js'); !!}
      {!!Html::script('sb-admin/bower_components/ckeditor/ckeditor.js'); !!}
      {!!Html::script('js/general.js')!!}

      <!-- Librerías de graficos morris y flot -->
      <!-- {!!Html::script('sb-admin/bower_components/morrisjs/morris.js'); !!}
      {!!Html::script('sb-admin/bower_components/morrisjs/morris.css'); !!}
      {!!Html::script('sb-admin/bower_components/flot/jquery.flot.js'); !!} -->
      
      <!-- Radio buttons y checkbox con estilo  -->
      {!! Html::style('css/segmented-controls.css'); !!}

      {!!Html::script('js/app1.js'); !!}


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

        <!--  <script>
          function VerificarAbandono(){
            c = confirm('Esta seguro de abandonar la pagina?');
            if(c == true){
              window.location = 'http://www.url_de_la_otra_web.com';
            }
            else{
              return false;
            }
          }
          
        </script>
        <body id='formulario' onbeforeunload="VerificarAbandono()" >
        -->
 

	<title>Sisoft</title>
</head>
<body id='body' onclick="cierraMenu(1);">

	<div id="header">
		<div id="container">
		<div class="barramenufirma">
			
		<?php

						// -------------------------------------------
						// O P C I O N E S   S E G U N   E L   R O L 
						// D E L   U S U A R I O 
						// -------------------------------------------
						 $opciones = DB::select(
				          'SELECT O.idOpcion,
				           P.nombrePaquete,
				           P.iconoPaquete,
				           O.nombreOpcion,
				           O.nombreCortoOpcion,
				           O.iconoOpcion,
				           O.rutaOpcion
				       FROM users U
				       left join rol R
				       on U.Rol_idRol = R.idRol
				       left join rolopcion RO
				       on U.Rol_idRol = RO.Rol_idRol
				       left join opcion O
				       on RO.Opcion_idOpcion = O.idOpcion
				       left join paquete P
				       on O.Paquete_idPaquete = P.idPaquete
				       where  U.id = '.\Session::get("idUsuario").' and
				        O.permiteFirmaOpcion = 1 AND RO.firmarRolOpcion = 1
				        GROUP BY O.idOpcion				      
				        ORDER BY O.ordenOpcion, P.nombrePaquete;');

						
					foreach ($opciones as $idO => $datosO) 
					{
					
						echo 
						'
						&nbsp;
						<div id="Opcion" class="menu" align="center" >
							<a href="http://'.$_SERVER["HTTP_HOST"].'/'.$datosO->rutaOpcion.'"> <img src="http://'.$_SERVER["HTTP_HOST"].'/imagenes/'.$datosO->iconoOpcion.'" title="'.$datosO->nombreOpcion.'" style="width:38px; height:48px;"><br>
								'.$datosO->nombreCortoOpcion.'
							</a>
							</div>
						';
					}
					
			
		
				echo 
				'<div id="menuuser1" class="menu" style="float: right; width: 30px;height:38px">
		            <div>
        		         '.\Session::get("nombreUsuario").'
						<a href="http://'.$_SERVER["HTTP_HOST"].'/auth/logout"> <img src="http://'.$_SERVER["HTTP_HOST"].'/images/iconosmenu/salir.png" title="Salir de SiSoft" style="width:32px; height:32px;">
						</a>
					</div>
				</div>

			';
		?>




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

