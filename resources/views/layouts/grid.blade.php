@extends('layouts.menu')
    
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
        $.jgrid.defaults.height = "300";
    	</script>
       {!! Html::script('assets/guriddosuito/js/jquery-ui.min.js'); !!}


      
<!--       {!!Html::script('DataTables/media/js/jquery.dataTables.js'); !!}
      {!!Html::style('DataTables/media/css/jquery.dataTables.min.css'); !!}
          {!!Html::script('DataTables/media/js/jquery.js'); !!}
      <style type="text/css">
            a
            {
                color: #000;
            }   

            input[type=search]
            {
                width: 150px;
                height: 30px;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
        </style>
    
 -->
     @stop