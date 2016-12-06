
	
{!!Html::script('js/general.js')!!}

{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
{!!Html::script('assets/bootstrap-v3.3.5/js/bootstrap.min.js'); !!}

{!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}

<h3 id="titulo">
	<center>Preguntas Lista Chequeo</center>
</h3>




<script>	

	pregunta = new Atributos('pregunta','contenedor_pregunta','pregunta_');
	pregunta.altura = '50px;';
	pregunta.campos = ['idPreguntaListaChequeo', 'ordenPreguntaListaChequeo','descripcionPreguntaListaChequeo'];
	pregunta.etiqueta = ['input','textarea','textarea'];
	pregunta.tipo = ['hidden','',''];
	pregunta.estilo = ['','width: 80px;height:35px;','width: 1000px;height:35px;'];

	pregunta.clase = ['','',''];
	pregunta.sololectura = [false,false,false];
	pregunta.completar = ['off','off','off'];
	pregunta.opciones = ['','',''];
	pregunta.funciones  = ['','',''];

</script>



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