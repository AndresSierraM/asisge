@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>¡¡Alerta!!</center></h3>@stop
@section('content')
@include('alerts.request')



                          
<div class="alerta-container">
      <form class="form-horizontal" action="" method="post">
         <legend class="text">
         <!-- Mediante php se concatena la varaible que se envia desde el destroy como parametros para recibirlos en alerta.blade -->
         <?php 
          //El 0 quiere decir  todo lo que se tiene (datos,informacion) y el -2 es que reste los dos ultimos caracteres (espacio y coma).
         // Finalmente,se utiliza el nombre de la variable que se creo que es la que contiene el nombre de las tablas  sin los ultimos dos caracteres
          $nombretablas=  substr($tablas, 0, -2);
          echo'Esta intentando eliminar un'.' '.'<b>'.$nombremodulo.'</b>'.' '.'que est&#225; relacionado en:<br>'.' '.'<b>'.$nombretablas.'</b>' 
         ?>
         
         </legend>    
          <!-- Se  hace un boton para que vuelva a la grid del Modulo..-->
         <?php echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.$nombremodulo.'" <input type="submit"class="btn btn-primary">Aceptar</a>'; ?>
         
       </form>
</div> 

    
   @stop                   