@extends('layouts.vista')

@section('titulo')
	<h3 id="titulo">
		<center>Preguntas Lista Chequeo</center>
	</h3>
@stop


@section('content')

	@include('alerts.request')
	<script>
		var preguntaListaChequeo = '<?php echo (isset($preguntaListaChequeo) ? json_encode($preguntaListaChequeo) : "");?>';
		preguntaListaChequeo = (preguntaListaChequeo != '' ? JSON.parse(preguntaListaChequeo) : '');

		var valorPregunta = [0,0,''];

		$(document).ready(function(){

			pregunta = new Atributos('pregunta','contenedor_pregunta','pregunta_');
			pregunta.campos = ['idPreguntaListaChequeo', 'ordenPreguntaListaChequeo','descripcionPreguntaListaChequeo'];
			pregunta.etiqueta = ['input','textarea','textarea'];
			pregunta.tipo = ['hidden','',''];
			pregunta.estilo = ['','width: 80px;height:35px;','width: 1000px;height:35px;'];
			pregunta.clase = ['','',''];
			pregunta.sololectura = [false,false,false];
			pregunta.completar = ['off','off','off'];
			pregunta.opciones = ['','',''];
			var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
			pregunta.funciones  = ['','',quitacarac];

			
			for(var j=0, k = preguntaListaChequeo.length; j < k; j++)
			{
				pregunta.agregarCampos(JSON.stringify(preguntaListaChequeo[j]),'L');
			}

		
		});

		
	</script>
	@if(isset($preguntaListaChequeo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($preguntaListaChequeo,['route'=>['preguntalistachequeo.destroy',0],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($preguntaListaChequeo,['route'=>['preguntalistachequeo.update',0],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'preguntalistachequeo.store','method'=>'POST'])!!}
	@endif

		<div id="form_section">
			<fieldset id="preguntalistachequeo-form-fieldset">
				<div class="form-group" id='test'>
					<div class="col-sm-12">
						<div class="row show-grid">
							<div class="col-md-1" style="width: 40px;height: 60px;" onclick="pregunta.agregarCampos(valorPregunta,'A')">
								<span class="glyphicon glyphicon-plus"></span>
							</div>
							<div class="col-md-1" style="width: 80px;display:inline-block;height:60px;">Orden</div>
							<div class="col-md-1" style="width: 1000px;display:inline-block;height:60px;">Pregunta</div>
							<div id="contenedor_pregunta">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
						</br></br></br></br>
					</div>
				</div>
		
               
			</fieldset>
		</div>
	{!!Form::close()!!}
	

@stop