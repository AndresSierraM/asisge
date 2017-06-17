@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Recibo de Compra</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/recibocompra.js'); !!}
	@if(isset($recibocompra))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($recibocompra,['route'=>['recibocompra.destroy',$recibocompra->idReciboCompra],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($recibocompra,['route'=>['recibocompra.update',$recibocompra->idReciboCompra],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'recibocompra.store','method'=>'POST'])!!}
	@endif


<script type="text/javascript">

  var idTipoCalidad = '<?php echo isset($idTipoCalidad) ? $idTipoCalidad : "";?>';
  var nombreTipoCalidad = '<?php echo isset($nombreTipoCalidad) ? $nombreTipoCalidad : "";?>';
  var tipocalidad = [JSON.parse(idTipoCalidad), JSON.parse(nombreTipoCalidad)];

  var reciboordencompra = '<?php echo (isset($reciboCompraProducto) ? json_encode($reciboCompraProducto) : "");?>';
  reciboordencompra = (reciboordencompra != '' ? JSON.parse(reciboordencompra) : '');

  calcultarValorCantidad = ['onchange','calcularValorTotal(this.id, "cantidad")'];
  calcultarValorUnitario = ['onchange','calcularValorTotal(this.id, "unitario")'];

  valorReciboCompra = ['','','',1,1,1,''];

  $(document).ready(function(){

      producto = new Atributos('producto','contenedor_recibo','recibos_');

      producto.altura = '35px';
      producto.campoid = 'idReciboCompraProducto';
      producto.campoEliminacion = 'eliminarReciboCompraProducto';

      producto.campos   = [
      'FichaTecnica_idFichaTecnica',
      'referenciaReciboCompraProducto',
      'descripcionReciboCompraProducto',
      'cantidadOrdenCompraProducto',
      'cantidadReciboCompraProducto',
      'TipoCalidad_idTipoCalidad',
      'valorUnitarioOrdenCompraProducto',
      'valorUnitarioReciboCompraProducto',
      'valorTotalReciboCompraProducto',
      'idReciboCompraProducto'];

      producto.etiqueta = [
      'input',
      'input',
      'input',
      'input',
      'input',
      'select',
      'input',
      'input',
      'input',
      'input'];

      producto.tipo     = [
      'hidden',
      'text',
      'text',
      'text',
      'text',
      'text',
      '',
      'text',
      'text',
      'hidden'];
      
      producto.estilo   = [
      '',
      'width: 100px;height:35px;',
      'width: 300px; height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      'width: 100px;height:35px;',
      ''];

      producto.clase = ['','','','','','','','','','']; 
      producto.sololectura = [true,true,true,true,false,false,true,false,true,false]; 
      producto.completar = ['off','off','off','off','off','off', 'off', 'off', 'off', 'off']; 
      producto.opciones = ['','','','','',tipocalidad,'', '', '', '']; 
      producto.funciones  = ['','','','',calcultarValorCantidad,'','', calcultarValorUnitario, '', ''];

    for(var j=0, k = reciboordencompra.length; j < k; j++)
    {
      producto.agregarCampos(JSON.stringify(reciboordencompra[j]),'L');
      calcularValorTotal(j, ''); 
    }
  });
</script>


<div id='form-section' >

	<fieldset id="recibocompra-form-fieldset">	
    <input type="hidden" id="token" value="{{csrf_token()}}"/>
		<div class="form-group col-md-6" id='test'>
      {!!Form::label('numeroReciboCompra', 'Número', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </span>
          {!!Form::text('numeroReciboCompra',(isset($recibocompra) ? $recibocompra->numeroReciboCompra : $numeroRecibo),['class'=>'form-control', 'readonly'])!!}
          {!!Form::hidden('idReciboCompra', null, array('id' => 'idReciboCompra')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('OrdenCompra_idOrdenCompra', 'Orden de compra', array('class' => 'col-sm-4 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-tasks"></i>
          </span>
          {!!Form::text('numeroOrdenCompra',null,['class'=>'form-control', 'readonly', 'id' => 'numeroOrdenCompra'])!!}
          {!!Form::hidden('OrdenCompra_idOrdenCompra', null, array('id' => 'OrdenCompra_idOrdenCompra')) !!}
          <span class="input-group-addon" title="Adicionar orden de compra" style="cursor:pointer;" onclick="abrirModalOrdenCompra()">
            <i class="fa fa-file"></i>
          </span>
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaElaboracionReciboCompra', 'Elaboración', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaElaboracionReciboCompra',(isset($recibocompra) ? $recibocompra->fechaElaboracionReciboCompra : date('Y-m-d')),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaEstimadaReciboCompra', 'Est. Entrega', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaEstimadaReciboCompra',null,['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('fechaRealReciboCompra', 'Entrega', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!!Form::text('fechaRealReciboCompra',null,['class'=>'form-control'])!!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('Tercero_idProveedor', 'Proveedor', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::text('nombreProveedor',null,['class'=>'form-control', 'readonly', 'id' => 'nombreProveedor'])!!}
          {!!Form::hidden('Tercero_idProveedor', (isset($ordencompra) ? $ordencompra['Tercero_idProveedor'] : null), array('id' => 'Tercero_idProveedor')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('Users_idCrea', 'Solicitante', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-user"></i>
          </span>
          {!!Form::text('nombreElaborador',(isset($elaborador) ? $creador['nombreElaborador'] : \Session::get('nombreUsuario')),['class'=>'form-control', 'readonly'])!!}
          {!!Form::hidden('Users_idCrea', (isset($creador) ? $creador['idUsuario'] : \Session::get('idUsuario')), array('id' => 'Users_idCrea')) !!}
        </div>
      </div>
    </div>

    <div class="form-group col-md-6" id='test'>
      {!!Form::label('estadoReciboCompra', 'Estado', array('class' => 'col-sm-3 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-bars"></i>
          </span>
          {!!Form::text('estadoReciboCompra',(isset($recibocompra) ? $recibocompra->estadoReciboCompra : 'Activo'),['class'=>'form-control', 'readonly'])!!}
        </div>
      </div>
    </div>

    <br><br><br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Reciboes</div>
              <div class="panel-body">
                <div class="form-group" id='test'>
                  <div class="col-sm-12">
                    <div class="row show-grid">
                      <div class="col-md-1" style="width: 40px;height: 50px; cursor: pointer;" onclick="producto.agregarCampos(valorReciboCompra,'A')">
                        <span class="glyphicon glyphicon-plus"></span>
                      </div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Referencia</div>
                      <div class="col-md-1" style="width: 300px;display:inline-block;height:50px;">Descripción</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Cantidad OC</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Cantidad Recibo</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Tipo Calidad</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Costo OC</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Costo Recibo</div>
                      <div class="col-md-1" style="width: 100px;display:inline-block;height:50px;">Valor Total</div>
                        
                      <div id="contenedor_recibo">
                      </div>
                    </div>
                  </div>
                </div>  

                <div class="form-group col-md-6" id='test' style="display:inline-block">
                  <button class="btn btn-primary" type="button" onclick="calcularTotales()">Calcular</button>
                </div>

                <div class="form-group col-md-6" id='test' style="display:inline-block">
                  {!!Form::label('totalProducto', 'Valor Total Productos: ', array('class' => 'col-sm-2 control-label')) !!}
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-dollar"></i>
                      </span>
                      {!!Form::text('totalProducto',null,['class'=>'form-control','readonly', 'placeholder'=>''])!!}
                    </div>
                  </div>
                </div>
                {!!Form::hidden('eliminarReciboCompraProducto', null, array('id' => 'eliminarReciboCompraProducto'))!!}
              </div>
            </div>
          </div>
        </div>

        <div class="form-group col-md-12" id='test'>
          {!!Form::label('observacionReciboCompra', 'Observaciones', array('class' => 'col-sm-3 control-label')) !!}
          <div class="col-sm-12">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
              {!!Form::textarea('observacionReciboCompra',null,['class'=>'form-control ckeditor','style'=>'height:100px'])!!}
            </div>
          </div>
        </div>

    </fieldset>
	@if(isset($recibocompra))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary", 'onclick' =>'validarFormulario(event)'])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary", 'onclick' =>'validarFormulario(event)'])!!}
 	@endif

	{!! Form::close() !!}
</div>
<script>
  CKEDITOR.replace(('observacionReciboCompra'), {
      fullPage: true,
      allowedContent: true
    });  

  $(document).ready( function () {

    $("#fechaRealReciboCompra").datetimepicker(
      ({
        format: "YYYY-MM-DD"
      })
    );
});
</script>
@stop

<div id="modalOrdenCompra" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Orden de Compra</h4>
      </div>
      <div class="modal-body">
        <div id="divTabla" class="container">
            <div class="row" style="width:90%;">
                <div class="container" style="width:100%;">
                    <table id="tordencompra" name="tordencompra" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>ID</b></th>
                                <th><b>Número de Orden</b></th>
                                <th><b>Estimado de entrega</b></th>
                                <th><b>Proveedor</b></th>
                                <th><b>ID Proveedor</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>ID</th>
                                <th>Número de Orden</th>
                                <th>Estimado de entrega</th>
                                <th>ID Proveedor</th>
                                <th>Proveedor</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>