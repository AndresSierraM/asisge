@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Seleccione las Opciones</center></h3>@stop

@section('content')
	<button id="getselected">OK</button>
  <?php include ("../resources/views/opciongridphpselect.blade.php");?>
@stop