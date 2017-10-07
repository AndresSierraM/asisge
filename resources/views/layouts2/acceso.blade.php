<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	

	{!!Html::style('css/centrado.css'); !!}
	{!!Html::style('choosen/docsupport/style.css'); !!}
      {!!Html::style('choosen/docsupport/prism.css'); !!}
      {!!Html::style('choosen/chosen.css'); !!}

       <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>

      {{--  {!!Html::script('assets/jquery-v2.1.4/jquery-2.1.4.min.js'); !!}  --}}
      {!!Html::script('jquery/jquery-2-2-3.min.js'); !!}  --}}
      
      {!!Html::script('choosen/chosen.jquery.js'); !!}
      {!!Html::script('choosen/docsupport/prism.js'); !!}

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
	
	<title>SiSoft</title>

</head>
<body id='body'>
	
		
	<div id="contenedor-fin">
	    <div id="pantalla">
	       @yield('content') 
	    </div>
	</div>

	<div id="footer">
	    <center><p>SiSoft - Sistema de Gestion en Salud Ocupacional... Asisge S.A.S.- Todos los derechos reservados</p></center>
	</div>
</body>
</html>
