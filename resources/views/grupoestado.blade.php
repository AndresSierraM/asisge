@extends('layouts.vista')
@section('titulo')
  <h3 id="titulo">
    <center>Grupos de Estados</center>
  </h3>
@stop

@section('content')
@include('alerts.request')
{{$grupoEstado->estadoCRM}}
{!!Html::script('js/grupoestado.js')!!}
<script>
  var estadoCRM = '<?php echo (isset($grupoEstado) ? json_encode($grupoEstado->estadoCRM) : "");?>';
  estadoCRM = (estadoCRM != '' ? JSON.parse(estadoCRM) : '');
  var valorDetalle = [0,'', ''];
  

  $(document).ready(function(){
    
    detalle = new Atributos('detalle','contenedor_detalle','detalle_');

    detalle.altura = '36px;';
    detalle.campoid = 'idEstadoCRM';
    detalle.campoEliminacion = 'eliminarDetalle';

    detalle.campos = ['idEstadoCRM','nombreEstadoCRM','tipoEstadoCRM'];
    detalle.etiqueta = ['input','input','select'];
    detalle.tipo = ['hidden','text',''];
    detalle.estilo = ['','width: 400px;height:35px;','width: 400px;height:35px;'];
    detalle.clase = ['','',''];
    detalle.sololectura = [false,false,false];

   
    for(var j=0, k = estadoCRM.length; j < k; j++)
    {
        detalle.agregarCampos(JSON.stringify(estadoCRM[j]),'L');
    }
    document.getElementById('registros').value = j ;

  });
</script>
  
	@if(isset($grupoEstado))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($grupoEstado,['route'=>['grupoestado.destroy',$grupoEstado->idGrupoEstado],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($grupoEstado,['route'=>['grupoestado.update',$grupoEstado->idGrupoEstado],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'grupoestado.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="grupoestado-form-fieldset">	
		<div class="form-group" id='test'>
          {!!Form::label('codigoGrupoEstado', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
              {!!Form::text('codigoGrupoEstado',null,['class'=>'form-control','placeholder'=>'Ingresa el código del grupo'])!!}
              {!!Form::hidden('idGrupoEstado', null, array('id' => 'idGrupoEstado')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}
              {!!Form::hidden('eliminarDetalle', '', array('id' => 'eliminarDetalle'))!!}
            </div>
          </div>
    </div>
    <div class="form-group" id='test'>
        {!!Form::label('nombreGrupoEstado', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o "></i>
            </span>
			     {!!Form::text('nombreGrupoEstado',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del grupo'])!!}
          </div>
      </div>
      
      
      <div class="form-group" id='test'>
        <div class="col-sm-12">
          <div class="row show-grid">
              <div class="col-md-1" style="width: 40px;" onclick="detalle.agregarCampos(valorDetalle,'A')">
                <span class="glyphicon glyphicon-plus"></span>
              </div>
              <div class="col-md-1" style="width: 400px;">Estado</div>
              <div class="col-md-1" style="width: 400px;">Tipo</div>
              <div id="contenedor_detalle">
              </div>
          </div>
        </div>
      </div> 
    </fieldset>
  
      @if(isset($grupoEstado))
      {!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
    @else
      {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
    @endif

   

	{!! Form::close() !!}
	</div>
</div>
@stop