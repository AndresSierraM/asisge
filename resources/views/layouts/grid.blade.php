@extends('layouts.menudinamico')
    
    @section('clases')

      {!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
      {!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}

      <style type="text">
          html, body {
          margin: 0;			/* Remove body margin/padding */
      	padding: 0;
          overflow: hidden;	/* Remove scroll bars on browser window */
          font-size: 75%;
          }
  		
      </style>

      <!-- DataTables -->
        {!!Html::script('DataTables/media/js/jquery.js'); !!}
        {!!Html::script('DataTables/media/js/jquery.dataTables.js'); !!}
        {!!Html::style('DataTables/media/css/jquery.dataTables.min.css'); !!}
               
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
     @stop