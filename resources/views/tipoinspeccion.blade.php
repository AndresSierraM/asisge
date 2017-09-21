@extends('layouts.vista')
@section('titulo')
  <h3 id="titulo">
    <center>Tipo de Inspecci&oacute;n</center>
  </h3>
@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/tipoinspeccion.js')!!}
<script>
  var tipoInspeccionPregunta = '<?php echo (isset($tipoInspeccion) ? json_encode($tipoInspeccion->tipoInspeccionPreguntas) : "");?>';
  tipoInspeccionPregunta = (tipoInspeccionPregunta != '' ? JSON.parse(tipoInspeccionPregunta) : '');
  var valorDetalle = [0,''];
  

  $(document).ready(function(){
    
    detalle = new Atributos('detalle','contenedor_detalle','detalle_');

    detalle.altura = '36px;';
    detalle.campoid = 'idTipoInspeccionPregunta';
    detalle.campoEliminacion = 'eliminarDetalle';

    detalle.campos = ['idTipoInspeccionPregunta','numeroTipoInspeccionPregunta','contenidoTipoInspeccionPregunta'];
    detalle.etiqueta = ['input','input','input'];
    detalle.tipo = ['hidden','text','text'];
    detalle.estilo = ['','width: 5%;height:35px;','width: 90%;height:35px;'];
    detalle.clase = ['','',''];
    detalle.sololectura = [false,false,false];
    var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
    detalle.funciones  = ['','',quitacarac];

   
    for(var j=0, k = tipoInspeccionPregunta.length; j < k; j++)
    {
        detalle.agregarCampos(JSON.stringify(tipoInspeccionPregunta[j]),'L');
    }
    document.getElementById('registros').value = j ;

  });
</script>
  
	@if(isset($tipoInspeccion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoInspeccion,['route'=>['tipoinspeccion.destroy',$tipoInspeccion->idTipoInspeccion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoInspeccion,['route'=>['tipoinspeccion.update',$tipoInspeccion->idTipoInspeccion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipoinspeccion.store','method'=>'POST'])!!}
	@endif

<?php 
  $fechahora = Carbon\Carbon::now();
?>

<div id='form-section' >

	<fieldset id="frecuenciaMedicion-form-fieldset">	
		<div class="form-group required" id='test'>
          {!!Form::label('codigoTipoInspeccion', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
              {!!Form::text('codigoTipoInspeccion',null,['class'=>'form-control','placeholder'=>'Ingresa el código del tipo de Inspecci&oacute;n'])!!}
              {!!Form::hidden('idTipoInspeccion', null, array('id' => 'idTipoInspeccion')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}
              {!!Form::hidden('eliminarDetalle', '', array('id' => 'eliminarDetalle'))!!}
            </div>
          </div>
    </div>
    <div class="form-group required" id='test'>
        {!!Form::label('nombreTipoInspeccion', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group ">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o "></i>
            </span>
			     {!!Form::text('nombreTipoInspeccion',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del tipo de Inspecci&oacute;n',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
          </div>
      </div>
    </div>
      
      <div class="form-group required" >
        {!!Form::label('FrecuenciaMedicion_idFrecuenciaMedicion', 'Frecuencia de Medici&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
        <div class="col-sm-10" >
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-credit-card" ></i>
            </span>
            {!!Form::select('FrecuenciaMedicion_idFrecuenciaMedicion',$frecuenciaMedicion, (isset($tipoInspeccion) ? $tipoInspeccion->frecuenciaMedicion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la frecuencia de medici&oacute;n"])!!}
          </div>
        </div>
      </div>

      <div class="form-group" >
        {!!Form::label('fechaInicialTipoInspeccion', 'Fecha Inicial', array('class' => 'col-sm-2 control-label'))!!}
        <div class="col-sm-10" >
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-credit-card" ></i>
            </span>
            {!!Form::text('fechaInicialTipoInspeccion',(isset($tipoInspeccion) ? $tipoInspeccion->fechaInicialTipoInspeccion : $fechahora),['class'=>'form-control'])!!}
          </div>
        </div>
      </div>

      <div class="form-group" id='test'>
        <div class="col-sm-12">
          <div class="row show-grid">
              <div class="col-md-1" style="width: 40px;" onclick="detalle.agregarCampos(valorDetalle,'A')">
                <span class="glyphicon glyphicon-plus"></span>
              </div>
              <div class="col-md-1 requiredMulti" style="width: 5%;">No.</div>
              <div class="col-md-1 requiredMulti" style="width: 90%;">Pregunta</div>
              <div id="contenedor_detalle">
              </div>
          </div>
        </div>
      </div> 
    </fieldset>
  

    @if(isset($tipoInspeccion))
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
  $('#fechaInicialTipoInspeccion').datetimepicker(({
			format: "YYYY-MM-DD"
		}));
</script>
@stop