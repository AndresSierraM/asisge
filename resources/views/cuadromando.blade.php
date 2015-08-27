@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Cuadro de Mando</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/cuadromando.js')!!}
  <script>
    var idCompaniaObjetivo = '<?php echo isset($idCompaniaObjetivo) ? $idCompaniaObjetivo : "";?>';
    var nombreCompaniaObjetivo = '<?php echo isset($nombreCompaniaObjetivo) ? $nombreCompaniaObjetivo : "";?>';

    var idProceso = '<?php echo isset($idProceso) ? $idProceso : "";?>';
    var nombreProceso = '<?php echo isset($nombreProceso) ? $nombreProceso : "";?>';

    var idFrecuenciaMedicion = '<?php echo isset($idFrecuenciaMedicion) ? $idFrecuenciaMedicion : "";?>';
    var nombreFrecuenciaMedicion = '<?php echo isset($nombreFrecuenciaMedicion) ? $nombreFrecuenciaMedicion : "";?>';
    
    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreTercero = '<?php echo isset($nombreTercero) ? $nombreTercero : "";?>';

    var cuadromandoDetalle = '<?php echo (isset($cuadromando) ? json_encode($cuadromando->cuadromandoDetalle) : "");?>';
    cuadromandoDetalle = (cuadromandoDetalle != '' ? JSON.parse(cuadromandoDetalle) : '');
    var valorDetalle = ['','','','','',0,'','',''];

    $(document).ready(function(){


      detalle = new Atributos('detalle','contenedor_detalle','detalle_');
      detalle.campos   = ['CompaniaObjetivo_idCompaniaObjetivo',  'Proceso_idProceso',  'objetivoEspecificoCuadroMandoDetalle', 'indicadorCuadroMandoDetalle','operadorMetaCuadroMandoDetalle', 'valorMetaCuadroMandoDetalle','tipoMetaCuadroMandoDetalle', 'FrecuenciaMedicion_idFrecuenciaMedicion','Tercero_idResponsable'];
      detalle.etiqueta = ['select',                               'select',             'textarea',                             'input',                      'select',                         'input',                      'select',                     'select',                                 'select'];
      detalle.tipo     = ['',                                     '',                   'textarea',                             'text',                       '',                               'text',                       '',                           '',                                       ''];
      detalle.estilo   = ['vertical-align:top; width: 170px;height:35px;',            
                          'vertical-align:top; width: 130px;height:35px;',
                          'vertical-align:top; width: 200px;height:35px;',
                          'vertical-align:top; width: 150px;height:35px;',
                          'vertical-align:top; width: 40px;height:35px;',
                          'vertical-align:top; text-align: center; width: 50px;height:35px;',
                          'vertical-align:top; width: 40px;height:35px;',
                          'vertical-align:top; width: 100px;height:35px;',
                          'vertical-align:top; width: 150px;height:35px;'];
      detalle.clase   =  ['chosen-select form-control',
                          'chosen-select form-control',
                          '',
                          '',
                          'chosen-select form-control',
                          '',
                          'chosen-select form-control',
                          'chosen-select form-control',
                          'chosen-select form-control'];
      detalle.sololectura = [false,false,false,false,false,false,false,false,false];


      detalle.nombreCompaniaObjetivo =  JSON.parse(nombreCompaniaObjetivo);
      detalle.valorCompaniaObjetivo =  JSON.parse(idCompaniaObjetivo);

      detalle.nombreProceso =  JSON.parse(nombreProceso);
      detalle.valorProceso =  JSON.parse(idProceso);

      detalle.nombreFrecuenciaMedicion =  JSON.parse(nombreFrecuenciaMedicion);
      detalle.valorFrecuenciaMedicion =  JSON.parse(idFrecuenciaMedicion);

      //detalle.nombreoperadorMeta =  JSON.parse(nombreoperadorMeta);

      //detalle.nombretipoMeta =  JSON.parse(nombretipoMeta);

      detalle.nombreTercero =  JSON.parse(nombreTercero);
      detalle.valorTercero =  JSON.parse(idTercero);
      
      for(var j=0, k = cuadromandoDetalle.length; j < k; j++)
      {
        detalle.agregarCampos(JSON.stringify(cuadromandoDetalle[j]),'L');
      }

    });

  </script>
	@if(isset($cuadromando))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($cuadromando,['route'=>['cuadromando.destroy',$cuadromando->idRol],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($cuadromando,['route'=>['cuadromando.update',$cuadromando->idRol],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'cuadromando.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<fieldset id="cuadromando-form-fieldset">	
		  <div class="form-group" id='test'>
          {!! Form::label('politicasCuadroMando', 'Pol&iacute;ticas', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::textarea('politicasCuadroMando',null,['class'=>'ckeditor','placeholder'=>'Ingresa las políticas de la compania'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>

      <div class="panel-body">
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid">
                <div class="col-md-1" style="width: 40px; height:60px; text-align: center;" 
                      onclick="detalle.agregarCampos(valorDetalle,'A')">
                  <span class="glyphicon glyphicon-plus"></span>
                </div>
                <div class="col-md-1" style="width: 170px; height:60px; text-align: center;">Objetivos Estrat&eacute;gicos</div>
                <div class="col-md-1" style="width: 130px; height:60px; text-align: center;">Proceso</div>
                <div class="col-md-1" style="width: 200px; height:60px; text-align: center;">Objetivos Espec&iacute;ficos del Proceso</div>
                <div class="col-md-1" style="width: 150px; height:60px; text-align: center;">Nombre del Indicador</div>
                <div class="col-md-1" style="width: 130px; height:60px; text-align: center;">Meta</div>
                <div class="col-md-1" style="width: 100px; height:60px; text-align: center;">Frecuencia Medici&oacute;n</div>
                <div class="col-md-1" style="width: 150px; height:60px; text-align: center;">Responsable de la Actividad</div>
                <div id="contenedor_detalle">
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($cuadromando))
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