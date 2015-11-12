@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Programa</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::script('js/programa.js')!!}

  <script>
    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

    var idDocumento = '<?php echo isset($idDocumento) ? $idDocumento : "";?>';
    var nombreDocumento = '<?php echo isset($nombreDocumento) ? $nombreDocumento : "";?>';

    var programaDetalle = '<?php echo (isset($programa) ? json_encode($programa->programaDetalle) : "");?>';
    programaDetalle = (programaDetalle != '' ? JSON.parse(programaDetalle) : '');
    var valorPrograma = ['',0,0,'',0,'',0,''];

    $(document).ready(function(){


      programa = new Atributos('programa','contenedor_programa','programa_');
      programa.campos    = ['actividadProgramaDetalle', 'Tercero_idResponsable', 'Documento_idDocumento',
                            'fechaPlaneadaProgramaDetalle', 'recursoPlaneadoProgramaDetalle', 
                            'fechaEjecucionProgramaDetalle','recursoEjecutadoProgramaDetalle', 
                             'observacionProgramaDetalle'];
      programa.etiqueta  = ['input', 'select1','select2',  
                            'input', 'input',
                            'input', 'input', 
                            'input'];
      programa.tipo      = ['text', '', '',
                            'text', 'text', 
                            'text', 'text', 
                            'text'];
      programa.estilo    = ['width: 400px; height:35px; display:inline-block;', 'width: 200px; height:35px; display:inline-block;', 'width: 200px; height:35px; display:inline-block;', 
                            'width: 200px; height:35px; display:inline-block;', 'width: 100px; height:35px; display:inline-block;', 
                            'width: 200px; height:35px; display:inline-block;', 'width: 100px; height:35px; display:inline-block;', 
                            'width: 300px; height:35px; display:inline-block;'];
      programa.clase     = ['', 'chosen-select', 'chosen-select', 
                            '', '',
                            '', '',
                            ''];
      programa.sololectura = [false,false,false,false,false,false,false,false];
      programa.nombreCompletoTercero =  JSON.parse(nombreCompletoTercero);
      programa.idTercero =  JSON.parse(idTercero);
      programa.nombreDocumento =  JSON.parse(nombreDocumento);
      programa.idDocumento =  JSON.parse(idDocumento);


      for(var j=0, k = programaDetalle.length; j < k; j++)
      {
        programa.agregarCampos(JSON.stringify(programaDetalle[j]),'L');
      }
      document.getElementById('registros').value = j ;
    });

  </script>

	@if(isset($programa))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($programa,['route'=>['programa.destroy',$programa->idPrograma],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($programa,['route'=>['programa.update',$programa->idPrograma],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'programa.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	<fieldset id="programa-form-fieldset">	
	      <div class="form-group" id='test'>
          {!!Form::label('nombrePrograma', 'Programa', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('nombrePrograma',null, ['class'=>'form-control', 'placeholder'=>'Ingresa el nombre del programa', 'style'=>'width:340;'])!!}
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaElaboracionPrograma', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaElaboracionPrograma',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('ClasificacionRiesgo_idClasificacionRiesgo', 'Clasificaci&oacute;n de Riesgo', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              {!!Form::select('ClasificacionRiesgo_idClasificacionRiesgo',$clasificacionriesgo, (isset($programa) ? $programa->ClasificacionRiesgo_idClasificacionRiesgo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la clasificacion de riesgo"])!!}
              {!! Form::hidden('idPrograma', 0, array('id' => 'idPrograma')) !!}
              {!! Form::hidden('Compania_idCompania', 0, array('id' => 'Compania_idCompania')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}

            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('alcancePrograma', 'Alcance', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('alcancePrograma',null, ['class'=>'form-control', 'placeholder'=>'Ingresa el alcance del programa', 'style'=>'width:340;'])!!}
            </div>
          </div>
        </div>
		
		    <div class="form-group" id='test'>
          {!!Form::label('CompaniaObjetivo_idCompaniaObjetivo', 'Objetivo', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              {!!Form::select('CompaniaObjetivo_idCompaniaObjetivo',$companiaobjetivo, (isset($programa) ? $programa->CompaniaObjetivo_idCompaniaObjetivo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el objetivo general"])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('objetivoEspecificoPrograma', 'Objetivo Espec&iacute;fico', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::textarea('objetivoEspecificoPrograma',null,['class'=>'ckeditor','placeholder'=>'Objetivos espec&iacute;ficos del programa'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('Tercero_idElabora', 'Elaborado Por', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              {!!Form::select('Tercero_idElabora',$terceros, (isset($programa) ? $programa->Tercero_idElabora : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Tercero que elabora el programa"])!!}
            </div>
          </div>
        </div>

        <div class="panel-body">
          <div class="form-group" id='test'>

            <div class="col-sm-12">
              <div class="row show-grid">
                <div style="overflow: auto; width: 100%;">
                  <div style="width: 1750px; height: 300px; display: inline-block; ">
                    <div class="col-md-1" style="width: 840px;">&nbsp;</div>
                    <div class="col-md-1" style="width: 300px;">Planeaci&oacute;n</div>
                    <div class="col-md-1" style="width: 300px;">Ejecuci&oacute;n</div>
                    <div class="col-md-1" style="width: 300px;">&nbsp;</div>
                    
                    <div class="col-md-1" style="width: 40px;" onclick="programa.agregarCampos(valorPrograma,'A')">
                      <span class="glyphicon glyphicon-plus"></span>
                    </div>
                      
                    <div class="col-md-1" style="width: 400px;">Actividad</div>
                    <div class="col-md-2" style="width: 200px;">Responsable</div>
                    <div class="col-md-3" style="width: 200px;">Documento</div>
                    <div class="col-md-4" style="width: 200px;">Fecha</div>
                    <div class="col-md-5" style="width: 100px;">Recurso</div>
                    <div class="col-md-6" style="width: 200px;">Fecha</div>
                    <div class="col-md-7" style="width: 100px;">Recurso</div>
                    <div class="col-md-8" style="width: 300px;">Observaci&oacute;n</div>
                    <div id="contenedor_programa">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>
  @if(isset($diagnostico))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @else
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'habilitarSubmit(event);'])!!}
  @endif
	{!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
        $('#fechaElaboracionPrograma').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    
    CKEDITOR.replace(('objetivoEspecificoPrograma'), {
        fullPage: true,
        allowedContent: false
    });

  </script>


	</div>
</div>
@stop