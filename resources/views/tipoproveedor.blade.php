@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Tipo de Proveedor</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/tipoproveedor.js')!!}

	@if(isset($tipoproveedor))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoproveedor,['route'=>['tipoproveedor.destroy',$tipoproveedor->idTipoProveedor],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoproveedor,['route'=>['tipoproveedor.update',$tipoproveedor->idTipoProveedor],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipoproveedor.store','method'=>'POST'])!!}
	@endif


<script>
    
    var proveedorseleccion = '<?php echo (isset($tipoproveedor) ? json_encode($tipoproveedor->tipoProveedorSeleccion) : "");?>';
    proveedorseleccion = (proveedorseleccion != '' ? JSON.parse(proveedorseleccion) : '');

    var valorCriterioSeleccion = [0, '', 0];

    var proveedorevaluacion = '<?php echo (isset($tipoproveedor) ? json_encode($tipoproveedor->tipoProveedorEvaluacion) : "");?>';
    proveedorevaluacion = (proveedorevaluacion != '' ? JSON.parse(proveedorevaluacion) : '');

    valorEvaluacion =  Array("Calidad","Cantidad", "Precio");
    nombreEvaluacion =  Array("Calidad","Cantidad", "Precio");
    var criterioevaluacion = [valorEvaluacion,nombreEvaluacion];

    var validarPesoEvaluacion = ['onchange','validarPesoCriterioEvaluacion(this.value)'];

    var valorCriterioEvaluacion = [0, '', 0, 0];

    $(document).ready(function(){

      // -------------------------
      // CRITERIOS DE SELECCION
      // -------------------------

      seleccion = new Atributos('seleccion','contenedor_seleccion','seleccion_');

      seleccion.altura = '35px';
      seleccion.campoid = 'idTipoProveedorSeleccion';
      seleccion.campoEliminacion = 'eliminarTipoProveedorSeleccion';

      seleccion.campos   = [
      'idTipoProveedorSeleccion',
      'descripcionTipoProveedorSeleccion',
      'TipoProveedor_idTipoProveedor'
      ];

      seleccion.etiqueta = [
      'input',
      'input',
      'input'
      ];

      seleccion.tipo = [
      'hidden',
      'text',
      'hidden'
      ];

      seleccion.estilo = [
      '',
      'width: 900px;height:35px;',
      ''
      ];

      seleccion.clase    = ['','',''];
      seleccion.sololectura = [true,false,true];  
      seleccion.funciones = ['','',''];
      seleccion.completar = ['off','off','off'];
      seleccion.opciones = ['','',''];

      for(var j=0, k = proveedorseleccion.length; j < k; j++)
      {
        seleccion.agregarCampos(JSON.stringify(proveedorseleccion[j]),'L');
      }

      // -------------------------
      // CRITERIOS DE EVALUACION
      // -------------------------

      evaluacion = new Atributos('evaluacion','contenedor_evaluacion','evaluacion_');

      evaluacion.altura = '35px';
      evaluacion.campoid = 'idTipoProveedorEvaluacion';
      evaluacion.campoEliminacion = 'eliminarTipoProveedorEvaluacion';

      evaluacion.campos   = [
      'idTipoProveedorEvaluacion',
      'descripcionTipoProveedorEvaluacion',
      'pesoTipoProveedorEvaluacion',
      'TipoProveedor_idTipoProveedor'
      ];

      evaluacion.etiqueta = [
      'input',
      'select',
      'input',
      'input'
      ];

      evaluacion.tipo = [
      'hidden',
      '',
      'text',
      'hidden'
      ];

      evaluacion.estilo = [
      '',
      'width: 700px;height:35px;',
      'width: 200px;height:35px;',
      ''
      ];

      evaluacion.clase    = ['','','',''];
      evaluacion.sololectura = [true,false,false,true];  
      evaluacion.funciones = ['','',validarPesoEvaluacion,''];
      evaluacion.completar = ['off','off','off','off'];
      evaluacion.opciones = ['',criterioevaluacion,'',''];

      for(var j=0, k = proveedorevaluacion.length; j < k; j++)
      {
        evaluacion.agregarCampos(JSON.stringify(proveedorevaluacion[j]),'L');
      }

    });
</script>

<div id='form-section' >

	<fieldset id="tipoproveedor-form-fieldset">	

		<div class="form-group" id='test'>
      {!!Form::label('codigoTipoProveedor', 'Código', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-barcode"></i>
          </span>
          {!!Form::text('codigoTipoProveedor',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la TipoProveedor'])!!}
          {!!Form::hidden('idTipoProveedor', null, array('id' => 'idTipoProveedor')) !!}
        </div>
      </div>
    </div>

    <div class="form-group" id='test'>
      {!!Form::label('nombreTipoProveedor', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
      <div class="col-sm-10">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::text('nombreTipoProveedor',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la TipoProveedor'])!!}
        </div>
      </div>
    </div>

    <div class="form-group">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Criterios</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">

                <ul class="nav nav-tabs"> <!--Pestañas de navegacion-->
                  <li class="active"><a data-toggle="tab" href="#divseleccion">Criterios de Selección</a></li>
                  <li><a data-toggle="tab" href="#divevaluacion">Criterios de Evaluación</a></li>
                </ul>

                <div class="tab-content">
                  
                  <div id="divseleccion" class="tab-pane fade in active">

                    <div class="panel-body">
                      <div class="form-group" id='test'>
                        <div class="col-sm-12">
                          <div class="row show-grid">
                            <div class="col-md-1" style="width: 40px; height: 42px; cursor: pointer;" onclick="seleccion.agregarCampos(valorCriterioSeleccion,'A')">
                              <span class="glyphicon glyphicon-plus"></span>
                            </div>
                            <div class="col-md-1" style="width: 900px;">Descripción del criterio</div>
                            <div id="contenedor_seleccion"> 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div id="divevaluacion" class="tab-pane fade" >

                    <div class="panel-body">
                      <div class="form-group" id='test'>
                        <div class="col-sm-12">
                          <div class="row show-grid">
                            <div class="col-md-1" style="width: 40px; height: 42px; cursor: pointer;" onclick="evaluacion.agregarCampos(valorCriterioEvaluacion,'A')">
                              <span class="glyphicon glyphicon-plus"></span>
                            </div>
                            <div class="col-md-1" style="width: 700px;">Descripción del criterio</div>
                            <div class="col-md-1" style="width: 200px;">Peso del criterio</div>
                            <div id="contenedor_evaluacion"> 
                            </div>
                          </div>
                          <!-- Se agrega el div para que muestre el error-->
                          <div id="totalevaluacion" class="btn btn-danger" style="display:none;"></div>
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
	@if(isset($tipoproveedor))
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
@stop