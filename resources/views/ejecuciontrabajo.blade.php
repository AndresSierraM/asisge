@extends('layouts.grid')

@section('titulo')<h3 id="titulo"><center>Ejecución de Trabajo</center></h3>@stop

@section('content')
@include('alerts.request')


<script type="">
  var idOrdenTrabajo ='<?php echo isset($ejecuciontrabajo) ? $ejecuciontrabajo->OrdenTrabajo_idOrdenTrabajo : "";?>'; 
  var idTipoCalidad = '<?php echo isset($idTipoCalidad) ? $idTipoCalidad : "";?>';
  var nombreTipoCalidad = '<?php echo isset($nombreTipoCalidad) ? $nombreTipoCalidad : "";?>';
  var tipocalidad = [JSON.parse(idTipoCalidad),JSON.parse(nombreTipoCalidad)];

  var detalles = '<?php echo (isset($detalle) ? json_encode($detalle) : "");?>';
  detalles = (detalles != '' ? JSON.parse(detalles) : '');

  valorDetalle = Array(0, 0, '', 0);
</script>

{!!Html::script('js/ejecuciontrabajo.js')!!}


	@if(isset($ejecuciontrabajo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($ejecuciontrabajo,['route'=>['ejecuciontrabajo.destroy',$ejecuciontrabajo->idEjecucionTrabajo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($ejecuciontrabajo,['route'=>['ejecuciontrabajo.update',$ejecuciontrabajo->idEjecucionTrabajo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'ejecuciontrabajo.store','method'=>'POST'])!!}
	@endif

<?php 
  $fechahora = Carbon\Carbon::now();
?>



<div id='form-section' >
	<fieldset id="ejecuciontrabajo-form-fieldset">	
    

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroEjecucionTrabajo', 'Número E.T.', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('numeroEjecucionTrabajo',(isset($ejecuciontrabajo) ? null : 'Automático'),['class'=>'form-control', "placeholder" => "Número Ejecución Trabajo", "readOnly"=>"readOnly"])!!}
            {!!Form::hidden('idEjecucionTrabajo',null,['id'=>'idEjecucionTrabajo'])!!}
            {!!Form::hidden('eliminarDetalle',null,['id'=>'eliminarDetalle'])!!}
           
            <input type="hidden" id="token" value="{{csrf_token()}}"/>
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('fechaElaboracionEjecucionTrabajo', 'Fecha Elaboración', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('fechaElaboracionEjecucionTrabajo',(isset($ejecuciontrabajo) ? $ejecuciontrabajo->fechaElaboracionEjecucionTrabajo : $fechahora),['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4 requiredMulti">
        {!!Form::label('OrdenTrabajo_idOrdenTrabajo', 'Número O.T                                                                                                                                                                                                                                                                                                                                                                       .', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('OrdenTrabajo_idOrdenTrabajo',$ordentrabajo, @$ejecuciontrabajo->OrdenTrabajo_idOrdenTrabajo,["onchange" => "cargarDatosOrdenTrabajo();cargarDatosEjecucionTrabajoPendiente();", "class" => "chosen-select form-control", "placeholder" => "Seleccione la Orden de Trabajo"])!!}
        </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroOrdenProduccion', 'Número O.P', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
            {!!Form::text('numeroOrdenProduccion',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
        </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('nombreProceso', 'Proceso', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
            {!!Form::text('nombreProceso',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
        </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('nombreCompletoTercero', 'Cliente', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
            {!!Form::text('nombreCompletoTercero',(isset($ejecuciontrabajo) ? $ejecuciontrabajo->nombreCompletoTercero : ''),['readonly'=>'readonly', 'class'=>'form-control'])!!}
        </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroPedidoEjecucionTrabajo', 'Orden Compra No.', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('numeroPedidoEjecucionTrabajo',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('referenciaFichaTecnica', 'Referencia', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('referenciaFichaTecnica',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('nombreFichaTecnica', 'Descripción', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('nombreFichaTecnica',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  
    
    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('especificacionEjecucionTrabajo', 'Especificación', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('especificacionEjecucionTrabajo',null,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('estadoEjecucionTrabajo', 'Estado', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('estadoEjecucionTrabajo', @$ejecuciontrabajo->estadoEjecucionTrabajo,['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4 requiredMulti">
        {!!Form::label('cantidadEjecucionTrabajo', 'Cantidad', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::hidden('cantidadPendiente',null,['id'=>'cantidadPendiente'])!!}
            {!!Form::text('cantidadEjecucionTrabajo',null,['class'=>'form-control', "placeholder" => "Cantidad a producir", "readOnly" => "readOnly"])!!}
          </div>
      </div>
    </div> 
  </fieldset>

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#detalle">Cantidades</a></li>
  </ul>

  <div class="tab-content">

    <div id="detalle" class="tab-pane fade in active">
      <div class="form-group" id='test'>
          <div class="col-sm-12">
              <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                  <div style="overflow:auto; height:350px;">
                      <div style="width: 100%; display: inline-block;">
                          <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="detalle.agregarCampos(valorDetalle,'A');">
                            <span class="glyphicon glyphicon-plus"></span>
                          </div>
                          <div class="col-md-1 requiredMulti" style="width: 400px;height: 42px;" >Tipo de Calidad</div>
                          <div class="col-md-1 requiredMulti" style="width: 150px;height: 42px;" >Cantidad</div>
                          <div id="contenedor_detalle">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

  </div>

    <br>
	@if(isset($ejecuciontrabajo))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary", "onclick"=>"validarFormulario(event);"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary", "onclick"=>"validarFormulario(event);"])!!}
 	@endif
	{!! Form::close() !!}
</div>

@stop