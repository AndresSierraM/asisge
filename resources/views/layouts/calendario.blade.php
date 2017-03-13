@extends('layouts.menudinamico')

    @section('clases')

      
      {!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
      {!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}
      {!!Html::style('assets/tutorial/css/main.css'); !!}
      {!!Html::style('assets/tutorial/css/callouts.css'); !!}
      
      <!-- {!!Html::style('choosen/docsupport/style.css'); !!}
      {!!Html::style('choosen/docsupport/prism.css'); !!}
      {!!Html::style('choosen/chosen.css'); !!} -->
      
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
      {!!Html::script('assets/jquery-v2.1.4/jquery-2.1.4.min.js'); !!}
      
      {!!Html::script('assets/tutorial/js/helpers.js'); !!}
      {!!Html::script('assets/tutorial/js/base.js'); !!}
      <!-- {!!Html::script('sb-admin/bower_components/datetimepicker/js/bootstrap-datetimepicker.min.js'); !!} -->
      <!-- {!!Html::script('sb-admin/bower_components/fileinput/js/fileinput.js'); !!}
      {!!Html::script('sb-admin/bower_components/fileinput/js/fileinput_locale_es.js'); !!}
      {!!Html::script('sb-admin/bower_components/select2/js/select2.min.js'); !!} -->
      <!-- {!!Html::script('choosen/chosen.jquery.js'); !!}
      {!!Html::script('choosen/docsupport/prism.js'); !!} -->
      <!-- {!!Html::script('sb-admin/bower_components/ckeditor/ckeditor.js'); !!} -->
      {!!Html::script('js/general.js')!!}

      {!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
      {!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}

      <!-- ABRE LIBRERÍA DE AGENDA -->
      <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
      <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

      {!!Html::style('bower_components/bootstrap-calendar/css/calendar.css'); !!}  

      {!!Html::script('bower_components/bootstrap-calendar/js/language/es-ES.js'); !!}
      {!!Html::script('bower_components/underscore/underscore-min.js'); !!}
      {!!Html::script('bower_components/bootstrap-calendar/js/calendar.js'); !!}
      {!!Html::script('bower_components/moment/moment.js'); !!}

      {!!Html::script('bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js'); !!}
      {!!Html::script('bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js'); !!}
      {!!Html::script('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); !!}
      {!!Html::script('bower_components/eonasdan-bootstrap-datetimepicker/bootstrap/bootstrap.min.js'); !!}
      {!!Html::script('bower_components/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.es.js'); !!}

      {!! Html::style('css/segmented-controls.css'); !!}


      <!--   <script type="text/javascript">
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
        </script> -->

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
        
     @stop