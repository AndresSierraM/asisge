@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Procesos</center></h3>@stop

@section('content')
  @include('alerts.request')

{!!Html::script('js/tiporiesgo.js')!!}
<script>
  var ProcesoOperacion = '<?php echo (isset($proceso) ? json_encode($proceso->ProcesoOperacion) : "");?>';
  ProcesoOperacion = (ProcesoOperacion != '' ? JSON.parse(ProcesoOperacion) : '');
  
  var valorDetalle = [0,0,'',0,''];

  
  $(document).ready(function(){
    
    detalle = new Atributos('detalle','contenedor_detalle','detalle_');
    
    detalle.altura = '36px;';
    detalle.campoid = 'idProcesoOperacion';
    detalle.campoEliminacion = 'eliminarOperacion';

    detalle.campos = ['idProcesoOperacion', 'ordenProcesoOperacion', 'nombreProcesoOperacion', 'samProcesoOperacion', 'observacionProcesoOperacion'];
    detalle.etiqueta = ['input','input','input','input','input'];
    detalle.tipo = ['hidden','text','text','text','text'];
    detalle.estilo = ['','width: 60px;height:35px; text-align: right;','width: 500px;height:35px;','width: 100px;height:35px; text-align: right;','width: 400px;height:35px;'];
    detalle.clase = ['','','','',''];
    detalle.sololectura = [false,false,false,false,false];
    var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
    detalle.funciones  = ['',quitacarac,quitacarac,quitacarac,quitacarac];

    
    for(var j=0, k = ProcesoOperacion.length; j < k; j++)
    {
        detalle.agregarCampos(JSON.stringify(ProcesoOperacion[j]),'L');
    }

   
  });
</script>


	@if(isset($proceso))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($proceso,['route'=>['proceso.destroy',$proceso->idProceso],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($proceso,['route'=>['proceso.update',$proceso->idProceso],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'proceso.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >
	<fieldset id="proceso-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoProceso', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoProceso',null,['class'=>'form-control','placeholder'=>'Ingresa el código del Proceso'])!!}
              {!! Form::hidden('idProceso', null, array('id' => 'idProceso')) !!}
              {!! Form::hidden('tipoProceso', $tipo, array('id' => 'tipoProceso')) !!}
              {!! Form::hidden('eliminarOperacion', null, array('id' => 'eliminarOperacion')) !!}
              
            </div>
          </div>
        </div>


		
		<div class="form-group" id='test'>
          {!! Form::label('nombreProceso', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				{!!Form::text('nombreProceso',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del Proceso',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
        </div>
    </fieldset>

<?php 
  if(isset($tipo) and $tipo == 'P')
  {
    ?> 
    <div class="panel-body">
      <div class="form-group" id='test'>
        <div class="col-sm-12">
          <div class="row show-grid">
              <div class="col-md-1" style="width: 40px;" onclick="detalle.agregarCampos(valorDetalle,'A')">
                <span class="glyphicon glyphicon-plus"></span>
              </div>
              <div class="col-md-1" style="width: 60px;">Orden</div>
              <div class="col-md-1" style="width: 500px;">Operación</div>
              <div class="col-md-1" style="width: 100px;"><span title="Tiempo estándar en minutos">Min/Und</span></div>
              <div class="col-md-1" style="width: 400px;">Observaciones</div>
              <div id="contenedor_detalle">
              </div>
          </div>
        </div>
      </div>  
    </div> 

<?php } ?>

    <br>
	@if(isset($proceso))
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
@stop