@extends('layouts.acceso')

@section('content')
@include('alerts.errors')



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Acceso al sistema</title>
    
    
    <link href="CSS/centrado.css" rel="stylesheet">

</head>

<body>    
        <div id="contenedor">
            <div id="contenedor">
            {!! Form::open(['route' => 'auth/login', 'class' => 'form'])!!}
                {!!Form::email('email','',['class'=> 'form-control','id'=>'nombre'])!!}
                {!!Form::password('password', ['class'=> 'form-control','id'=>'password'])!!}
                
                <p id="tex-recordarme">Recordame</p>
                {!! Form::submit('',['id' => 'enviar']) !!}
            {!!Form::close()!!}
        </div>
        <div id="footer">
            <img src="images/logo-02.png">
            <p>Sistema ... Todos los derechos reservados</p>
        </div>
      </body>

</html>



	</div>
</div>
@stop