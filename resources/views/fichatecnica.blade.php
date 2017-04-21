@extends('layouts.grid')

@section('titulo')<h3 id="titulo"><center>Ficha Técnica</center></h3>@stop

@section('content')
@include('alerts.request')

<script type="">
    var procesos = '<?php echo (isset($proceso) ? json_encode($proceso) : "");?>';
    procesos = (procesos != '' ? JSON.parse(procesos) : '');

    var materiales = '<?php echo (isset($material) ? json_encode($material) : "");?>';
    materiales = (materiales != '' ? JSON.parse(materiales) : '');

    var operaciones = '<?php echo (isset($operacion) ? json_encode($operacion) : "");?>';
    operaciones = (operaciones != '' ? JSON.parse(operaciones) : '');

    var valorProceso = ['','','','','','','',''];

</script>

{!!Html::script('js/fichatecnica.js')!!}


	@if(isset($fichatecnica))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($fichatecnica,['route'=>['fichatecnica.destroy',$fichatecnica->idFichaTecnica],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($fichatecnica,['route'=>['fichatecnica.update',$fichatecnica->idFichaTecnica],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'fichatecnica.store','method'=>'POST'])!!}
	@endif

<?php 
$fechahora = Carbon\Carbon::now();
?>



<div id='form-section' >
	<fieldset id="fichatecnica-form-fieldset">	
    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('LineaProducto_idLineaProducto', 'Linea', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('LineaProducto_idLineaProducto',$linea, @$fichatecnica->LineaProducto_idLineaProducto,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
        </div>
      </div>
    </div>	

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('SublineaProducto_idSublineaProducto', 'Sublinea', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::select('SublineaProducto_idSublineaProducto',$sublinea, @$fichatecnica->SublineaProducto_idSublineaProducto ,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('Tercero_idTercero', 'Cliente', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('Tercero_idTercero',$tercero, @$fichatecnica->Tercero_idTercero,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
        </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('referenciaClienteFichaTecnica', 'Referencia Cliente', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('referenciaClienteFichaTecnica',null,['class'=>'form-control', "placeholder" => "Ingrese Referencia del Cliente"])!!}
            {!!Form::hidden('idFichaTecnica',null,['id'=>'idFichaTecnica'])!!}
            {!!Form::hidden('eliminarProceso',null,['id'=>'eliminarProceso'])!!}
            {!!Form::hidden('eliminarMaterial',null,['id'=>'eliminarMaterial'])!!}
            {!!Form::hidden('eliminarOperacion',null,['id'=>'eliminarOperacion'])!!}
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
            {!!Form::text('referenciaFichaTecnica',null,['class'=>'form-control', "placeholder" => "Ingrese Referencia"])!!}
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
            {!!Form::text('nombreFichaTecnica',null,['class'=>'form-control', "placeholder" => "Ingrese Descripción del producto"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('fechaCreacionFichaTecnica', 'Fecha Creación', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('fechaCreacionFichaTecnica',(isset($fichatecnica) ? $fichatecnica->fechaCreacionFichaTecnica : $fechahora),['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('estadoFichaTecnica', 'Estado', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::select('estadoFichaTecnica',['Prototipo'=>'Prototipo','Muestra'=>'Muestra','Aprobado'=>'Aprobado'], @$fichatecnica->estadoFichaTecnica,["class" => "chosen-select form-control"])!!}
          </div>
      </div>
    </div>  

  </fieldset>



<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#imagen">Imágenes</a></li>
  <li><a data-toggle="tab" href="#proceso">Ruta de Procesos</a></li>
  <li><a data-toggle="tab" href="#material">Materiales</a></li>
  <li><a data-toggle="tab" href="#operacion">Operaciones</a></li>
  <li><a data-toggle="tab" href="#adjunto">Adjuntos</a></li>
  <li><a data-toggle="tab" href="#nota">Notas</a></li>
  <li><a data-toggle="tab" href="#auditoria">Auditoría</a></li>
</ul>

<div class="tab-content">
  <div id="imagen" class="tab-pane fade in active">


  </div>

  <div id="proceso" class="tab-pane fade">
    <div class="form-group" id='test'>
        <div class="col-sm-12">
            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                <div style="overflow:auto; height:350px;">
                    <div style="width: 100%; display: inline-block;">
                        <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="abrirModalProceso(materiales);">
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
    <div id='tabsMaterial'>
      <ul class="nav nav-tabs">
      </ul>
    </div>

  </div>
  <div id="operacion" class="tab-pane fade">
    <div id='tabsOperacion'>
      <ul class="nav nav-tabs">
      </ul>
    </div>

  </div>
  <div id="adjunto" class="tab-pane fade">
    

  </div>
  <div id="nota" class="tab-pane fade">
    

  </div>
  <div id="auditoria" class="tab-pane fade">
    

  </div>
</div>

    <br>
	@if(isset($fichatecnica))
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

<div id="ModalProceso" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Conceptos</h4>
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