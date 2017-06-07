@extends('layouts.grid')

@section('titulo')<h3 id="titulo"><center>Orden de Producción</center></h3>@stop

@section('content')
@include('alerts.request')

<script type="">
    var procesos = '<?php echo (isset($proceso) ? json_encode($proceso) : "");?>';
    procesos = (procesos != '' ? JSON.parse(procesos) : '');

    var materiales = '<?php echo (isset($material) ? json_encode($material) : "");?>';
    materiales = (materiales != '' ? JSON.parse(materiales) : '');

</script>

{!!Html::script('js/ordenproduccion.js')!!}


	@if(isset($ordenproduccion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($ordenproduccion,['route'=>['ordenproduccion.destroy',$ordenproduccion->idOrdenProduccion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($ordenproduccion,['route'=>['ordenproduccion.update',$ordenproduccion->idOrdenProduccion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'ordenproduccion.store','method'=>'POST'])!!}
	@endif

<?php 
  $fechahora = Carbon\Carbon::now();
?>



<div id='form-section' >
	<fieldset id="ordenproduccion-form-fieldset">	
    

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroOrdenProduccion', 'Número O.P.', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('numeroOrdenProduccion',(isset($ordenproduccion) ? null : 'Automático'),['class'=>'form-control', "placeholder" => "Número orden Produccion", "readOnly"=>"readOnly"])!!}
            {!!Form::hidden('idOrdenProduccion',null,['id'=>'idOrdenProduccion'])!!}
            {!!Form::hidden('eliminarProceso',null,['id'=>'eliminarProceso'])!!}
            {!!Form::hidden('eliminarMaterial',null,['id'=>'eliminarMaterial'])!!}
            <input type="hidden" id="token" value="{{csrf_token()}}"/>
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('fechaElaboracionOrdenProduccion', 'Fecha Elaboración', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('fechaElaboracionOrdenProduccion',(isset($ordenproduccion) ? $ordenproduccion->fechaElaboracionOrdenProduccion : $fechahora),['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('Tercero_idCliente', 'Cliente', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('Tercero_idCliente',$tercero, @$ordenproduccion->Tercero_idCliente,["class" => "chosen-select form-control", "placeholder" => "Seleccione el Cliente"])!!}
        </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('numeroPedidoOrdenProduccion', 'Orden Compra No.', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('numeroPedidoOrdenProduccion',null,['class'=>'form-control', "placeholder" => "Ingrese Orden de Compra"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('prioridadOrdenProduccion', 'Prioridad', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::select('prioridadOrdenProduccion',['Alta'=>'Alta','Media'=>'Media','Baja'=>'Baja'], @$ordenproduccion->prioridadOrdenProduccion,["class" => "chosen-select form-control"])!!}
          </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('fechaMaximaEntregaOrdenProduccion', 'Fecha Máxima', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('fechaMaximaEntregaOrdenProduccion',(isset($ordenproduccion) ? $ordenproduccion->fechaMaximaEntregaOrdenProduccion : $fechahora),['class'=>'form-control'])!!}
          </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('FichaTecnica_idFichaTecnica', 'Referencia', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('FichaTecnica_idFichaTecnica',$fichatecnica, @$ordenproduccion->FichaTecnica_idFichaTecnica,["onchange" => "cargarProcesos();cargarMateriales();", "class" => "chosen-select form-control", "placeholder" => "Seleccione el Producto"])!!}
        </div>
      </div>
    </div> 

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('especificacionOrdenProduccion', 'Especificación', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('especificacionOrdenProduccion',null,['class'=>'form-control', "placeholder" => "Especificación del producto"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('estadoOrdenProduccion', 'Estado', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::select('estadoOrdenProduccion',['Programada'=>'Programada','Proceso'=>'Proceso','Anulada'=>'Anulada'], @$ordenproduccion->estadoOrdenProduccion,["class" => "chosen-select form-control"])!!}
          </div>
      </div>
    </div> 

     <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('cantidadOrdenProduccion', 'Cantidad', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('cantidadOrdenProduccion',null,['class'=>'form-control', "placeholder" => "Cantidad a producir", "onblur" => "cargarMateriales();"])!!}
          </div>
      </div>
    </div> 
  </fieldset>



<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#proceso">Ruta de Procesos</a></li>
  <li><a data-toggle="tab" href="#material">Req. Materiales</a></li>
</ul>

<div class="tab-content">

  <div id="proceso" class="tab-pane fade in active">
    <div class="form-group" id='test'>
        <div class="col-sm-12">
            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                <div style="overflow:auto; height:350px;">
                    <div style="width: 100%; display: inline-block;">
                        <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="abrirModalProceso();">
                          <span class="glyphicon glyphicon-plus"></span>
                        </div>
                        <div class="col-md-1" style="width: 100px;" >Orden</div>
                        <div class="col-md-1" style="width: 400px;" >Proceso</div>
                        <div class="col-md-1" style="width: 400px;" >Observaciones</div>
                        <div id="contenedor_proceso">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div id="material" class="tab-pane fade">
    <div class="form-group" id='test'>
        <div class="col-sm-12">
            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                <div style="overflow:auto; height:350px;">
                    <div style="width: 100%; display: inline-block;">
                        <div class="col-md-1" style="width: 500px;" >Material</div>
                        <div class="col-md-1" style="width: 200px;" >Consumo Unitario</div>
                        <div class="col-md-1" style="width: 200px;" >Consumo Total</div>
                        <div id="contenedor_material">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  
</div>

    <br>
	@if(isset($ordenproduccion))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary", "onclick"=>'validarFormulario(event);'])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary", "onclick"=>'validarFormulario(event);'])!!}
 	@endif
	{!! Form::close() !!}
</div>



@stop

<div id="ModalProceso" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Procesos</h4>
      </div>
      <div class="modal-body">
         <div class="container">
            <div class="row">
                <div class="container">
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button  type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                       <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Código</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Proceso</label></a></li>
                            
                        </ul>
                    </div>
                    
                    <table id="tproceso" name="tproceso" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">

                                <th><b>ID</b></th>
                                <th><b>Código</b></th>
                                <th><b>Proceso</b></th>        
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">

                                <th>ID</th>
                                <th>Código</th>
                                <th>Proceso</th>                             
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal-footer">
                        <button id="botonCampo" name="botonCampo" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>

                

                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>
