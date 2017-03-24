@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>¡¡Alerta!!</center></h3>@stop
@section('content')
@include('alerts.request')




                          
<div class="alerta-container">
      <form class="form-horizontal" action="" method="post">
         <legend class="text">
         <?php
          echo'Esta intentando eliminar un'.' '.'<b>'.$tercero.'</b>'.' '.'que est&#225; relacionado en:<br>'.' '.'<b>'.$tablas.'</b>' 
         ?>
         
         </legend>    
          <!-- Se hace un boton para dar atras con laravel-->
              <a href="{{ URL::previous() }}" class="btn btn-primary">Aceptar</a>     
       </form>
</div> 

    
   @stop
   

         

                   