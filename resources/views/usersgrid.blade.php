@extends('layouts.principal')
@section('titulo')<h3 id="titulo"><center>Usuarios</center></h3>@stop

@section('content')

  <?php include ("../resources/views/usersgridphp.blade.php");?>
@stop