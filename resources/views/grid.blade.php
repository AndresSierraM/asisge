@extends('layouts.menudinamico')
    
    @section('clases')

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

        <!-- Librerias para las grid (Exportado en Excel) -->
        <!-- DataTables -->
        {!!Html::script('DataTables/media/js/jquery.dataTables.js'); !!}
        {!!Html::style('DataTables/media/css/jquery.dataTables.min.css'); !!}
        <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
        <!-- <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> -->
        <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
        <style>
        /*Cerrado Librerias Excel*/
               
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