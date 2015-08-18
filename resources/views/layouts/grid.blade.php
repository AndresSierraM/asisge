@extends('layouts.principal')
    
    @section('clases')

      {!! Html::style('assets/guriddosuito/css/jquery-ui.css'); !!}
      {!! Html::style('assets/guriddosuito/css/trirand/ui.jqgrid.css'); !!}
      {!! Html::style('assets/guriddosuito/css/ui.multiselect.css'); !!}
      <style type="text">
          html, body {
          margin: 0;			/* Remove body margin/padding */
      	padding: 0;
          overflow: hidden;	/* Remove scroll bars on browser window */
          font-size: 75%;
          }
  		
      </style>
      {!! Html::script('assets/guriddosuito/js/jquery.min.js'); !!}
      {!! Html::script('assets/guriddosuito/js/trirand/i18n/grid.locale-en.js'); !!}
      {!! Html::script('assets/guriddosuito/js/trirand/jquery.jqGrid.min.js'); !!}
      <script>     	  
      	$.jgrid.no_legacy_api = true;
      	$.jgrid.useJSON = true;
      	$.jgrid.defaults.width = "1150";
        $.jgrid.defaults.height = "200";
    	</script>
       {!! Html::script('assets/guriddosuito/js/jquery-ui.min.js'); !!}

     @stop