@extends('layouts.principal')

@section('content')
@include('alerts.errors')

{!! Form::open(array('url'=>'login')) !!}

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Acceso al sistema</title>
    
    
    <link href="CSS/centrado.css" rel="stylesheet">

</head>

<body>    
        <div id="contenedor">
            <form>
                <input type="text" name="email" id="nombre">
                <input type="password" name="password" id="password">
                <input type="checkbox" name="recordarme" id="recordarme">
                <label for="recordarme"></label>
                <p id="tex-recordarme">Recordame</p>
                <input type="submit" id="enviar" value="">
            </form>
        </div>
        <div id="footer">
            <img src="images/logo-02.png">
            <p>Sistema ... Todos los derechos reservados</p>
        </div>
</body>

</html>


		
	{!! Form::close() !!}
	</div>
</div>
@stop