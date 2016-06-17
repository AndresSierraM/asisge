@extends('layouts.vista')
@section('titulo')
  <h3 id="titulo">
    <center>Tipo de Riesgos</center>
  </h3>
@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/tiporiesgo.js')!!}
<script>
  var tipoRiesgoDetalle = '<?php echo (isset($tipoRiesgo) ? json_encode($tipoRiesgo->tipoRiesgoDetalles) : "");?>';
  tipoRiesgoDetalle = (tipoRiesgoDetalle != '' ? JSON.parse(tipoRiesgoDetalle) : '');
  var valorDetalle = [0,''];
  var tipoRiesgoSalud = '<?php echo (isset($tipoRiesgo) ? json_encode($tipoRiesgo->tipoRiesgoSaluds) : "");?>';
  tipoRiesgoSalud = (tipoRiesgoSalud != '' ? JSON.parse(tipoRiesgoSalud) : '');
  var valorSalud = [0,''];

  $(document).ready(function(){
    
    detalle = new Atributos('detalle','contenedor_detalle','detalle_');
    
    detalle.altura = '36px;';
    detalle.campoid = 'idTipoRiesgoDetalle';
    detalle.campoEliminacion = 'eliminarDetalle';

    detalle.campos = ['idTipoRiesgoDetalle','nombreTipoRiesgoDetalle'];
    detalle.etiqueta = ['input','input'];
    detalle.tipo = ['hidden','text'];
    detalle.estilo = ['','width: 950px;height:35px;'];
    detalle.clase = ['',''];
    detalle.sololectura = [false,false];

    salud = new Atributos('salud','contenedor_salud','salud_');

    salud.altura = '36px;';
    salud.campoid = 'idTipoRiesgoSalud';
    salud.campoEliminacion = 'eliminarSalud';
    
    salud.campos = ['idTipoRiesgoSalud','nombreTipoRiesgoSalud'];
    salud.etiqueta = ['input','input'];
    salud.tipo = ['hidden','text'];
    salud.estilo = ['','width: 950px;height:35px;'];
    salud.clase = ['',''];
    salud.sololectura = [false,false];

    for(var j=0, k = tipoRiesgoDetalle.length; j < k; j++)
    {
        detalle.agregarCampos(JSON.stringify(tipoRiesgoDetalle[j]),'L');
    }

    for(var j=0, k = tipoRiesgoSalud.length; j < k; j++)
    {
        salud.agregarCampos(JSON.stringify(tipoRiesgoSalud[j]),'L');
    }
  });
</script>
  
	@if(isset($tipoRiesgo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoRiesgo,['route'=>['tiporiesgo.destroy',$tipoRiesgo->idTipoRiesgo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoRiesgo,['route'=>['tiporiesgo.update',$tipoRiesgo->idTipoRiesgo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tiporiesgo.store','method'=>'POST'])!!}
	@endif



<div id='form-section' >

	<fieldset id="clasificacionRiesgo-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoTipoRiesgo', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
              {!!Form::text('codigoTipoRiesgo',null,['class'=>'form-control','placeholder'=>'Ingresa el código del tipo de riesgo'])!!}
              {!!Form::hidden('idTipoRiesgo', null, array('id' => 'idTipoRiesgo')) !!}
              {!!Form::hidden('eliminarDetalle', '', array('id' => 'eliminarDetalle'))!!}
              {!!Form::hidden('eliminarSalud', '', array('id' => 'eliminarSalud'))!!}
            </div>
          </div>
    </div>
    <div class="form-group" id='test'>
        {!!Form::label('nombreTipoRiesgo', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o "></i>
            </span>
			     {!!Form::text('nombreTipoRiesgo',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del tipo de riesgo'])!!}
          </div>
      </div>
      <div class="form-group" >
        {!!Form::label('origenTipoRiesgo', 'Origen', array('class' => 'col-sm-2 control-label'))!!}
        <div class="col-sm-10" >
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-credit-card" ></i>
            </span>
            {!!Form::select('origenTipoRiesgo',
            array('AMBIENTAL'=>'Ambiental','SALUD'=>'Salud'), (isset($tipoRiesgo) ? $tipoRiesgo->origenTipoRiesgo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el origen del tipo de riesgo"])!!}
          </div>
        </div>
      </div>
      <div class="form-group" >
        {!!Form::label('ClasificacionRiesgo_idClasificacionRiesgo', 'Clasificaci&oacute;n de Riesgo', array('class' => 'col-sm-2 control-label'))!!}
        <div class="col-sm-10" >
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-credit-card" ></i>
            </span>
            {!!Form::select('ClasificacionRiesgo_idClasificacionRiesgo',$clasificacionRiesgo, (isset($tipoRiesgo) ? $tipoRiesgo->clasificacionRiesgo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de identificaci&oacute;n"])!!}
          </div>
        </div>
      </div>

      <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Detalles</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#mision">Descripci&oacute;n</a>
                      </h4>
                    </div>
                    <div id="mision" class="panel-collapse collapse in">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                                <div class="col-md-1" style="width: 40px;" onclick="detalle.agregarCampos(valorDetalle,'A')">
                                  <span class="glyphicon glyphicon-plus"></span>
                                </div>
                                <div class="col-md-1" style="width: 950px;">Nombre</div>
                                <div id="contenedor_detalle">
                                </div>
                            </div>
                          </div>
                        </div>  
                      </div> 
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#vision">Consecuencias</a>
                      </h4>
                    </div>
                    <div id="vision" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                                <div class="col-md-1" style="width: 40px;" onclick="salud.agregarCampos(valorSalud,'A')">
                                  <span class="glyphicon glyphicon-plus"></span>
                                </div>
                                <div class="col-md-1" style="width: 950px;">Nombre</div>
                                <div id="contenedor_salud">
                                </div>
                            </div>
                          </div>
                        </div>   
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>
    
	 @if(isset($tipoRiesgo))
      {!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
    @else
      {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
    @endif


	{!! Form::close() !!}
	</div>
</div>
@stop