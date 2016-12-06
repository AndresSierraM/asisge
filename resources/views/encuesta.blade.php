@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Encuesta</center></h3>@stop

@section('content')
  <!-- @include('alerts.request') -->
  {!!Html::script('js/encuesta.js')!!}

<style type="text/css">
  .Pregunta
  {
    border: 3px solid gray;
    width: 100%;
    height: 300px;
    margin: 5px 5px 5px 5px; 
    padding: 5px 5px 5px 5px;

  }

  .Encuesta-Titulo 
  {
    border: 0;
    outline: 0;
    background: transparent;
    border-bottom: 2px solid black;
    font-size: 20px;
    width: 100%;
    margin: 5px 5px 5px 5px;
  }

  .Encuesta-Subtitulo 
  {
    border: 0;
    outline: 0;
    background: transparent;
    border-bottom: 2px solid gray;
    font-size: 16px;
    width: 100%;
    margin: 5px 5px 30px 5px;
  }

  .Encuesta-Tipo
  {
    border: 0;
    outline: 0;
    background: transparent;
    border-bottom: 2px solid gray;
    font-size: 16px;
    width: 100%;
    margin: 5px 5px 5px 5px;
  }

  /*select.Encuesta-Tipo option[value="Respuesta Corta"]   { background-image:url(division.png);   }
  select.Encuesta-Tipo option[value="Párrafo"] { background-image:url(mas.png); }
*/
  .Encuesta-Respuesta
  {
    background: transparent;
    font-size: 16px;
    width: 100%;
    padding: 5px 5px 5px 5px;
    margin: 5px 5px 5px 5px;
  }
</style>


<script>
    var EncuestaPregunta = '<?php echo (isset($encuesta) ? json_encode($encuesta->EncuestaPregunta) : "");?>';
    EncuestaPregunta = (EncuestaPregunta != '' ? JSON.parse(EncuestaPregunta) : '');

    
    var valorPregunta = [0,'',0,'0000-00-00','00:00',0];

    // var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    // var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
    // var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];
    // var eventos1 = ['onclick','fechaDetalle(this.parentNode.id);'];
    // var eventos2 = ['onchange','llenarCargo(this);'];

    $(document).ready(function(){


      pregunta = new Propiedades('pregunta','contenedor_pregunta','pregunta');

      pregunta.altura = '36px;';
      pregunta.campoid = 'idEncuestaPregunta';
      pregunta.campoEliminacion = 'eliminarPregunta';
      for(var j=0, k = EncuestaPregunta.length; j < k; j++)
      {
        pregunta.agregarPregunta(JSON.stringify(EncuestaPregunta[j]),'L');
        $("#tipoRespuestaEncuestaPregunta"+j).trigger("change");

        // Por cada Pregunta, insertamos las opciones de esta

      }

    });

  </script>


	@if(isset($encuesta))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($encuesta,['route'=>['encuesta.destroy',$encuesta->idEncuesta],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($encuesta,['route'=>['encuesta.update',$encuesta->idEncuesta],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'encuesta.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="encuesta-form-fieldset">	
		<div class="form-group" id='test'>
      {!!Form::label('tituloEncuesta', 'Título', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </span>
          {!!Form::text('tituloEncuesta',null,['class'=>'form-control','placeholder'=>'Ingrese el Título de la Encuesta'])!!}
          {!!Form::hidden('idEncuesta', null, array('id' => 'idEncuesta')) !!}
        </div>
      </div>
    </div>


		
		<div class="form-group" id='test'>
      {!!Form::label('descripcionEncuesta', 'Descripción', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o "></i>
          </span>
		      {!!Form::textarea('descripcionEncuesta',null,['class'=>'ckeditor','placeholder'=>'Ingresa la descripción de la Encuesta'])!!}
        </div>
      </div>
    </div>
    

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#preguntas">Preguntas</a></li>
      <li><a data-toggle="tab" href="#permisos">Permisos</a></li>
    </ul>

    <div class="tab-content">
      <div id="preguntas" class="tab-pane fade in active">
        
        <div id="contenedor_pregunta">
        </div>

      <!-- <div class="row show-grid"> -->
          <div class="col-md-1" style="width: 40px;height: 50px;"  onclick="pregunta.agregarPregunta(valorPregunta,'A')">
            <span class="fa fa-plus-square fa-2x"></span>
          </div>
          <div class="col-md-1" style="width: 40px;height: 50px;"  onclick="pregunta.agregarPregunta(valorPregunta,'A')">
            <span class="fa fa-pencil-square fa-2x"></span>
          </div>
          <div class="col-md-1" style="width: 40px;height: 50px;"  onclick="pregunta.agregarPregunta(valorPregunta,'A')">
            <span class="fa fa-photo fa-2x"></span>
          </div>
          <div class="col-md-1" style="width: 40px;height: 50px;"  onclick="pregunta.agregarPregunta(valorPregunta,'A')">
            <span class="fa fa-film fa-2x"></span>
          </div>
        <!-- </div> -->
          
      </div>
      <div id="permisos" class="tab-pane fade">


      </div>
    </div>

  </fieldset>


	@if(isset($encuesta))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif

	{!! Form::close() !!}
	</div>
</div>

<script>
    CKEDITOR.replace(('descripcionEncuesta'), {
        fullPage: true,
        allowedContent: true
      }); 
</script>

@stop